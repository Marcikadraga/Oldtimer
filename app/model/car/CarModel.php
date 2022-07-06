<?php

namespace app\model\car;

use app\controller\BaseController;
use app\core\logger\SystemLog;
use app\core\pdo\CustomStatementDebug;
use app\core\pdo\PDOConnect;
use app\model\carType\CarType;
use app\model\user\User;
use Exception;
use PDO;
use app\model\BaseModel;

class CarModel extends BaseModel {

    public function insert(Car $car): ?int {

        try {
            $query = '
        
        INSERT INTO cars(color, kilometers_traveled, year_of_manufacture, type_of_fuel, car_condition,id_of_owner, deleted_at, updated_at, created_at)
        VALUES(:color, :kilometers_traveled, :year_of_manufacture, :type_of_fuel, :car_condition,:id_of_owner, :deleted_at, :updated_at, :created_at)
        ';

            $params = [
                'color'               => $car->getColor(),
                'kilometers_traveled' => $car->getKilometersTraveled(),
                'year_of_manufacture' => $car->getYearOfManufacture(),
                'type_of_fuel'        => $car->getTypeOfFuel(),
                'car_condition'       => $car->getCarCondition(),
                'deleted_at'          => $car->getDeletedAt(),
                'updated_at'          => $car->getUpdatedAt(),
                'created_at'          => $car->getCreatedAt(),
                'id_of_owner'         => $car->getIdOfOwner(),
            ];
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return $this->pdo->lastInsertId();

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'select');
        }

        return false;
    }


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
            //TODO: tovább van dobva az exception
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
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                return new Car($result[0]);
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
                car_condition=:car_condition
            
            WHERE id=:id';

            $params = [
                'id'                  => $car->getId(),
                'type'                => $car->getType(),
                'color'               => $car->getColor(),
                'kilometers_traveled' => $car->getKilometersTraveled(),
                'year_of_manufacture' => $car->getYearOfManufacture(),
                'type_of_fuel'        => $car->getTypeOfFuel(),
                'car_condition'       => $car->getCarCondition()
            ];

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    public function getAllCondition(): array {

        try {
            $query = 'SELECT car_condition FROM cars';
            $statement = $this->pdo->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            die($exception->getMessage());
        }

    }

}
