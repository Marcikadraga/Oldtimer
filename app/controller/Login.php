<?php

namespace app\controller;

use app\core\request\Request;
use app\core\response\Response;
use app\model\user\Authenticator;
use app\model\user\User;
use app\model\user\UserModel;
use app\model\user\UserModel2;
use Exception;

class Login extends BaseController {

    private $user;


    public function index() {

        $data = [];

        sessionStart();
        if (array_key_exists('invalidAuthenticator', $_SESSION)) {
            $data['invalidAuthenticator'] = $_SESSION['invalidAuthenticator'];
            unset($_SESSION['invalidAuthenticator']);
        }

        $this->render('login/index', $data);

    }


    public function signin() {

        try {

            // A helyi validációs hibák gyűjteménye
            $errors = [];
            $errorMsg = '';
            $successMsg = '';
            $userModel = new UserModel();
            $request = new Request();

            // Post tömb adatainak biztonságos beolvasása
            $username = $request->getPost('username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = $request->getPost('password', FILTER_SANITIZE_SPECIAL_CHARS);

            $user = $userModel->getByUsername($username);

            if (empty($user)) {
                throw new Exception('Hibas felhasznalonev vagy jelszo.');
            }

            if (!$user->passwordVerify($password)) {

                $user->failAttempt();

                $userModel->update($user);

                if ($user->getFailedLoginCounter() < 5) {
                    // az username létezik az adatbazisban, az user nem bannolt, de a jelszo hibas
                    throw new Exception('Hibás felhasznalonev vagy jelszo. Még ' . $user->showHowManyChancesLeftForTheUser() . ' alkalommal próbálkozhat.');
                } else {
                    // az username létezik az adatbazisban, az user nem bannolt, de a jelszo hibas
                    throw new Exception('Hibás felhasznalonev vagy jelszo.');
                }
            }

            $user->deleteUserBanStatus();
            $user->setLastLoginAt(date('Y-m-d H:i:s'));
            $userModel->save($user);

            $auth = new Authenticator();
            $auth->login($user->getId());

            $this->response = new Response();
            $this->response->redirectDashboard();

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

        $this->render('login/index', $data);
    }


    public function logout() {

        $auth = new Authenticator();
        $auth->logout();

        $response = new Response();
        $response->redirectLogin();
    }
}

