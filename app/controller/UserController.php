<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\core\request\Request;
use app\core\response\Response;
use app\model\user\Authenticator;
use app\model\user\UserModel;
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

        $request = new Request();
        $userId = $request->getPost('userId', FILTER_SANITIZE_SPECIAL_CHARS);

        // CÉLSZERŰ ELLENŐRIZNI HOGY JÖTT-E ADAT

        if (empty($userId)) {
            throw new Exception('Hiba! A user azonosítója nem elérhető.');
        }

        // Megnézzük, hogy a belépett user azonos-e azzal, akit le akarunk törölni
        // Ha nem magunkat töröljük, hanem valaki mást, akkor vizsgáljuk hogy admin-e a belépett user
        // Csak az adminok törölhetnek más usereket

        if ($_SESSION['user_id'] != $userId) {
            $this->checkPermission('admin');
        }

        $userModel = new UserModel();
        $result = $userModel->delete($_POST['userId']);
        if ($result) {
            echo json_encode("success");
            return;
        }

        echo json_encode("error");
    }


    public function getUser() {

        $this->checkPermission('guest');

        $usermodel = new UserModel();
        $result = $usermodel->getUserById($_POST['userId']);
        if ($result) {
            echo json_encode($result);
            return;
        }
        echo json_encode("error");
    }


    public function update() {

        try {
            $request = new Request();

            $this->checkAjax();

            // 1 vizsgálat: szerkeszteni csak belépett user szerkeszthet
            // Itt még nem vizsgáljuk hogy admin-e a belépett user, mert az user saját adatait szerkesztheti akkor is ha nem admin
            $this->checkPermission('guest');

            $id = $request->getPost('id', FILTER_SANITIZE_SPECIAL_CHARS);
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

            $user->setUsername($request->getPost('username', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setEmail($request->getPost('email', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setFirstName($request->getPost('first_name', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setMiddleName($request->getPost('middle_name', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setLastName($request->getPost('last_name', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setBirthDate($request->getPost('birth_date', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setphoneNumber($request->getPost('phoneNumber', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setWebpage($request->getPost('webpage', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setZipCode($request->getPost('zip_code', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setCity($request->getPost('city', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setDistrict($request->getPost('district', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setMoreAddress($request->getPost('more_address', FILTER_SANITIZE_SPECIAL_CHARS));
            $user->setRole($request->getPost('role', FILTER_SANITIZE_SPECIAL_CHARS));

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

            $response = new Response();
            $response->jsonResponse('success');

        } catch (\Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            //echo json_encode($exception->getMessage());

            $response = new Response();
            $response->jsonResponse($exception->getMessage());
        }
    }
}