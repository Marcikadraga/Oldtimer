<?php

namespace app\model\car;

use app\controller\BaseController;
use app\core\logger\SystemLog;
use app\core\pdo\CustomStatementDebug;
use app\core\pdo\PDOConnect;
use app\model\user\User;
use Exception;
use PDO;

class CarModel extends BaseController {

    public function __construct() {

        $this->pdo = PDOConnect::getInstance()->getPDO();
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


    public function insert(Car $car): ?int {

        $query = '
        
        INSERT INTO cars(color, kilometers_traveled, year_of_manufacture, type_of_fuel, car_condition, deleted_at, updated_at)
        VALUES(:color, :kilometers_traveled, :year_of_manufacture, :type_of_fuel, :car_condition, :deleted_at, :updated_at)
        ';

        $params = [
            'color' => $car->getColor(),
            'kilometers_traveled'=> $car->getKilometersTraveled(),
            'year_of_manufacture' => $car->getYearOfManufacture(),
            'type_of_fuel'=> $car->getTypeOfFuel(),
            'car_condition'=>$car->getCondition()
        ];
    }

}
