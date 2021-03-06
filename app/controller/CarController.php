<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\model\car\Car;
use app\model\car\CarModel;
use app\model\carType\CarTypeModel;
use app\model\color\Color;
use app\model\color\ColorModel;
use app\model\user\Authenticator;
use DateTime;
use Exception;
use Throwable;

class CarController extends BaseController {

    public function index() {

        $auth = new Authenticator();
        $carModel = new CarModel();
        $car = new Car();
        $carTypeModel = new CarTypeModel();

        $data = [
            'cars'           => $carModel->getAllCars(),
            'userIsAdmin'    => $auth->userIsAdmin(),
            'isLoggedInUser' => $auth->isLoggedInUser(),
            'getIdOfOwner'   => $car->getIdOfOwner(),
            'userId'         => $auth->getUserId(),
            'carId'          => $car->getId(),
            'cardCondition'  => $car->getCarCondition(),
            'allCarType'     => $carTypeModel->getAllCarTypes()

        ];

        $this->render('Car/index', $data ?? []);
    }


    public function insert() {

        // A helyi validációs hibák gyűjteménye

        $errors = [];
        $errorMsg = '';
        $successMsg = '';
        $car = new Car();
        $user = new Authenticator();

        if ($this->request->isPostRequest()) {
            try {
                $typeOfFuelValue = $this->request->getPost('type_of_fuel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $type = $this->request->getPost('type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $color = $this->request->getPost('color', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $kilometers_traveled = $this->request->getPost('kilometers_traveled', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $year_of_manufacture = $this->request->getPost('year_of_manufacture', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $car_condition = $this->request->getPost('car_condition', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $carModel = new CarModel();

                if (empty($type)) {
                    $errors['type'] = 'a típus megadása kötelező!';
                } elseif (empty($color)) {
                    $errors['color'] = 'a szín megadása kötelező!';
                } elseif (empty($kilometers_traveled)) {
                    $errors['kilometers_traveled'] = 'a megtett KM megadása kötelező!';
                } elseif (empty($year_of_manufacture)) {
                    $errors['year_of_manufacture'] = 'a gyártás éve megadása kötelező!';
                } elseif ($car_condition == "null") {
                    $errors['car_condition'] = 'Az autó állapotának megadása kötelező!';
                } elseif ($typeOfFuelValue == "null") {
                    $errors['type_of_fuel'] = 'Az üzemanyag típusának megadása kötelező!';
                }

                $car->setType($type);
                $car->setColor($color);
                $car->setKilometersTraveled($kilometers_traveled);
                $car->setYearOfManufacture($year_of_manufacture);
                $car->setCarCondition($car_condition);
                $car->setTypeOfFuel($typeOfFuelValue);
                $car->setCreatedAt(new DateTime());
                $car->setIdOfOwner($user->getUserId());

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
                $successMsg = 'Az autó hozzáadása sikerült.';
            } catch (Exception $exception) {
                // nem végleges hibakezelés!!!
                $errorMsg = $exception->getMessage();

                if (!empty($errors)) {
                    $errorMsg .= '<br>' . implode('<br>', $errors);
                    echo $errorMsg;
                }

            }
        }

        $data['errors'] = $errors;
        $data['errorMsg'] = $errorMsg;
        $data['successMsg'] = $successMsg;
        $data['car'] = $car;
        $data['submitted'] = true;

        $carTypeModel = new CarTypeModel();
        $data['allCarType'] = $carTypeModel->getAllCarTypes();

        $this->render('newCarInsert/index', $data);

    }


    public function delete() {

        $carId = $this->request->getPost('carId', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($carId)) {
            throw new Exception('Hiba! A car azonosítója nem elérhető.');
        }

        $carmodel = new CarModel();
        $result = $carmodel->delete($carId);

        if ($result) {
            echo json_encode("success");
            return;
        }

        echo json_encode("error");
    }


    public function getCar() {

        $this->checkPermission('admin');

        $carModel = new CarModel();

        $result = $carModel->getCarById($this->request->getPost('carId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if ($result) {
            echo json_encode($result);
            return;
        }

        echo json_encode("error");
    }


    public function update() {

        // TODO ezt meg kéne csinálni később
        $this->checkAjax();
        $this->checkPermission('admin');

        try {


            // $this->request = $this->request;
            $id = $this->request->getPost('carId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (empty($id)) {
                throw new Exception('Nincs id');
            }

            $carmodel = new CarModel();
            $car = $carmodel->getById($id);
            if (empty($car)) {
                throw new Exception('Nem létezik ilyen autó');
            }

            $car->setType($this->request->getPost('type', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setColor($this->request->getPost('color', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setKilometersTraveled($this->request->getPost('kilometers-traveled', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setYearOfManufacture($this->request->getPost('year-of-manufacture', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setTypeOfFuel($this->request->getPost('type-of-fuel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setCarCondition($this->request->getPost('car-condition', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setUpdatedAt(new DateTime());

            //            if (!$car->checkIsValidSave()) {
            //                throw new Exception($car->getErrorsAsString());
            //            }

            if (!$carmodel->update($car)) {
                throw new Exception('Hiba a mentés során');
            }
            echo json_encode('success');

        } catch (Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            echo json_encode($exception->getMessage(), JSON_UNESCAPED_UNICODE);
        }
        return true;
    }


    public function GetAllColor() {

        $colorModel = new ColorModel();

        $data = [
            'colors' => $colorModel->getAllColors(),
        ];

        $this->render('color/index', $data ?? []);
    }


    public function deleteColor() {

        $colorId = $this->request->getPost('colorId', FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($colorId)) {
            throw new Exception('Hiba! A car azonosítója nem elérhető.');
        }

        $colormodel = new ColorModel();
        $result = $colormodel->delete($colorId);
        if ($result) {
            echo json_encode("success");
            return;
        }

        echo json_encode("error");
    }

    public function insertColor() {

        $errors = [];
        $errorMsg = '';
        $successMsg = '';
        $color = new Color();
        $user = new Authenticator();

        if ($this->request->isPostRequest()) {
            try {

                $name_of_color = $this->request->getPost('name_of_color', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $rgb = $this->request->getPost('rgb', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $colorModel = new ColorModel();

                if (empty($name_of_color)) {
                    $errors['name_of_color'] = 'a szín megadása kötelező!';
                } elseif (empty($rgb)) {
                    $errors['rgb'] = 'az rgb megadása kötelező!';
                }

                $color->setNameOfColor($name_of_color);
                $color->setRgb($rgb);

                if (!empty($errors)) {
                    throw new Exception('Kérjük ellenőrizze az űrlapot!');
                }

                $this->response->jsonResponse([
                    "success" => true,
                    "message" => "Sikeres insert."
                ]);

            } catch (Exception $exception) {
                // nem végleges hibakezelés!!!
                $errorMsg = $exception->getMessage();

                if (!empty($errors)) {
                    $errorMsg .= '<br>' . implode('<br>', $errors);
                    echo $errorMsg;
                }

            }
        }

        $data['errors'] = $errors;
        $data['errorMsg'] = $errorMsg;
        $data['successMsg'] = $successMsg;
        $data['color'] = $color;
        $data['submitted'] = true;

        $this->render('insertColor/index');

    }

    protected function validate() {
        return true;
    }

    protected function insertUser() {
        return true;
    }

    protected function clean() {
        return true;
    }

    protected function setResponse() {
        return true;
    }

    public function ajaxMethod() {
        $this->validate();

        $this->insertUser();

        $this->clean();

        $this->setResponse();
    }
}
