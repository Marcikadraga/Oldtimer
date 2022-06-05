<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\core\request\Request;
use app\model\car\Car;
use app\model\car\CarModel;
use Exception;

class CarController extends BaseController {

    private Car      $car;
    private CarModel $carModel;


    public function __construct() {

        parent::__construct();

        $this->car = new Car();
        $this->carModel = new CarModel(); //hogy ne kelljen minden függvényben példányosítani a model-t
//        tunk mindent, mert előbb utóbb nagyon sok lesz belőle.

    }


    public function index() {

        $this->checkPermission('admin');

        $cars = $this->carModel->getAllCars();
        $fields = $this->car->getFields();

        $data = [
            'cars'   => $cars,
            'fields' => $fields
        ];
        $this->render('cars/index', $data);
    }


    public function delete() {
        $this->checkAjax();
        $this->checkPermission('admin');

        $carModel = new CarModel();
        $result = $carModel->delete($_POST['carId']);
        if ($result) {
            echo json_encode("success");
            return;
        }

        echo json_encode("error");
    }


    public function update() {

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

            $car->setManufacturer($this->request->getPost('manufacturer', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setType($this->request->getPost('type', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $car->setStartOfProductionTime($this->request->getPost('startOfProduction', FILTER_SANITIZE_SPECIAL_CHARS));
            $car->setStartOfProductionTime($this->request->getPost('endOfProduction', FILTER_SANITIZE_FULL_SPECIAL_CHARS));




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

        $carModel = new CarModel();
        $result = $carModel->getCarById($_POST['carId']);
        if ($result) {
            echo json_encode($result);
            return;
        }

        echo json_encode("error");
    }

}

