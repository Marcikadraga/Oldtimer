<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\model\color\Color;
use app\model\color\ColorModel;
use DateTime;
use Exception;
use Throwable;

class ColorController extends BaseController {

    public function GetAllColor() {

        $colorModel = new ColorModel();

        $data = [
            'colors' => $colorModel->getAllColors(),
        ];

        $this->render('color/index', $data ?? []);
    }


    public function deleteColor() {

        $colorId = $this->request->getPost('colorId', FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($colorId)) {
            throw new Exception('Hiba! A car azonosítója nem elérhető.');
        }

        $colormodel = new ColorModel();
        $result = $colormodel->delete($colorId);
        if ($result) {
            echo json_encode("success");
            return;
        }

        echo json_encode("error");
    }


    public function insertColor() {

        $errors = [];
        $errorMsg = '';
        $successMsg = '';
        $color = new Color();

        //   if ($this->request->isPostRequest()) {
        try {

            $name_of_color = $this->request->getPost('name_of_color', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $rgb = $this->request->getPost('rgb', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $colorModel = new ColorModel();

            if (empty($name_of_color)) {
                $errors['name_of_color'] = 'a szín megadása kötelező!';
            }
//            elseif (empty($rgb)) {
//                $errors['rgb'] = 'az rgb megadása kötelező!';
//            }
            if (!empty($errors)) {
                throw new Exception('Kérjük ellenőrizze az űrlapot!');
            }

            $color->setNameOfColor($name_of_color);
            $color->setRgb($rgb);
            $color->setCreatedAt(new DateTime());

            $colorModel->insertColor($color);
            $successMsg = 'Az szín hozzáadása sikerült.';

        } catch (Exception $exception) {
            // nem végleges hibakezelés!!!
            $errorMsg = $exception->getMessage();

            if (!empty($errors)) {
                $errorMsg .= '<br>' . implode('<br>', $errors);
                echo $errorMsg;
            }

        }
        //  }

        $data['errors'] = $errors;
        $data['errorMsg'] = $errorMsg;
        $data['successMsg'] = $successMsg;
        $data['submitted'] = true;
        $data['color']= new Color();

        $this->render('insertColor/index', $data);

    }


    public function updateColor() {

        // TODO ezt meg kéne csinálni később
        $this->checkAjax();
        $this->checkPermission('admin');

        try {


            $id = $this->request->getPost('id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($id)) {
                throw new Exception('Nincs id');
            }

            $colormodel = new ColorModel();
            $color = $colormodel->getById($id);
            if (empty($color)) {
                throw new Exception('Nem létezik ilyen autó');
            }

            $color->setNameOfColor($this->request->getPost("name_of_color", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $color->setRgb($this->request->getPost("rgb", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $color->setUpdatedAt(new DateTime());


            //            if (!$car->checkIsValidSave()) {
            //                throw new Exception($car->getErrorsAsString());
            //            }

            if (!$colormodel->update($color)) {
                throw new Exception('Hiba a mentés során');
            }
            echo json_encode('success');

        } catch (Throwable $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            echo json_encode($exception->getMessage(), JSON_UNESCAPED_UNICODE);
        }
        return true;
    }


    public function getColor() {

        $this->checkPermission('admin');

        $colorModel = new ColorModel();

        $result = $colorModel->getColorById($this->request->getPost('colorId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $cleared = str_replace(array("rgb", "(", ")"), '', $result["rgb"]);
        $exploded = explode(",", $cleared);

        $result['r']=$exploded[0];
        $result['g']=$exploded[1];
        $result['b']=$exploded[2];


        if ($result) {
            echo json_encode($result);
            return;
        }

        echo json_encode("error");
    }
}
