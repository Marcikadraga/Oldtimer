<?php

use app\core\logger\SystemLog;
use app\core\request\Request;
use app\core\response\Response;
use app\core\routing\Router;

//region PHP verzióellenőrzés - Csak új rendszer beállítása során használt eljárás
// Működő rendszerben felesleges minden request esetén futtatni az ellenőrzést
// Fejlesztés alatt, főleg amikor az ügyviteli rendszer miatt váltogatni kell a php verziót viszont lehet értelme :)

$minPHPVersion = '8.0';
if (version_compare(PHP_VERSION, $minPHPVersion, '<')) {
    die("Your PHP version must be {$minPHPVersion} or higher to run CodeIgniter. Current version: " . PHP_VERSION);
}
unset($minPHPVersion);
//endregion

// Globális konfigurációk és függvények betöltése
require_once '../app/config/GlobalConfig.php';
require_once '../app/core/functions/functions.php';

// Composer autoloader betöltése
require_once '../vendor/autoload.php';

//region Error handler region
/*
 * Config/GlobalConfig.php beállítások:
 * display_errors: 0 semmilyen hibát nem mutatunk meg a böngészőben
 * error_reporting: E_ALL: minden hibával foglalkozunk, ami a rendszerben keletkezik
 * Az összes rendszerhibát a SystemLog errorHandler függvénye naplózza.
 *
 * A hibák többségét a set_error_handler megfogja, kivéve a program teljes összeomlását okozó 'fatal error' végzetes hibákat.
 * A végzetes hibák okozta programleállás után is lefut a a shutdown funciton, ahol logolhatjuk ezeket a hibákat
 */

set_error_handler(function ($errno, $errstr, $errfile, $errline) {

    // $exit: true esetén megszakítja a hibakezelés a folyamatot
    // $level: csak fejlesztői módban megjelenített hiba szintje

    switch ($errno) {
        case E_ERROR:
        case E_USER_ERROR:
        case E_CORE_ERROR:
        case E_COMPILE_ERROR:
        case E_RECOVERABLE_ERROR:
        case E_PARSE:
            $level = "Fatal error!";
            $exit = true;
            break;
        case E_WARNING:
        case E_USER_WARNING:
        case E_CORE_WARNING:
        case E_COMPILE_WARNING:
            $level = "Warning!";
            $exit = false;
            break;
        case E_NOTICE:
        case E_USER_NOTICE:
        case E_STRICT:
            $level = "Notice!";
            $exit = false;
            break;
        case E_DEPRECATED:
        case E_USER_DEPRECATED:
            $level = "Deprecated!";
            $exit = false;
            break;
        default:
            $level = "Unknown error type: [$errno]!";
            $exit = false;
            break;
    }

    // A hibával csak akkor foglalkozunk, ha előfordul a figyelt hibákat leíró konstans tömbben
    // Ha nem fordul elő, akkor a fent meghatározott $exit vizsgálatával kilépünk a hibakezelésből

    if (in_array($errno, ERROR_REPORTING)) {

        // Fejlesztői környezetben képernyőre tesszük a hibákat
        // Éles környezetben az else ágnak megfelelően csak logolunk

        if (defined('CI_ENVIRONMENT') && CI_ENVIRONMENT == 'development') {

            $message = str_replace(["\r\n", "\n", "\r"], '<br>', htmlspecialchars(strip_tags($errstr)));

            echo "
            <div style = 'background-color: #910101; color: #ffffff; margin: 5px; padding: 10px; z-index: 999999; position: sticky; top: 0; right: 0; left: 0;'>
                <div style='position:relative'>
                    <div id='close-error-$errline' style='font-weight: bold; position: absolute; right: 0; top: -10px; cursor: pointer;'>×</div>
                    <p><span style = 'font-weight: bold; margin-right: 5px'>$level</span>$message</p>
                    <p>File: $errfile<br>Line: $errline</p>
                </div>
            </div>
            <script>
                document.getElementById('close-error-$errline').addEventListener('click', function(e) { e.target.parentNode.parentNode.remove();});
            </script>";

        } else {

            $log = new SystemLog();
            $log->errorHandler($errno, $errstr, $errfile, $errline);
        }
    }

    if ($exit === true) {
        $response = new Response();
        $response->internalServerErrorHeader();
    }
});

register_shutdown_function(function () {

    /*
     * https://www.php.net/manual/en/function.set-error-handler.php
     * The following error types cannot be handled with a user defined function:
     * E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR,
     * E_COMPILE_WARNING independent of where they were raised, and most of E_STRICT
     * raised in the file where set_error_handler() is called.
     *
     * Ezeket a hibákat a shutdown funkcióval foghatjuk meg, ami a script leállása után mindig lefut.
     * Ha a script hiba miatt állt meg, az error_get_last() array értékkel rendelkezik, ezt rögzítjük
     */

    /*
     * https://stackoverflow.com/questions/8440439/safely-catch-a-allowed-memory-size-exhausted-error-in-php
     * Biztonsági okokból a shutdown_function lefoglal egy bizonyos mennyiségű memóriaterületet
     * A lefoglalt memóriaterület a hibakezelés során felszabadul, így biztonsággal tudjuk kezelni a memóriatúlcsordulási hibákat is
     */

    $memory = new SplFixedArray(524288); // 0,5 Mb

    $error = error_get_last();
    if (!empty($error)) {

        // Memóriafelszabadítás
        $memory = null;
        unset($memory);

        // Fejlesztői környezetben képernyőre tesszük a hibákat
        // Éles környezetben az else ágnak megfelelően csak logolunk

        if (defined('CI_ENVIRONMENT') && CI_ENVIRONMENT == 'development') {

            $message = str_replace(["\r\n", "\n", "\r"], '<br>', htmlspecialchars(strip_tags($error['message'])));

            echo "
            <div style = 'background-color: #910101; color: #ffffff; margin: 5px; padding: 10px; z-index: 999999; position: sticky; top: 0; right: 0; left: 0;'>
                <div style='position:relative'>
                    <p><span style = 'font-weight: bold; margin-right: 5px'>Kritikus rendszerhiba (level=" . $error['type'] . ")!</span>$message</p>
                    <p>File: " . $error['file'] . "<br>Line: " . $error['line'] . "</p>
                </div>
            </div>";

        } else {

            $log = new SystemLog('shutdown');
            $log->errorHandler($error['type'], $error['message'], $error['file'], $error['line']);
        }

        $response = new Response();
        $response->internalServerErrorHeader();
    }
});

//endregion

// Mielőtt a routert elindítjuk, validáljuk a kérést
// Jelenleg 2 dolgot vizsgálunk: van-e ip cím és van-e böngésző
// Ha valamelyik hiányzik, elutasítjuk a kérést (csak headert küldünk)

$request = new Request();
if (!$request->validate()) {

    $log = new SystemLog();
    $log->alert($request->getErrorsAsString());

    $response = new Response();
    $response->forbiddenHeader();
}

$router = new Router();
$router->load();

