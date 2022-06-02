<?php

namespace app\core\response;

use JetBrains\PhpStorm\NoReturn;

class Response {

    public function __construct() { }


    /**
     * View fájlok betöltése
     * @param string $viewFile A view fáj php kiterjesztés nélkül
     * @param array $context A view-nak átadott tartalom
     * @return no-return
     */
    #[NoReturn]
    public function render($viewFile, array $context = []) {

        // Erről majd később, ez az infó a böngészőnek segít
        header('Content-Type: text/html; charset=utf-8');

        extract($context);
        // létrejött ez a változó: $valakiNeve és létrejön ez is: $esMegValaki

        $path = "../app/view/$viewFile.php";
        if (!is_file($path)) {
            // todo jegyzet, ezt még el kell intézni
        }

        include $path;

        if (isDevMode()) {
            include '../app/core/debug/debugbar.php';
        }

        $this->exit();
    }


    /**
     *
     * @param $data
     * @param $unencoded
     * @return never
     */
    public function jsonResponse($data, $unencoded = true): never {

        // Ezzel majd később foglalkozunk, a lényeg hogy tájékoztatjuk a böngészőt hogy amit kap az biztosan json string
        header('Content-type: application/json; charset=utf-8');

        // JSON_UNESCAPED_UNICODE lényege: ha be van állítva, akkor az ékezetes karaktereket nem kódolja le
        // Ha nincs beállítva, akkor az ékezetes karakterek miatt olvashatatlan lesz a szöveg
        // Ennek leginkább a konzolra írt hibaüzenetek olvasásában van jelentősége

        if ($unencoded === true) {
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($data);
        }

        $this->exit();
    }


    /**
     * Projekten belüli átirányítás
     * @param string $uri base_url() paramétere
     * @param int $statusCode default 303 See Other
     * @return no-return
     */
    #[NoReturn]
    public function redirect($uri = '', $statusCode = 303) {

        http_response_code($statusCode);
        header('Location: ' . baseUrl($uri));
        $this->exit();
    }


    /**
     * Átirányítás a nyitólapra státusz kód beállításával
     * @param int $statusCode default 303 See Other
     * @return no-return
     */
    #[NoReturn]
    public function redirectHome($statusCode = 303) {

        if (!defined('URI_HOME')) {
            http_response_code($statusCode);
            header('Location: ' . DOMAINNAME);
            $this->exit();
        }

        $this->redirect(URI_HOME, $statusCode);
    }


    /**
     * Átirányítás a login oldalra státusz kód beállításával
     * @param int $statusCode default 403 Forbidden
     * @return no-return
     */
    #[NoReturn]
    public function redirectLogin($statusCode = 403) {

        if (!defined('URI_LOGIN')) {
            $this->redirectHome($statusCode);
        } else {
            $this->redirect(URI_LOGIN, $statusCode);
        }
    }


    /**
     * Átirányítás az admin felület nyitólapjára státusz kód beállításával
     * @param int $statusCode default 302 Found
     * @return no-return
     */
    #[NoReturn]
    public function redirectDashboard($statusCode = 302) {

        if (!defined('URI_DASHBOARD')) {
            $this->redirectHome($statusCode);
        } else {
            $this->redirect(URI_DASHBOARD, $statusCode);
        }
    }


    /**
     * Átirányítás a "nincs jogosultság" felhasználóbarát hibaoldalra
     * A hibaoldal címét az URI_403 globális konstansból olvassa ki
     * Ha ez nem létezik, akkor csak headert kap a kliens
     * @return no-return
     */
    #[NoReturn]
    public function forbiddenPage() {

        if (!defined('URI_403')) {
            $this->forbiddenHeader();
        } else {
            $this->redirect(URI_403, 403);
        }
    }


    /**
     * Átirányítás az "oldal nem található" felhasználóbarát hibaoldalra
     * A hibaoldal címét az URI_404 globális konstansból olvassa ki
     * Ha ez nem létezik, akkor csak headert kap a kliens
     * @return no-return
     */
    #[NoReturn]
    public function notFoundPage() {

        if (!defined('URI_404')) {
            $this->notFoundHeader();
        } else {
            $this->redirect(URI_404, 404);
        }
    }


    /**
     * Átirányítás az "általános szerverhiba" felhasználóbarát hibaoldalra
     * A hibaoldal címét az URI_500 globális konstansból olvassa ki
     * Ha ez nem létezik, akkor csak headert kap a kliens
     * @return no-return
     */
    #[NoReturn]
    public function internalServerErrorPage() {

        if (!defined('URI_500')) {
            $this->internalServerErrorHeader();
        } else {
            $this->redirect(URI_500, 500);
        }
    }


    /**
     * Headerválasz 403-as státus kóddal body nélkül
     * @return no-return
     */
    #[NoReturn]
    public function forbiddenHeader() {

        http_response_code(403);
        $this->exit();
    }


    /**
     * Headerválasz 404-es státus kóddal body nélkül
     * @return no-return
     */
    #[NoReturn]
    public function notFoundHeader() {

        http_response_code(404);
        $this->exit();
    }


    /**
     * Headerválasz 500-as státus kóddal body nélkül
     * @return no-return
     */
    #[NoReturn]
    public function internalServerErrorHeader() {

        http_response_code(500);
        $this->exit();
    }


    /**
     * A program kilépési pontja
     * @return no-return
     */
    #[NoReturn]
    protected function exit() {

        exit();
    }
}
