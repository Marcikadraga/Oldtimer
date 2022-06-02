<?php
namespace app\controller;

class Admin extends BaseController {

    public function index() {
        $this->render('admin/index');
    }
}
