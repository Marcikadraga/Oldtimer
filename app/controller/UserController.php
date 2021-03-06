<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\core\request\Request;
use app\core\response\Response;
use app\model\user\Authenticator;
use app\model\user\User;
use app\model\user\UserModel;
use DateTime;
use Exception;

class UserController extends BaseController {

    public function index() {

        $auth = new Authenticator();
        $userModel = new UserModel();

        if ($auth->userIsAdmin()) {
            $data = [
                'users' => $userModel->getAll(), // Ez a függvény egy arrayt ad vissza, amibe User objectek vannak
            ];
        } else {
            $data = [
                'users' => [$auth->getUser()], // Ez 1 db user, de a view egy array-t vár, ezért került []-be
            ];
        }

        $this->render('users/index', $data);
    }


    public function delete() {

        // autentikáció: melyik függvényt futtassuk?
        // authenticateUser vs authenticateAdmin

        $this->checkPermission('guest');

        // FONTOS BIZTONSÁGI KOCKÁZAT, A $_POST ÉS A $_GET TÖMB NEM HASZNÁLHATÓ!!!
        // KIZÁRÓLAG FILTEREZVE VEHETŐK ÁT AZ ADATOK BELŐLÜK

        $userId = $this->request->getPost('userId', FILTER_SANITIZE_SPECIAL_CHARS);

        // CÉLSZERŰ ELLENŐRIZNI HOGY JÖTT-E ADAT

        if (empty($userId)) {
            throw new Exception('Hiba! A user azonosítója nem elérhető.');
        }

        // Megnézzük, hogy a belépett user azonos-e azzal, akit le akarunk törölni
        // Ha nem magunkat töröljük, hanem valaki mást, akkor vizsgáljuk hogy admin-e a belépett user
        // Csak az adminok törölhetnek más usereket

        if ($_SESSION['userid'] != $userId) {
            $this->checkPermission('admin');
        }

        $usermodel = new UserModel();
        $result = $usermodel->delete($userId);

        if ($result) {
            echo json_encode("success");
            return;
        }

        echo json_encode("error");
    }


    public function getUser() {

        $this->checkPermission('guest');

        $usermodel = new UserModel();
        //        $result = $usermodel->getUserById($_POST['userId']);
        $result = $usermodel->getUserById($this->request->getPost('userId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if ($result) {
            echo json_encode($result);
            return;
        }
        echo json_encode("error");
    }


    public function update() {

        try {
            // 1 vizsgálat: szerkeszteni csak belépett user szerkeszthet
            // Itt még nem vizsgáljuk hogy admin-e a belépett user, mert a user saját adatait szerkesztheti akkor is ha nem admin
            $this->checkPermission('guest');

            $id = $this->request->getPost('id', FILTER_SANITIZE_SPECIAL_CHARS);
            if (empty($id)) {
                throw new Exception("Nem adtál meg id-t!");
            }

            // Megnézzük, hogy a belépett user azonos-e azzal, akit szerkeszteni akarunk
            // Ha nem magunkat szerkesztjük, hanem valaki mást, akkor vizsgáljuk hogy admin-e a belépett user
            // Csak az adminok szerkeszthetnek más usereket

            if ($_SESSION['userid'] != $id) {
                $this->checkPermission('admin');
            }

            $userModel = new UserModel();
            $user = $userModel->getById($id);
            if (empty($user)) {
                throw new Exception("Nem létezik ilyen felhasználó!");
            }

            $user->setUsername($this->request->getPost('username', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setEmail($this->request->getPost('email', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setFirstName($this->request->getPost('first_name', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setMiddleName($this->request->getPost('middle_name', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setLastName($this->request->getPost('last_name', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setBirthDate($this->request->getPost('birth_date', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setphoneNumber($this->request->getPost('phoneNumber', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setWebpage($this->request->getPost('webpage', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setZipCode($this->request->getPost('zip_code', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setCity($this->request->getPost('city', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setDistrict($this->request->getPost('district', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setMoreAddress($this->request->getPost('more_address', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setRole($this->request->getPost('role', FILTER_SANITIZE_SPECIAL_CHARS));

            if (!$user->checkIsValidSave()) {
                throw new Exception($user->getErrorsAsString());
            }

            if (!$userModel->update($user)) {
                throw new Exception("Hiba történt a mentés során!");
            }

            // Az eredeti megoldás egy szimpla echo, ami teljesen jól működik
            // De szeretnénk hogy minden válasz a Response objecten keresztül történjen
            // A rendszerünk kilépési pontja a Response exit függvénye
            // A jsonResponse biztosítja a megfelelő választ a js-nek és lezárja a scriptet

            $this->response->jsonResponse('success');

        } catch (\Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            //echo json_encode($exception->getMessage());

            $this->response->jsonResponse($exception->getMessage());
        }
    }


    public function updatePassword() {

        $errors = [];
        $errorMsg = '';

        try {

            $auth = new Authenticator();
            $userModel = new UserModel();

            $id = $auth->getUserId();

            $user = $userModel->getById($id);
            if (empty($user)) {
                throw new Exception("Nem létezik ilyen felhasználó!");
            }

            $password1 = $this->request->getPost('password_hash', FILTER_SANITIZE_SPECIAL_CHARS);
            $password2 = $this->request->getPost('password_hash_again', FILTER_SANITIZE_SPECIAL_CHARS);

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

            if ($password1 == $password2) {
                $user->setPasswordHash($password1);
            }

            if (!$user->checkIsValidSave()) {
                throw new Exception($user->getErrorsAsString());
            }
            // Ha sikeresen elmentettük az usert, akkor siker válaszüzenet küldése
            $successMsg = 'Sikerült a regisztráció, kérjük kattintson a login menüre.';

            if (!$userModel->updatePassword($user)) {
                throw new Exception("Hiba történt a mentés során!");
            }

            $this->updateChangedPassword();
            $this->response->jsonResponse('success');

        } catch (\Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);

            $this->response->jsonResponse($exception->getMessage());
        }

    }


    public function updateChangedPassword() {

        try {
            $auth = new Authenticator();
            $user = $auth->getUser();

            $userModel = new UserModel();

            $user->setChangedPasswordAt((new DateTime('now'))->format("Y-m-d H:i:s"));
            $userModel->updateChangedPasswordAt($user);

        } catch (\Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);

            $this->response->jsonResponse($exception->getMessage());
        }
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


    public function showUserProfile(){
        $auth = new Authenticator();

        $user = $auth->getUser();
        $data = ['user' => $user]; //lekérem az adott user adatait

        $this->render('user/index', $data);
    }


    public function loadAdminPage(){
        $this->checkPermission('guest');

        $this->render('admin/index');
    }

}
