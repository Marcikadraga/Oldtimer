<?php

namespace app\controller;

use app\core\request\Request;
use app\core\response\Response;
use app\model\user\Authenticator;
use app\model\user\User;
use app\model\user\UserModel;
use app\model\user\UserModel2;
use Exception;
use DateTime;




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

            // Post tömb adatainak biztonságos beolvasása
            $username = $this->request->getPost('username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = $this->request->getPost('password', FILTER_SANITIZE_SPECIAL_CHARS);

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

            //            $successMsg = 'Sikerült a bejelentkezés, mindjárt átirányítjuk a főoldalra.';
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
        $this->response->redirectLogin();
    }


    public function insert() {

        // A helyi validációs hibák gyűjteménye

        $errors = [];
        $errorMsg = '';
        $successMsg = '';
        $user = new User();

        try {
            // Post tömb adatainak biztonságos beolvasása
            $username = $this->request->getPost('username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password1 = $this->request->getPost('password1', FILTER_SANITIZE_SPECIAL_CHARS);
            $password2 = $this->request->getPost('password2', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = $this->request->getPost('email', FILTER_SANITIZE_SPECIAL_CHARS);
            $firstName = $this->request->getPost('first_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $middleName = $this->request->getPost('middle_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $lastName = $this->request->getPost('last_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $birthDate = $this->request->getPost('birth_date', FILTER_SANITIZE_SPECIAL_CHARS);
            $phoneNumber = $this->request->getPost('phoneNumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $webpage = $this->request->getPost('webpage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $zipCode = $this->request->getPost('zip_code', FILTER_SANITIZE_SPECIAL_CHARS);
            $city = $this->request->getPost('city', FILTER_SANITIZE_SPECIAL_CHARS);
            $district = $this->request->getPost('district', FILTER_SANITIZE_SPECIAL_CHARS);
            $moreAddress = $this->request->getPost('more_address', FILTER_SANITIZE_SPECIAL_CHARS);

            $userModel = new UserModel();

            // Username vizsgálata
            if (empty($username)) {
                $errors['username'] = 'Az username megadása kötelező.';
            } elseif ($userModel->existUsername($username)) {
                $errors['username'] = 'Az username már foglalt.';
            }

            // Az email cím létezik-e már az adatbázisban
            helper('email');

            if (empty($email)) {
                $errors['email'] = 'Az email cím megadása kötelező.';
            } elseif (!checkIsValidEmail($email)) {
                $errors['email'] = 'Az email cím szerkezete nem megfelelő.';
            } elseif ($userModel->existEmail($email)) {
                $errors['email'] = 'Ezzel az email címmel már regisztráltak a rendszerbe.';
            }

            // Jelszó vizsgálata
            if (empty($password1)) {
                $errors['$password1'] = 'A jelszó megadása kötelező.';
            } elseif (empty($password2)) {
                $errors['password2'] = 'Az ellenőrző jelszó megadása kötelező.';
            } elseif (!$user->isEquals($password1, $password2)) {
                $errors['password2'] = 'A két jelszó nem egyezik.';
            } elseif (!$user->isPasswordStrongTest($password1)) {
                $errors['$password1'] = $user->getErrorsAsString();
            }

            $user->setUsername($username);
            $user->setPasswordHash($password1);
            $user->setEmail($email);
            $user->setFirstName($firstName);
            $user->setMiddleName($middleName);
            $user->setLastName($lastName);
            $user->setBirthDate($birthDate);
            $user->setPhoneNumber($phoneNumber);
            $user->setWebpage($webpage);
            $user->setZipCode($zipCode);
            $user->setCity($city);
            $user->setDistrict($district);
            $user->setMoreAddress($moreAddress);
            $user->setRole('guest');
            $user->setCreatedAt((new DateTime('now'))->format("Y-m-d H:i:s"));
            $user->setFailedLoginCounter(0);
            $user->setIsBanned(0);

            // Az usernek átadjuk az adatokat és futtatjuk az önvalidációt
            // Ha az önvalidációban vagy a helyi errors tömbben van valami hibabejegyzés
            // Akkor a 2 hibatömböt összeolvasztjuk és visszaküldjük a kliensnek a hibákat

            if (!$user->checkIsValidInsert() || !empty($errors)) {
                $errors = array_merge($user->getErrors(), $errors);
            }

            if (!empty($errors)) {
                throw new Exception('Kérjük ellenőrizze az űrlapot!');
            }

            // Ha itt vagyunk, akkor azt jelenti hogy nem volt hiba a beérkezett adatokban
            $userId = $userModel->insert($user);
            if (empty($userId)) {
                throw new Exception($userModel->getErrorsAsString());
            }

            // Ha sikeresen elmentettük az usert, akkor siker válaszüzenet küldése
            $successMsg = 'Sikerült a regisztráció, kérjük kattintson a login menüre.';

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
        $data['user'] = $user;
        $data['submitted'] = true;

        //        var_dump($data);

        $this->render('registration/index', $data);
    }
}

