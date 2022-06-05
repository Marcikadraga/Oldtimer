<?php

namespace app\controller;

use app\controller\BaseController;
use app\core\request\Request;
use app\core\response\Response;
use app\model\user\Authenticator;
use app\model\car\Car;
use app\model\car\CarModel;
use DateTime;
use Exception;

class Insert extends BaseController {

    private $car;


    public function index() {

        $this->checkPermission('admin');

        $data = [];
        $this->render('insert/index', $data);
    }


    public function insert() {

        $this->checkPermission('admin');

        $errors = [];
        $errorMsg = '';
        $successMsg = '';
        $car = new Car();

        try {


            $manufacturer = $this->request->getPost('manufacturer', FILTER_SANITIZE_SPECIAL_CHARS);
            $type = $this->request->getPost('type', FILTER_SANITIZE_SPECIAL_CHARS);
            $startOfProductionTime = $this->request->getPost('startOfProductionTime', FILTER_SANITIZE_SPECIAL_CHARS);
            $endOfProductionTime = $this->request->getPost('endOfProductionTime', FILTER_SANITIZE_SPECIAL_CHARS);

            $carModel = new CarModel();

//            if (empty($manufacturer)) {
//                $errors['manufacturer'] = 'A gyártó megadása kötelező!';
//            }
//            if (empty($type)) {
//                $errors['type'] = 'A típus megadása kötelező!';
//            }
//            if (empty($startOfProductionTime)) {
//                $errors['startOfProductionTime'] = 'A kezdő év megadása kötelező!';
//            }
//            if (empty($endOfProductionTime)) {
//                $errors['endOfProductionTime'] = 'A végév megadása kötelező!';
//            }

            $car->setManufacturer($manufacturer);
            $car->setType($type);
            $car->setStartOfProductionTime($startOfProductionTime);
            $car->setEndOfProductionTime($endOfProductionTime);
            $car->setCreatedAt((new DateTime('now'))->format("Y-m-d H:i:s"));

            if (!$car->checkIsValidInsert() || !empty($errors)) {
                $errors = array_merge($car->getErrors(), $errors);
            }
            if (!empty($errors)) {
                throw new Exception('Kérjük ellenőrizze az űrlapot!');
            }
            $carID = $carModel->insert($car);
            if (empty($carID)) {
                throw new Exception($carModel->getErrorAsString());
            }
        } catch (Exception $exception) {
            // nem végleges hibakezelés!!!
            $errorMsg = $exception->getMessage();

            if (!empty($errors)) {
                $errorMsg .= '<br>' . implode('<br>', $errors);
            }
        }
        $data['errors'] = $errors;
        $data['errorMsg'] = $errorMsg;
        $data['successMsg'] = $successMsg;
        $data['user'] = $car;
        $data['submitted'] = true;

        //       var_dump($data);

        $this->render('insert/index', $data);
    }


}
