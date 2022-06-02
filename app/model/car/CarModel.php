<?php

namespace app\model\car;

use app\core\logger\SystemLog;
use app\core\pdo\CustomStatementDebug;
use app\core\pdo\PDOConnect;
use app\model\user\User;
use Exception;
use PDO;

class CarModel {

    private ?PDO $pdo;


    public function __construct() {

        $this->pdo = PDOConnect::getInstance()->getPDO();
    }


    public function existTypename($type): bool {

        try {
            $query = 'SELECT * FROM cars WHERE type=? AND deleted_at IS NULL LIMIT 1';
            $params = [$type];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return !empty($result);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    public function existManufacturer($manufacturer): bool {

        try {
            $query = 'SELECT * FROM cars WHERE manufacturer=? AND deleted_at IS NULL LIMIT 1';
            $params = [$manufacturer];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return !empty($result);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    public function getAllCars(): array {

        try {
            $query = 'SELECT * FROM cars WHERE deleted_at IS NULL';

            $statement = $this->pdo->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    public function delete($car_id) {

        try {
            $query = 'UPDATE cars SET deleted_at = NOW() WHERE id = ? LIMIT 1';
            $params = [$car_id];
            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    public function insert(Car $car) {

        try {
            $query = '
        INSERT INTO cars(manufacturer, type, startOfProductionTime, endOfProductionTime, created_at,updated_at,deleted_at)
        VALUES(:manufacturer, :type, :startOfProductionTime, :endOfProductionTime, :created_at, :updated_at, :deleted_at)';
            $params = [
                'manufacturer'          => $car->getManufacturer(),
                'type'                  => $car->getType(),
                'startOfProductionTime' => $car->getStartOfProductionTime(),
                'endOfProductionTime'   => $car->getEndOfProductionTime(),
                'created_at'            => $car->getCreatedAt(),
                'updated_at'            => $car->getUpdatedAt(),
                'deleted_at'            => $car->getDeletedAt()
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


    /**
     * @param $id
     * @param $manufacturer
     * @param $type
     * @param $start
     * @param $end
     * @return bool
     * @throws Exception
     */
    public function update(Car $car): bool {

        try {
            $query = '
            UPDATE cars
            SET manufacturer=:manufacturer,
                type=:type,
                startOfProductionTime=:startOfProductionTime,
                endOfProductionTime=:endOfProductionTime,
                created_at=:created_at,
                updated_at=:updated_at,
                deleted_at=:deleted_at
            
            WHERE id=:id';

            $params = [
                'id'                    => $car->getId(),
                'manufacturer'          => $car->getManufacturer(),
                'type'                  => $car->getType(),
                'startOfProductionTime' => $car->getStartOfProductionTime(),
                'endOfProductionTime'   => $car->getEndOfProductionTime(),
                'created_at'            => $car->getCreatedAt(),
                'updated_at'            => $car->getUpdatedAt(),
                'deleted_at'            => $car->getDeletedAt()
            ];

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
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
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                return new Car($result[0]);
            }
        } catch (Exception $exception) {
            die($exception->getMessage());
        }

        return null;
    }

}
