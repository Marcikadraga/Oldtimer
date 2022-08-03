<?php

namespace app\model\carType;

use app\core\logger\SystemLog;
use app\core\pdo\PDOConnect;
use Exception;
use PDO;

class CarTypeModel {

    private ?PDO $pdo;


    public function __construct() {

        $this->pdo = PDOConnect::getInstance()->getPDO();
    }


    public function existTypename($type): bool {

        try {
            $query = 'SELECT * FROM carTypes WHERE type=? AND deleted_at IS NULL LIMIT 1';
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
            $query = 'SELECT * FROM carTypes WHERE manufacturer=? AND deleted_at IS NULL LIMIT 1';
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
            $query = 'SELECT * FROM carTypes WHERE deleted_at IS NULL';

            $statement = $this->pdo->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    public function delete($car_id) {

        try {
            $query = 'UPDATE carTypes SET deleted_at = NOW() WHERE id = ? LIMIT 1';
            $params = [$car_id];
            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    public function insert(CarType $carType) {

        try {
            $query = '
        INSERT INTO carTypes(manufacturer, type, startOfProductionTime, endOfProductionTime, created_at,updated_at,deleted_at)
        VALUES(:manufacturer, :type, :startOfProductionTime, :endOfProductionTime, :created_at, :updated_at, :deleted_at)';
            $params = [
                'manufacturer'          => $carType->getManufacturer(),
                'type'                  => $carType->getType(),
                'startOfProductionTime' => $carType->getStartOfProductionTime(),
                'endOfProductionTime'   => $carType->getEndOfProductionTime(),
                'created_at'            => $carType->getCreatedAt(),
                'updated_at'            => $carType->getUpdatedAt(),
                'deleted_at'            => $carType->getDeletedAt()
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


    public function update(CarType $carType): bool {

        try {
            $query = '
            UPDATE carTypes
            SET manufacturer=:manufacturer,
                type=:type,
                startOfProductionTime=:startOfProductionTime,
                endOfProductionTime=:endOfProductionTime,
                created_at=:created_at,
                updated_at=:updated_at,
                deleted_at=:deleted_at
            
            WHERE id=:id';

            $params = [
                'id'                    => $carType->getId(),
                'manufacturer'          => $carType->getManufacturer(),
                'type'                  => $carType->getType(),
                'startOfProductionTime' => $carType->getStartOfProductionTime(),
                'endOfProductionTime'   => $carType->getEndOfProductionTime(),
                'created_at'            => $carType->getCreatedAt(),
                'updated_at'            => $carType->getUpdatedAt(),
                'deleted_at'            => $carType->getDeletedAt()
            ];

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    public function getCarById($carId) {

        try {

            $query = 'SELECT * FROM carTypes WHERE id=? AND deleted_at IS NULL LIMIT 1';
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


    public function getById($id): ?CarType {

        try {
            $query = 'SELECT * FROM carTypes WHERE id=? AND deleted_at IS NULL LIMIT 1';
            $params = [$id];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                return new CarType($result);
            }
        } catch (Exception $exception) {
            die($exception->getMessage());
        }

        return null;
    }


    public function getAllCarTypes() {

        try {
            $query = 'SELECT type FROM cartypes WHERE deleted_at IS NULL';

            $statement = $this->pdo->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    public function isUniqCarType($type): bool {

        try {
            $query = 'SELECT type FROM cartypes WHERE type=? AND deleted_at IS NULL';
            $params=[$type];
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            if ($statement->fetchAll(PDO::FETCH_ASSOC) != null) {
                return false;
            }
            return true;

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }
}

