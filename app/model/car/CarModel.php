<?php

namespace app\model\car;

use app\core\logger\SystemLog;
use app\model\BaseModel;
use Exception;
use PDO;

class CarModel extends BaseModel {

    public function getAllCars(): array {

        $result = [];

        try {
            $query = 'SELECT * FROM cars WHERE deleted_at IS NULL';

            $statement = $this->pdo->prepare($query);
            $statement->execute();
            $res = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($res)) {
                foreach ($res as $row) {
                    $result[] = new Car($row);
                }
            }

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
        return $result;
    }


    public function delete($car_id, $softDelete = true): bool {

        try {

            if ($softDelete === true) {
                //TODO ,soft micsoda?
                $query = 'UPDATE cars SET deleted_at=:deleted_at WHERE id=:id';
                $params = [
                    'id'         => $car_id,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ];
            } else {
                $query = 'DELETE FROM cars WHERE id=?';
                $params = [$car_id];
            }

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'delete');
        }

        return false;
    }


    public function getCarById($carId) {

        try {

            $query = 'SELECT * FROM cars WHERE id=? AND deleted_at IS NULL LIMIT 1';
            $statement = $this->pdo->prepare($query);
            $statement->execute([$carId]);
            return $statement->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }
    }


    public function getById($id): ?Car {

        try {
            $query = 'SELECT * FROM cars WHERE id=? AND deleted_at IS NULL LIMIT 1';
            $params = [$id];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                return new Car($result);
            }
        } catch (Exception $exception) {
            die($exception->getMessage());
        }

        return null;
    }


    public function update(Car $car): bool {

        try {
            $query = '
            UPDATE cars
            SET type=:type,
                color=:color,
                kilometers_traveled=:kilometers_traveled,
                year_of_manufacture=:year_of_manufacture,
                type_of_fuel=:type_of_fuel,
                car_condition=:car_condition,
                updated_at=:updated_at
            
            WHERE id=:id';

            $params = [
                'id'                  => $car->getId(),
                'type'                => $car->getType(),
                'color'               => $car->getColor(),
                'kilometers_traveled' => $car->getKilometersTraveled(),
                'year_of_manufacture' => $car->getYearOfManufacture(),
                'type_of_fuel'        => $car->getTypeOfFuel(),
                'car_condition'       => $car->getCarCondition(),
                'updated_at'          => $car->getUpdatedAt()
            ];

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    public function insert(Car $car): bool {

        try {
            $query = '
            INSERT INTO cars( type, color, kilometers_traveled, year_of_manufacture, type_of_fuel, car_condition, deleted_at, updated_at, created_at, id_of_owner) 
            VALUES( :type, :color, :kilometers_traveled, :year_of_manufacture, :type_of_fuel, :car_condition, :deleted_at, :updated_at, :created_at, :id_of_owner)
            ';
            $params = [
                'type'                => $car->getType(),
                'color'               => $car->getColor(),
                'kilometers_traveled' => $car->getKilometersTraveled(),
                'year_of_manufacture' => $car->getYearOfManufacture(),
                'type_of_fuel'        => $car->getTypeOfFuel(),
                'car_condition'       => $car->getCarCondition(),
                'created_at'          => $car->getCreatedAt(),
                'updated_at'          => $car->getUpdatedAt(),
                'deleted_at'          => $car->getDeletedAt(),
                'id_of_owner'         => $car->getIdOfOwner()
            ];
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return $this->pdo->lastInsertId();

        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }

    }


}
