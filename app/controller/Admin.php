<?php

namespace app\controller;

use app\model\user\Authenticator;

class Admin extends BaseController {

    /**
     * A bejelentkezett user nyitólapja
     * Csak bejelentkezés után látható
     * @route /admin
     */
    public function index() {

        $this->checkPermission('guest');

        $this->render('admin/index');
    }

}
