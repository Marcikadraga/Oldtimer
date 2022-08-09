<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\model\carType\CarType;
use app\model\carType\CarTypeModel;
use DateTime;
use Exception;

class CarTypeController extends BaseController {

    private CarType      $car;
    private CarTypeModel $carModel;


    public function __construct() {

        parent::__construct();

        $this->car = new CarType();
        $this->carModel = new CarTypeModel(); //hogy ne kelljen minden függvényben példányosítani a model-t
        //        tunk mindent, mert előbb utóbb nagyon sok lesz belőle.

    }


    public function index() {

        $this->checkPermission('admin');
        $cartypeModel= new CarTypeModel();

        $data = [
            'cartypes' =>$cartypeModel->getAllCars(),
            ];

        $this->render('carType/index', $data);
    }


    public function delete() {

        $this->checkAjax();
        $this->checkPermission('admin');

        $carModel = new CarTypeModel();
        $result = $carModel->delete($_POST['carId']);
        //$result=$this->request->getPost('carId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($result) {
            echo json_encode("success");
            return;
        }

        echo json_encode("error");
    }


    public function update() {

        $this->checkAjax();
        $this->checkPermission('admin');

        try {
            $id = $this->request->getPost('carId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (empty($id)) {
                throw new Exception('Nincs id');
            }

            $carmodel = new CarTypeModel();
            $car = $carmodel->getById($id);
            if (empty($car)) {
                throw new Exception('Nem létezik ilyen autó');
            }
            $car->setManufacturer($this->request->getPost('manufacturer', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setType($this->request->getPost('type', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setStartOfProductionTime($this->request->getPost('startOfProduction', FILTER_SANITIZE_SPECIAL_CHARS));
            $car->setEndOfProductionTime($this->request->getPost('endOfProduction', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setUpdatedAt(new DateTime());
            $car->setIsActive($this->request->getPost('is_active', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            if (!$car->checkIsValidSave()) {
                throw new Exception($car->getErrorsAsString());
            }
            if (!$carmodel->update($car)) {
                throw new Exception('Hiba a mentés során');
            }
            echo json_encode('success');

        } catch (\Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            echo json_encode($exception->getMessage(), JSON_UNESCAPED_UNICODE);
        }
        return true;
    }


    public function getCar() {

        $this->checkPermission('admin');

        $carModel = new CarTypeModel();

        $result = $carModel->getCarById($this->request->getPost('carId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if ($result) {
            echo json_encode($result);
            return;
        }
        echo json_encode("error");
    }


    public function insert() {

        $this->checkPermission('admin');

        $errors = [];
        $errorMsg = '';
        $successMsg = '';
        $car = new CarType();

        if ($this->request->isPostRequest()) {
            try {


                $manufacturer = $this->request->getPost('manufacturer', FILTER_SANITIZE_SPECIAL_CHARS);
                $type = $this->request->getPost('type', FILTER_SANITIZE_SPECIAL_CHARS);
                $startOfProductionTime = $this->request->getPost('startOfProductionTime', FILTER_SANITIZE_SPECIAL_CHARS);
                $endOfProductionTime = $this->request->getPost('endOfProductionTime', FILTER_SANITIZE_SPECIAL_CHARS);

                $carModel = new CarTypeModel();

                if (!$carModel->isUniqCarType($type)) {
                    $errors['type'] = 'Ezzel a névvel már létezik típus!';
                }
                if (empty($manufacturer)) {
                    $errors['manufacturer'] = 'A gyártó megadása kötelező!';
                }
                if (empty($type)) {
                    $errors['type'] = 'A típus megadása kötelező!';
                }
                if (empty($startOfProductionTime)) {
                    $errors['startOfProductionTime'] = 'A kezdő év megadása kötelező!';
                }
                if (empty($endOfProductionTime)) {
                    $errors['endOfProductionTime'] = 'A végév megadása kötelező!';
                }

                $car->setManufacturer($manufacturer);
                $car->setType($type);
                $car->setStartOfProductionTime($startOfProductionTime);
                $car->setEndOfProductionTime($endOfProductionTime);
                $car->setCreatedAt((new DateTime('now'))->format("Y-m-d H:i:s"));

                if (!empty($errors)) {
                    throw new Exception('Kérjük ellenőrizze az űrlapot!');
                }
                $carID = $carModel->insert($car);
                if (empty($carID)) {
                    throw new Exception($car->getErrorAsString());
                }
                $successMsg = 'Az autótípus hozzáadása sikerült.';
            } catch (Exception $exception) {
                $errorMsg = $exception->getMessage();

                if (!empty($errors)) {
                    $errorMsg .= '<br>' . implode('<br>', $errors);
                }
            }
        }

        $data['errors'] = $errors;
        $data['errorMsg'] = $errorMsg;
        $data['successMsg'] = $successMsg;
        $data['user'] = $car;
        $data['submitted'] = true;

        $this->render('insert/index', $data);
    }

}

