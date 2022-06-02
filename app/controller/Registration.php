<?php

namespace app\controller;

use app\core\request\Request;
use app\core\response\Response;
use app\model\user\User;
use app\model\user\UserModel;
use DateTime;
use Exception;

class Registration extends BaseController {

    /**
     * Megjeleníti a regisztrációs űrlapot
     * Gyakorlatilag legenerálja az oldalt, ahol regisztrálhat a user
     * @route /registration
     */
    public function index() {

        $this->render('registration/index');
    }


    /**
     * Az űrlap form erre az útvonalra küldi az adatokat
     * Ez egy post requestet fogad majd
     * @route /registration/save
     */
    public function insert() {

        // A helyi validációs hibák gyűjteménye
        $errors = [];
        $errorMsg = '';
        $successMsg = '';
        $user = new User();

        try {

            $request = new Request();

            // Post tömb adatainak biztonságos beolvasása
            $username = $request->getPost('username', FILTER_SANITIZE_SPECIAL_CHARS);
            $password1 = $request->getPost('password1', FILTER_SANITIZE_SPECIAL_CHARS);
            $password2 = $request->getPost('password2', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = $request->getPost('email', FILTER_SANITIZE_SPECIAL_CHARS);
            $firstName = $request->getPost('first_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $middleName = $request->getPost('middle_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $lastName = $request->getPost('last_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $birthDate = $request->getPost('birth_date', FILTER_SANITIZE_SPECIAL_CHARS);
            $phoneNumber=$request->getPost('phoneNumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $webpage=$request->getPost('webpage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $zipCode = $request->getPost('zip_code', FILTER_SANITIZE_SPECIAL_CHARS);
            $city = $request->getPost('city', FILTER_SANITIZE_SPECIAL_CHARS);
            $district = $request->getPost('district', FILTER_SANITIZE_SPECIAL_CHARS);
            $moreAddress = $request->getPost('more_address', FILTER_SANITIZE_SPECIAL_CHARS);

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
                $errors['password1'] = 'A jelszó megadása kötelező.';
            } elseif (empty($password2)) {
                $errors['password2'] = 'Az ellenőrző jelszó megadása kötelező.';
            } elseif (!$user->isEquals($password1, $password2)) {
                $errors['password2'] = 'A két jelszó nem egyezik.';
            } elseif (!$user->isPasswordStrongTest($password1)) {
                $errors['password1'] = $user->getErrorsAsString();
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
            if(empty($userId)){
                throw new Exception($userModel->getErrorsAsString());
            }

            // Ha sikeresen elmentettük az usert, akkor siker válaszüzenet küldése
            $successMsg = 'Sikerült a regisztráció, kérjük kattintson a login menüre.';

        } catch (Exception $exception) {
            // nem végleges hibakezelés!!!
            $errorMsg = $exception->getMessage();

            if(!empty($errors)){
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
