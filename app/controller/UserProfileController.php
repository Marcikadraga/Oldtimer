<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\core\request\Request;
use app\core\response\Response;
use app\model\user\Authenticator;
use app\model\user\UserModel;
use Exception;

class UserProfileController extends BaseController {

    public function index() {

        $auth = new Authenticator();

        $user = $auth->getUser();
        $data = ['user' => $user]; //lekérem az adott user adatait

        $this->render('user/index', $data);
    }
}
