<?php

namespace app\core\routing;

use app\core\request\Request;
use JetBrains\PhpStorm\NoReturn;

class Router {

    public function __construct() { }


    /**
     * Program indítása
     * Az URL-ből kiolvassa a kontrollert és a kontroller-funkciót
     * Ha a két érték létezik a programban, akkor futtatja a kontroller-funkciót
     * @return no-return
     */
    #[NoReturn]
    public function load() {

        $request = new Request();

        // a .htaccess átalakítja az url-t paraméteressé, a paraméterek kulcsai: param1, param2, param3, ...
        // a .htaccess az index.php-ra irányít mindent, a router pedig ott kerül példányosításra
        // Ezért tudható, hogy a kontroller neve a param1, a funkció neve a param2
        // Ha nincs kontroller vagy funkció az url-ben, akkor az Index kontroller a default és az index function a default
        // Ha van kontroller, de nincs funciton, akkor az url kontroller index funkcióját töltjük be

        $controllerName = $request->getGet('param1', FILTER_SANITIZE_SPECIAL_CHARS);
        $functionName = $request->getGet('param2', FILTER_SANITIZE_SPECIAL_CHARS);

        $controllerName = !empty($controllerName) ? $controllerName : 'index';
        $functionName = !empty($functionName) ? $functionName : 'index';

        // A kezdő betű nagy betű, mert az osztályok nevei mindig nagybetűsek
        // A controller osztályok nevei is mindig nagy betűsek
        $controllerName = ucfirst($controllerName);

        // Validáljuk a kontroller, funkció létezését
        if (!$this->validate($controllerName, $functionName)) {
            die('Router: A kontroller vagy funkció az url-ben nem valid.');
        }

        // Ha valid a kontroller és a kontrollerfunkció, akkor meghatározzuk a kontroller névterét
        // A vendo/autoload betöltésével (index.php) a névterek alapján töltjük be az osztályokat
        $namespace = "app\controller\\$controllerName";

        // Példányosítjuk a kontrollert
        $controller = new $namespace;

        // Futtatjuk a kontrollerfunkciót
        $controller->$functionName();

        // Nincs tovább, a kontrollerfunkció vagy válaszol a kérésre (pl. ajax request)
        // Vagy renderel egy html oldalt és elküldi a böngészőnek
        exit();
    }


    /**
     * Validálja a kontrollert és a kontrollerfunkciót
     * @param string $controllerName Az app/controller mappában lévő kontroller osztály neve
     * @param string $functionName A kontrollerben lévő funkció neve
     * @return bool True, ha a kontroller létezik és a funkciója futtatható | false ha nem
     */
    private function validate($controllerName, $functionName): bool {

        if (!is_file("../app/controller/$controllerName.php")) {
            die('A kontroller nem létező fájl. A hibát okozó kontroller neve: ' . $controllerName);
            return false;
        }

        $namespace = 'app\controller\\' . $controllerName;

        if (!class_exists($namespace)) {
            die('A kontroller class nem létezik. A hibát okozó kontroller neve: ' . $controllerName);
            return false;
        }

        if (!method_exists($namespace, $functionName) && is_callable([$namespace, $functionName], true)) {
            die('A kontrollerfunkcó nem futtatható, a hibás funkció: ' . $functionName);
            return false;
        }

        return true;
    }
}
