<?php

namespace app\controller;

use app\core\request\Request;
use app\core\response\Response;
use app\model\user\Authenticator;

abstract class BaseController {

    protected Request  $request;
    protected Response $response;


    public function __construct() {

        $this->request = new Request();
        $this->response = new Response();
    }

    //region checkAjax: ajax request tesztelése


    /**
     * AJAX Requestek esetén futtatandó vizsgálat
     * Ellenőrzi a kérést, hogy szabályos ajax request-e vagy sem
     * Ha nem szabályos, akkor elutasítja a kérést, egyébként nincs művelet
     * @return void
     */
    protected function checkAjax(): void {

        if (!$this->request->isAjaxRequest()) {

            // Ha a kérés nem ajax request, akkor a kérést elutasítjuk
            // GET kérés esetén a felhasználóbarát rendszerhiba oldalt jelenítjük meg
            // POST kérés esetén egy szabványos hibaüzenetet küldünk, amit a js valószínűeg fel tud dolgozni
            // Egyelőre nincs meghatározva a szabályos js válasz szerkezete, de kb. az $msg-hez fog hasonlítani...

            if ($this->request->isGetRequest()) {
                $this->response->internalServerErrorPage();
            }
            if ($this->request->isPostRequest()) {

                $msg = [
                    'type' => 'error',
                    'body' => 'A kérés nem valid ajax request.',
                ];

                $this->response->jsonResponse($msg);
            }
        }

    }

    //endregion

    //region checkPermission: a belépett user és jogosultságvizsgálata

    /**
     * Validálja a bejelentkezett usert requestet
     * Ha a kérés nem valid, akkor átirányít a login oldalra
     * A login oldalon hibaüzenetben látható az elutasítás oka
     * @return void
     */
    private function authenticateUser(): void {

        $auth = new Authenticator();
        if (!$auth->validation()) {

            // A validációban lefutott 4 vizsgálat: userId, time, ip, userAgent
            // Ha valamelyiken megbukott az user, akkor megjelenítjük a login formot
            // És egy szabályos, felhasználóbarát hibaüzenettel tájékoztatjuk az elutasítás okáról

            $_SESSION['invalidAuthenticator'] = $auth->getErrorsAsString();


            $this->response->redirectLogin();
        }
    }


    /**
     * Validálja a bejelentkezett usert requestet
     * És megvizsgálja hogy az user rendelkezik-e admin jogokkal
     * Ha a kérés nem valid, akkor átirányít a login oldalra
     * A login oldalon hibaüzenetben látható az elutasítás oka
     * @return void
     */
    private function authenticateAdmin(): void {

        // A logikája hasonló a fenti authenticateUser függvényhez
        // De itt egy második vizsgálat is történik: userIsAdmin

        $invalidAuthenticator = '';

        $auth = new Authenticator();
        if (!$auth->validation()) {
            $invalidAuthenticator = $auth->getErrorsAsString();
        } elseif (!$auth->userIsAdmin()) {
            $invalidAuthenticator = 'Hiba! Az oldal megtekintése adminisztrátori joghoz kötött. Kérjük jelentkezzen be egy admin fiókkal.';
        }

        if ($invalidAuthenticator != '') {

            // Az usert kiléptetjük, ezzel a sessiont lezárjuk és töröljük
            // A session újra indul, és kap egy push hibaüzenetet

            $auth->logout();

            sessionStart();
            $_SESSION['invalidAuthenticator'] = $invalidAuthenticator;
            $this->response->redirectLogin();
        }
    }


    /**
     * Belépett user ellenőrzése
     * Hiba esetén átirányítás a login oldalra, egyébként nincs művelet
     * @param string $role A jogosultság szintje: guest | admin
     * @return void
     */
    protected function checkPermission($role): void {

        // Erre a függvényre a rendszerben igazán nincs szükség
        // Azért hoztam létre, mert az ügyviteli rendszerben is hasonló a jogosultsági vizsgálat
        // A függvény neve ott is checkPermission, és vár egy paramétert ami alapján eldöni hogy a belépett usernek van-e joga a művelethez

        switch ($role) {
            case 'user':
            case 'guest':
                $this->authenticateUser();
                break;
            case 'admin':
                $this->authenticateAdmin();
                break;
            default:
                trigger_error('A checkPermission nem tudja értelmezni a következő paramétert: ' . $role, E_USER_ERROR);
        }
    }

    //endregion


    /**
     * A kontrolerek által használt egységes render funkció
     * Kiegészíti a kontextust a belépett user információival, ami a menükezeléshez szükséges
     * @param string $viewFile
     * @param array $context
     * @return never
     */
    protected function render($viewFile, array $context = []): never {


        // Ezt a két adatot a view-nak mindenképpen át kell adni
        // Mivel a headerben a menü attól függően jelenik meg hogy van-e belépett user és hogy az admin-e vagy sem
        // A header/menü minden oldalon betöltődik, ezért erre a két adatra minden oldalon szükség van

        $auth = new Authenticator();
        $context['isLoggedInUser'] = $auth->isLoggedInUser();
        $context['userIsAdmin'] = $auth->userIsAdmin();
        $context['greetingsName']=$auth->getUsername();

        $this->response->render($viewFile, $context);
    }
}

