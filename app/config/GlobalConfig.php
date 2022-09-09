<?php

/*
 * --------------------------------------------------------------------------
 * Működési beállítások
 * --------------------------------------------------------------------------
 *
 * CI_ENVIRONMENT: fejlesztői módban 'development' | éles üzemben: 'production'
 * A biztonság kedvéért kódban mindig CI_ENVIRONMENT == 'development' tesztet végzünk
 * Javasolt az isDevMode globális függvény használata
 */
const CI_ENVIRONMENT = 'development';

/*
 * Szerver dátum-idő
 * Ha a szerver pontosan van beállítva, ez kikommentelhető
 */

date_default_timezone_set('Europe/Budapest');

/*
 * --------------------------------------------------------------------------
 * Hibakezelés
 * --------------------------------------------------------------------------
 *
 * Javasolt: semmilyen hiba nem látható a böngészőben, de minden hibára kíváncsiak vagyunk
 * A hibák naplózását a rendszerben a SystemLog errorHandler funkciója végzi
 * A funkciót meg kell hívni a set_error_handler és register_shutdown_function callbackekben (index.php)
 * A logolásra kerülő hibák szintjét a ERROR_REPORTING tömbbel lehet testreszabni
*/

ini_set('display_errors', '0');
error_reporting(E_ALL);
const ERROR_REPORTING = [
    E_ERROR,
    E_WARNING,
    E_PARSE,
    E_NOTICE,
    E_CORE_ERROR,
    E_CORE_WARNING,
    E_COMPILE_ERROR,
    E_COMPILE_WARNING,
    E_USER_ERROR,
    E_USER_WARNING,
    E_USER_NOTICE,
    E_STRICT,
    E_RECOVERABLE_ERROR,
    E_DEPRECATED,
    E_USER_DEPRECATED,
    E_ALL
];

/*
 * --------------------------------------------------------------------------
 * Útvonalak
 * --------------------------------------------------------------------------
 *
 * A program a felhasználóbarát útvonalakat htaccess átirányítással biztosítja
 * A htaccess minden olyan kérést, ami nem fizikai fájl, az index.php-ra irányít,
 * A '/' jellel tagolt URL-t paraméteres stringgé alakítja, az esetleges paramétereket megtartja
 *
 * Példa egy felkeresett útvonal tényleges átirányítására:
 * http://localhost/hu/login/logout?=userId=1
 * http://localhost/index.php?param1=hu&param2=login&param3=logout&userId=1
 *
 * DOMAINNAME: a protokol és domain záró '/' karakterrel
 * Ha módosul a domain, akkor elegendő ezt módosítani mert a rendszer minden útvonalában ezt a konstans használja
 *
 * Opcionális konstansok, a rendszer beépített átirányító funkció ezekre az útvonalakra mutatnak
 * Ha valamelyik nem létezik, (pl. nincs felhasználóbarát 403-as oldal), akkor kommenteld ki a sort
 * URI_HOME: nyitólap
 * URI_LOGIN: login oldal
 * URI_DASHBOARD: bejelentkezés után ide irányít a rendszer
 * URI_403: "Hozzáférés megtagadva" felhasználóbarát hibaoldala
 * URI_404: "Az oldal nem található" felhasználóbarát hibaoldal
 * URI_500: "Szerverhiba" felhasználóbarát hibaoldal
*/
const DOMAINNAME = 'https://marci.dev/';
const URI_HOME = '/';
const URI_LOGIN = 'login';
const URI_DASHBOARD = 'Usercontroller/loadAdminPage';
const URI_403 = 'error/forbidden';
const URI_404 = 'error/notFound';
const URI_500 = 'error/internalServerError';

/*
 * --------------------------------------------------------------------------
 * Sessionkezelés
 * --------------------------------------------------------------------------
 *
 * SESSION_SAVE_PATH: Session fájlok elérési útja
 * A mappa létezését biztosítani kell, a program nem tudja létrehozni
 * Ha nem akarod felügyelni a session fájlokat, akkor kommenteld ki
 *
 * SESSION_VALIDITY_TIME: A munkamenet érvényességi ideje másodpercben
 * Ennyi idő múlva automatikusan kilépteti a rendszer a bejelentkezett usert
*/
const SESSION_SAVE_PATH = '../writable/session/';
const SESSION_VALIDITY_TIME = 21600; // secundum
