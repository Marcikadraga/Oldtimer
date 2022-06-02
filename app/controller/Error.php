<?php

namespace app\controller;

use app\core\logger\SystemLog;
use app\model\user\User;
use Exception;

class Error extends BaseController {

    public function __construct() { }


    public function forbidden() {

        http_response_code(403);
        $this->render('error/forbidden');
    }


    public function notFound() {

        http_response_code(404);
        $this->render('error/notFound');
    }


    public function internalServerError() {

        http_response_code(500);
        $this->render('error/internalServerError');
    }


    // trigger_error
    protected function hanyados($a, $b, $mertekegyseg = '%') {

        // Teljesen önkényesen építhetünk saját triggereket a függvénybe
        // Nem kötelező, de egyszerre akár több is beépíthető
        // A tartalmuk és a hiba szintje is rajtunk múlik
        // Az elérheti szintekből azt használhatjuk, ami E_USER kifejezéssel kezdődik
        // Itt az összes: https://www.php.net/manual/en/errorfunc.constants.php

        // E_USER_ERROR megállítja a programot. Akkor használjuk ha látjuk hogy a program hibára fog futni
        // Saját hibával megelőzzük, mert itt saját szöveget látunk a hibaüzenetben, ezzel talán jobban be tudjuk azonosítani a hibát

        // E_USER_WARNING figyelmeztetés, általában szokatlan viselkedés vagy potenciális hibalehetőség esetén
        // Fontos, hogy ez nem állítja meg a függvényt, csak felhívja a figyelmet egy lehetséges problémára

        // A E_USER_NOTICE és a E_USER_DEPRECATED informális üzenetek, nagyon ritkán használjuk

        // Ha olyan modult készítesz, amit más fejlesztők is széleskörben használnak, akkor ez fontos
        // A külső könyvtárak néha több ezer soros kódját nem nézzük át használat előtt, egyszerűen csak használjuk
        // Ha nem ismerjük a kódót akkor jól jöhet egy-egy ilyen triggerelt üzenet, akár információ, akár hibaüzenet
        // Saját programba, de még a cégen belüli ügyviteli rendszerbe se írunk notice és deprecated üzenetet,
        // Errort és warningot is csak ritkán, főleg akkor ha olyan függvény készül, amit sok különböző helyen mindenki használ (pl. helperek)

        // Az üzenetek formázhatók is, de rendszerszintű hibakezelés esetén ez inkább csak problémát okoz, úgyhogy nem javasolt
        // Akkor van értelme, ha csak a default hibakezelés van a rendszerben, ami egyszerűen csak a képernyőre printelteted a hibákat

        trigger_error('A függvény <i style="background-color:darkred; color: white">elavult</i>, a következő verzióban törlésre kerül.', E_USER_DEPRECATED);

        if ($b == 0) {
            trigger_error('A hányados függvény nem fogadhat el olyan osztót, aminek az értéke 0', E_USER_ERROR);
        }

        $result = $a / $b;

        if ($result < 0) {
            trigger_error('A hányados függvény negatív eredményt adott.', E_USER_WARNING);
        }

        if (empty($mertekegyseg)) {
            trigger_error('A hányados függvényt mértékegység nélkül használták.', E_USER_NOTICE);
        }

        return $result . ' ' . $mertekegyseg;
    }


    // Hibák előidézése, hibák szintjei
    public function e1() {

        $mertekegyseg = '';

        /*
         * A php függvények hibás használata esetén különféle szintű hibák triggerelődnek
         * A leggyakrabban az "error" a "warning" a "notice" és a "deprecated" látható
         * Itt az összes: https://www.php.net/manual/en/errorfunc.constants.php
         *
         * Ezeket a hibákat mi is triggerelhetjük, de ritkán használjuk
         * Leginkább a core mappában lévő függvényekben jöhetnek szóba
         */

        // Ez hibát okoz, mert a fájl nem létezik
        $filename = './uploads/tmp/createFile13.txt';
        $content = file_get_contents($filename);

        // Ez pedig tele van saját trigger errorral
        $hanyados = $this->hanyados(1, -1, $mertekegyseg);
        echo '<br>' . $hanyados;

        $this->render('index/index');
    }


    // error_reporting
    public function e2() {

        // error_reporting: a hibakezelés szintje
        // Az itt beállított szintnél gyengébb hibákat a php "elnyeli"
        // Teljesen mindegy milyen hibakezelést építesz, ha a reportingot E_ERROR-ra állítod, akkor warning hibákkal soha nem fogsz találkozni

        // A beállítás attól a ponttól érvényes, amikor megtörténik, ezért rendszer szinten célszerű az index.php első soraiban elvégezni
        // A beállítás felülírható (gyakorlatilag a php.ini-t módosítod vele)
        // https://www.php.net/manual/en/function.error-reporting.php

        // Ezek a kifejezések pl: E_ERROR, E_NOTICE stb. valójában előre definiált konstansok és egy integer van mögöttük
        // A kód könnyebb olvashatósága érdekében hozták létre, de megadhatók a függvénynek a rendes integer változatok is

        // Az error és a warning mutatása, a többit a php elnyeli
        // Ezek csak a php beépített hibái, a saját triggerünk nincs benne
        //error_reporting(E_ERROR | E_WARNING | E_USER_WARNING | E_USER_NOTICE);

        // Az error és a warning mutatása
        // A php beépített hibái és a saját triggeink is
        // error_reporting(E_ERROR | E_WARNING | E_USER_ERROR | E_USER_WARNING);

        // Az összes hiba mutatása, kivéve a php notice hibákat
        // error_reporting(E_ALL & ~E_NOTICE);
        // Itt a saját trigger notice is az elnyelt hibák közé kerül
        // error_reporting(E_ALL & ~E_NOTICE & ~E_USER_NOTICE);

        // Report all PHP errors
        // error_reporting(E_ALL);

        // Minden hiba mutatása
        // error_reporting(-1);

        // Minden hiba rejtése
        // error_reporting(0);

        // Ez hibát okoz, mert a fájl nem létezik
        $filename = './uploads/tmp/createFile13.txt';
        $content = file_get_contents($filename);

        // Ez pedig tele van saját trigger errorral
        $hanyados = $this->hanyados(1, -1, '');

        $this->render('index/index');
    }


    // display_errors
    public function e3() {

        // A hibákat el lehet rejteni a képernyőről
        // A display_errors 0 esetén a hibák nem jelennek meg a képernyőn
        // Ha értékük 1, akkor láthatók a képernyőn (az error_reporting-ban beállított szintig!)

        ini_set('display_errors', '0');
        error_reporting(E_ALL);

        $hanyados = $this->hanyados(1, 1, '');

        // A hibákat a @ jellel függvényenként egyedileg is elfedhetjük
        // Ilyenkor ez a hiba a memóriában marad, de kiolvasható (ld következő)
        $filename = './uploads/tmp/createFile13.txt';
        $content = @file_get_contents($filename);
    }


    // error_get_last és @
    public function e4() {

        // A hibákat közvetlenül a létrejöttük után kiolvashatjuk az error_get_last segítségével
        // Ez egy tömböt ad vissza a hiba szintjével, tartalmával és helyével, erre egyedi hibakezelés is építhető

        ini_set('display_errors', '1');

        $filename = './uploads/tmp/createFile13.txt';
        $content = @file_get_contents($filename);

        if (!empty(error_get_last())) {
            echo '<br>Hiba: ' . error_get_last()['message'];
            echo '<br>Típus: ' . error_get_last()['type'];
            echo '<br>Fájl: ' . error_get_last()['file'];
            echo '<br>Sor: ' . error_get_last()['line'];
        }

        // Néhány függvény egyedi hibakezelő függvénnyel bír, pl. json függvények json_last_error(); json_last_error_msg();
        // Ezeket gyakrabban használom, majd megmutatom ha jsonnal foglalkozunk. Az error_get_last függvényt szinte soha nem használom
    }


    // set_error_handler és register_shutdown_function
    public function e5() {

        // A hibákra központilag is lehet egy függvény építeni és ez az a megoldás, amit rendszerszinten használni kell!
        // Ha bekövetkezik egy hiba (akár beépített error, akár saját trigger), akkor a php megnézi az error_reporting beállítást
        // Ha a hiba szintje olyan, hogy az error_reporting szerint nem érdekes, akkor itt megáll a dolog, a php "elnyeli" a hibát
        // Ha a hiba az error_reporting beállítasai alapján kellően magas szintű, akkor az error_handler függvényt hívja meg a hiba kezelésére
        // Az error_handler alapértelmezetten a képernyőre printeli a hibát ha a display_errors (vagy a hibát okozó függvény előtti @) ezt nem tiltja meg neki
        // A hiba részletei az error_get_last() függvénnyel is elérhetők, ha érdekelne valakit (ha megnézed, akkor alapértelmezetten ezt printeli a képernyőre a php)
        // Kb. ez történik egy hiba esetén a php-ban

        // Ha készítesz egy saját error_handler függvényt, akkor a set_error_handler() segítségével lecserélheted a php beépített metódusát
        // Itt gyakorlatilag azt csinálsz a hibával, amit akarsz. A legjobb logika szerintem, ha a php-t a következőképpen állítjuk be:
        // A monitorra soha, semmi nem juthat ki: ini_set('display_errors', '0');
        // Minden hibára kíváncsiak vagyunk, a php semmit nem nyelhet el: error_reporting(E_ALL);
        // A saját error handlerben megvizsgáljuk hogy a rendszer fejlesztői módban van-e vagy sem
        // Fejlesztői módban képernyőre printeljük a hibát, ha nem fejleszői módban vagyunk, akkor logoljuk a hibát

        // Az error_handler mindenféle beépített php hibát és triggerelt errort képes kezelni, kivéve azt, ami megállítja a scriptet
        // Nekünk viszont ez a hiba a legfontosabb, hiszen tudni kell hogy mitől omlott össze a rendszer (azaz mi okozott E_ERROR vagy E_USER_ERROR szintű hibát)
        // A php-nak van egy jó tulajdonsága a shutdown function. Ez egy olyan funkció, ami mindig lefut ha végetér a program, és elment a response a kliens felé
        // Tök mindegy hogy volt-e hiba vagy sem, hogy a rendszer összeomlott-e vagy sem. A php úgy takarítja ki magát a memóriából, hogy zárásként futtatja ezt a függvényt
        // Ez alapértelmezett üres, a php nem csinál ilyenkor semmit, de készíthetünk egy saját függvényt amit átadhatunk a php-nak a register_shutdown_function()-nal
        // Na ez a másik pont, ahova hibakezelést kell építeni. Itt már nincs túl sok lehetőségünk (képernyőre nem írhatunk, mert a képernyőre szánt adatok már elmentek a böngésző felé)
        // Itt már csak logolhatunk, esetleg elküldhetjük emailben a kritikus hibát, ez már rajtunk múlik. Az a lényeg, hogy ha kritikus hiba okozta a leállást, akkor annak a részletei itt még megfoghatók

        // A két hibakezelő eljárást az index.php első soraiban érdemes elhelyezni, hogy az összes hibára érvényesek legyenek
        // Ha valahol a kontroller közepén állítanád be, akkor pl. a routingban keletkező hibák a php default hibakezelésével lennének kezelve
        // A php egy szálon futó történet, és minden request esetén újraindul a program. Ezért az index.php-t a hibakezelések beállításával kell mindig indítani
    }


    // Kivételkezelés try-catch és exception
    public function e6() {

        // Egy függvényen belül azokat a logikai hibákat, amiknek meg kell szakítaniuk a függvényt, kivételkezeléssel oldjuk meg
        // A kontrollerekben a hibakezelésnek ez az általánosan elterjedt módja

        // A helyes gyakorlat az, ha a modelfüggvények true/false értéket adnak vissza
        // A kontroller ezt levizsgálja és ha false az eredmény, akkor exceptionnal megszakítja a vizsgálatot

        try {

            $password1 = 'abc123';
            $password2 = 'abc1234';

            $user = new User();

            $filename = './uploads/tmp/createFile1.txt';
            $content = file_get_contents($filename);
            if(empty($content)){
                throw new Exception('Hiba, a fájl üres.');
            }

            if (!$user->isPasswordStrongTest($password1)) {
                throw new Exception($user->getErrorsAsString());
            }

            if (!$user->isEquals($password1, $password2)) {
                throw new Exception('Hiba! A két jelszó nem egyezik.');
            }

        } catch (Exception $exception) {
            $log = new SystemLog();
            //$log->warning($exception->getMessage());
            $log->exceptionLog($exception);
            $data['error'] = $exception->getMessage();
        }

        $this->render('index/index', $data);
    }
}
