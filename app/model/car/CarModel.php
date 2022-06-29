<?php

namespace app\model\car;

use app\controller\BaseController;
use app\core\logger\SystemLog;
use app\core\pdo\CustomStatementDebug;
use app\core\pdo\PDOConnect;
use app\model\user\User;
use Exception;
use PDO;
use app\model\BaseModel;

class CarModel extends BaseModel {

    public function insert(Car $car): ?int {

        try {
            $query = '
        
        INSERT INTO carTypes(color, kilometers_traveled, year_of_manufacture, type_of_fuel, car_condition, deleted_at, updated_at, created_at)
        VALUES(:color, :kilometers_traveled, :year_of_manufacture, :type_of_fuel, :car_condition, :deleted_at, :updated_at, :created_at)
        ';

            $params = [
                'color'               => $car->getColor(),
                'kilometers_traveled' => $car->getKilometersTraveled(),
                'year_of_manufacture' => $car->getYearOfManufacture(),
                'type_of_fuel'        => $car->getTypeOfFuel(),
                'car_condition'       => $car->getCondition(),
                'deleted_at'          => $car->getDeletedAt(),
                'updated_at'          => $car->getUpdatedAt(),
                'created_at'          => $car->getCreatedAt()
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
            $query = 'SELECT * FROM carTypes WHERE deleted_at IS NULL';

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

}
