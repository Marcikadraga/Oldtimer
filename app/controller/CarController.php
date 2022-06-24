<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\core\request\Request;
use app\model\car\Car;
use app\model\car\CarModel;
use app\model\carType\CarType;
use app\model\carType\CarTypeModel;
use app\model\user\Authenticator;
use Exception;
use DateTime;


class CarController extends BaseController {

public function index(){
    $auth= new Authenticator();
    $carModel= new CarModel();


    $this->render('users/index', $data);

}
}
