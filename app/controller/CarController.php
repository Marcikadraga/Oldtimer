<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\core\request\Request;
use app\model\car\Car;
use app\model\car\CarModel;
use app\model\carType\CarType;
use app\model\carType\CarTypeModel;
use app\model\user\Authenticator;
use app\model\user\User;
use app\model\user\UserModel;
use Exception;
use DateTime;

class CarController extends BaseController {

    public function index() {

        $auth = new Authenticator();
        $carModel = new CarModel();
        $car = new Car();

        $data = [
            'cars'           => $carModel->getAllCars(),
            'userIsAdmin'    => $auth->userIsAdmin(),
            'isLoggedInUser' => $auth->isLoggedInUser(),
            'getIdOfOwner'   => $car->getIdOfOwner(),
            'userId'         => $auth->getUserId(),
            'carId'          => $car->getId(),
        ];

        $this->render('car/index', $data ?? []);
    }


    public function insert() {

        // A helyi validációs hibák gyűjteménye

        $errors = [];
        $errorMsg = '';
        $successMsg = '';
        $car = new Car();

        try {

            $type = $this->request->getPost('type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $color = $this->request->getPost('color', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $kilometers_traveled = $this->request->getPost('kilometers_traveled', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $year_of_manufacture = $this->request->getPost('$ear_of_manufacture', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $car_condition = $this->request->getPost('car_condition', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $type_of_fuel = $this->request->getPost('type_of_fuel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $carModel = new CarModel();

            if (empty($type)) {
                $errors['type'] = 'a típus megadása kötelező';
            } elseif (empty($color)) {
                $errors['color'] = 'a szín megadása kötelező';
            } elseif (empty($kilometers_traveled)) {
                $errors['kilometers_traveled'] = 'a megtett KM megadása kötelező';
            } elseif (empty($year_of_manufacture)) {
                $errors['year_of_manufacture'] = 'a gyártás éve megadása kötelező';
            } elseif (empty($car_condition)) {
                $errors['car_condition'] = 'az autó állapota megadása kötelező';
            } elseif (empty($type_of_fuel)) {
                $errors['type_of_fuel'] = 'az üzemanyag típusának megadása kötelező';
            }

            $car->setType($type);
            $car->setColor($color);
            $car->setKilometersTraveled($kilometers_traveled);
            $car->setYearOfManufacture($year_of_manufacture);
            $car->setCarCondition($car_condition);
            $car->setTypeOfFuel($type_of_fuel);
            $car->setCreatedAt((new DateTime('now'))->format("Y-m-d H:i:s"));

            //TODO validálást meg kell csinálni majd még.
            //            if (!$car->checkIsValidInsert() || !empty($errors)) {
            //                $errors = array_merge($user->getErrors(), $errors);
            //            }

            if (!empty($errors)) {
                throw new Exception('Kérjük ellenőrizze az űrlapot!');
            }

            $userId = $carModel->insert($car);
            if (empty($userId)) {
                throw new Exception($carModel->getErrorsAsString());
            }
            $data['errors'] = $errors;
            $data['errorMsg'] = $errorMsg;
            $data['successMsg'] = $successMsg;
            $data['car'] = $car;
            $data['submitted'] = true;

            //        var_dump($data);

            $this->render('carcontroller/index', $data);

        } catch (Exception $exception) {
            // nem végleges hibakezelés!!!
            $errorMsg = $exception->getMessage();

            if (!empty($errors)) {
                $errorMsg .= '<br>' . implode('<br>', $errors);
            }
        }

    }


    public function delete() {

        $carId = $this->request->getPost('carId', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($carId)) {
            throw new Exception('Hiba! A car azonosítója nem elérhető.');
        }

        $usermodel = new UserModel();
        $result = $usermodel->delete($carId);

        if ($result) {
            echo json_encode("success");
            return;
        }

        echo json_encode("error");
    }
}
