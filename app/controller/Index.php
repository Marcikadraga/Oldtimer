<?php

namespace app\controller;

use app\core\request\Request;
use app\core\response\Response;
use app\model\user\Authenticator;
use PDO;

class Index extends BaseController {

    /**
     * @route domain felkeresése
     */
    public function index() {

        $data = [];

        $this->render('index/index', $data);
    }


    public function feladat() {

        $kotojelesString = 'ez-marci-hazi-feladata-nem-surgos-megcsinalni';
        $camelCaseString = 'ezMarciHaziFeladataNemSurgosMegcsinalni';
        $snakeCaseString = 'ez_marci_hazi_feladata_nem_surgos_megcsinalni';

        echo "<p>Az eredeti kötőjeles string: $kotojelesString</p>";
        echo '<hr>';

        $resultCamelCase = $this->toCamelCase($kotojelesString);
        if ($resultCamelCase == $camelCaseString) {
            echo "<p style='color: green'>A camel case függvény működik!<br>A kapott eredmény: $resultCamelCase</p>";
        } else {
            echo "<p><span style='color: red'>A camel case függvény nem működik.</span><br>A kapott eredmény: $resultCamelCase</p>";
        }

        echo '<hr>';

        $resultSnakeCase = $this->toSnakeCase($kotojelesString);
        if ($resultSnakeCase == $snakeCaseString) {
            echo "<p style='color: green'>A snake case függvény működik!<br>A kapott eredmény: $resultSnakeCase</p>";
        } else {
            echo "<p><span style='color: red'>A snake case függvény nem működik.</span><br>A kapott eredmény: $resultSnakeCase</p>";
        }
    }


    /**
     * A függvény a paraméterben kapott kötőjeles stringből camelCase stílusú stringet készít
     * @param string $string A string kötőjelekkel tagolt változata
     * @return string A string camelCase változata
     */
    protected function toCamelCase($string): string {

        // Ide egy olyan string-kezelő eljárás kell, ami átalakítja a kötőjeles stringet camelCase stílusúra

        return $string;
    }


    /**
     * A függvény a paraméterben kapott kötőjeles stringből snake_case stílusú stringet készít
     * @param string $string A string kötőjelekkel tagolt változata
     * @return string A string snake_case változata
     */
    protected function toSnakeCase($string): string {

        // Ide egy olyan string-kezelő eljárás kell, ami átalakítja a kötőjeles stringet snake_case stílusúra

        return $string;
    }


    //region Oktatási anyag

    protected function gyorsbillentyuk() {

        // Keresés: Ctrl+F
        // Csere: Ctrl+R
        // Globális keresés: Ctrl+Shift+F
        // Globális csere: Ctrl+Shift+R

        // A megnyitott oldalon az adott sorra ugrás: Ctrl+G
        // A gyors hibakeresésben segít, mert a hiba sorát általában ismerjük

        // Auto formázás: Ctrl+Alt+L
        // Import optimalizálása (use szakasz a fájlban): Ctrl+Alt+O (ez egy nagy o betű, nem nulla!)
        // Mindent összecsuk: Ctrl+Shift és "-" gomb
        // Mindent kinyit: Ctrl+Shift és "+" gomb

        // A mindent kinyit kétlépcsős művelet: elsőre összecsukva marad az, amire az editorban ezt külön beállítottad (pl. fggüvények, region tagek, stb.)
        // Ha másodszorra is megnyomod a Ctrl+Shift és a "+" kombinációt, akkor mindent kinyit a kódban, amit csak ki lehet nyitni

        //region Kódrészleteket egységbe lehet zárni a region tagokkal

        // Ezzel össze lehet csukni a nagyobb szakaszokat és áttekihtetővé válik a kód
        // Ide jöhet akár több száz sor kód, amit egy kattintással el lehet rejten

        //endregion

        // Alt+Insert: az osztályon belül generál automatikusan függvényeket (kontstruktort, gettereket, settereket stb.)

    }


    protected function databaseExample() {

        // A PHP-ban adatbázisspecifikus függvények vannak, pl:
        // mysql (elavult!): https://www.php.net/manual/en/ref.mysql.php
        // mysql (mysqli): https://www.php.net/manual/en/book.mysqli.php
        // postgre_sql: https://www.php.net/manual/en/ref.pgsql.php
        // mssql: https://www.php.net/manual/en/ref.sqlsrv.php

        // Évek óta általános javaslat, hogy az adatbázisspecifikus függvények helyett a PDO használata javasolt
        // A PDO egy absztrakciós réteg, gyakorlatilag a fenti függvények fölé rakott egységesítő eljárás.
        // Előnyei:
        //    minden támoagtott adatbázishoz ugyanazzal a módszerrel csatlakozunk
        //    minden adatbázis-queryt ugyanazokkal a függvényekkel tudjuk végrehajtani az összes adatbázis esetén
        //    a kódunk univerzálisabb, átláthatóbb lesz ha mindenki ezt a módszert használja mert olyanok is megértik, akik esetleg nem ismerik az mssql vagy mysql függvényeket

        // Fontos, a kód ettől még nem lesz csereszabatos, azaz a mögötte lévő adatbázist nem lehet csak úgy leváltani mysql-ről pl. postgre_sql-re
        // Pl. mysql-ben van limit záradék, ami az mssql-ben hibát dob (ott TOP van helyette)
        // Pl. mysql-ben lekérhető az inserttel beszúrt sor id-ja, postgre_sql-ben erre külön utasítást kell írni

        // Adatbázisváltás esetén a query-ket az adatbázishoz kell igazítani, és az adatbázisspecifikus függvényeket lecserélni
        // PDO használata esetén csak a query-t kell módosítani a queryt végrehajtó php függvényeket nem kell átírogatni

        // A mysql adatbázishoz való csatlakozás ezeket a paramétereket igényli
        $settings = [
            'DB_HOST'     => 'localhost',
            'DB_NAME'     => 'marci',
            'DB_CHARSET'  => 'utf8',
            'DB_USER'     => 'root',
            'DB_PASSWORD' => ''
        ];

        // A DB_USER felhasználóval kapcsolatban nagyon fontos követelmény:
        // Természetesen mindig legyen jelszava, egyedül localhoston hagyható el ez a dolog (DB_PASSWORD)
        // Root joggal csak localhoston, fejlesztés során kapcsolódhatunk az adatbázishoz
        // Éles rendszerben az adatbázis-user jogait mindig a projekthez kell igazítani
        // SELECT joga biztosan kell hogy legyen
        // INSERT és UPDATE joga általában kell hogy legyen
        // DELETE joga már nem mindig kell (pl. valódi törlés helyett deleted_at mező használata esetén nem kell)
        // A többi jog, pl. DROP TABLE vagy ALTER TABLE már szinte biztos hogy nem kell az usernek

        // Csatlakozás a mysql adatbázishoz (a többi típushoz is így kell csatlakozni, csak a $dsn stringet kell máshogy felépíteni)
        $dsn = 'mysql:host=' . $settings['DB_HOST'] . ';dbname=' . $settings['DB_NAME'] . ';charset=' . $settings['DB_CHARSET'];
        $pdo = new PDO($dsn, $settings['DB_USER'], $settings['DB_PASSWORD']);
        // Hibakezelés szintjének javasolt beállítása: a PDO példányunk minden hiba esetén exceptiont dob
        // Ha ezt a beállítást használod, akkor a pdo és statement mindig try-catch hibakezelésben legyen (hibakezelésről későb...)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //region Példa adatbázis-lekérdezésre
        // Az összes user lekérdezése

        $query = 'SELECT * FROM users';

        $statement = $pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // A result itt egy array, benne asszociatív tömbökkel,
        // Annyi asszoc tömb van a befoglaló array-ban ahány találatot adott a query
        // A szerkezet kb. így néz ki, feldolgozni pedig egy foreach ciklussal kell
        $result = [
            [
                'id'         => 1,
                'username'   => 'username1',
                'first_name' => 'Teszt Elek',
                'birth_date' => '2022-01-01',
            ],
            [
                'id'         => 2,
                'username'   => 'username2',
                'first_name' => 'Vicc Elek',
                'birth_date' => '2022-01-01',
            ],
        ];

        if (!empty($result)) {
            foreach ($result as $row) {
                // Itt $row az adatbázistábla egy sora, azaz a példánkban egy user összes tulajdonsága
            }
        }

        // Ha 1 db user adatait szeretnénk beszerezni
        $userId = 121;

        $query = 'SELECT * FROM users WHERE id=? LIMIT 1'; // a limit 1 elhagyható ha a tábla auto incremept primary kulcsára szűrünk
        $params = [$userId];

        $statement = $pdo->prepare($query);
        $statement->execute($params);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // A result itt is egy array, de a feltételek miatt csak 1 db asszoc tömb van benne,
        // Ez általában becsapja az embert, mert az hiszi hogy a result önmagában az egy db user lesz
        // Pedig a result egy array, amiben benne van az 1 db keresett userünk adatai
        $result = [
            [
                'id'         => 1,
                'username'   => 'username1',
                'first_name' => 'Teszt Elek',
                'birth_date' => '2022-01-01',
            ],
        ];

        // Az user adatait tartalmazó tömbhöz így juthatunk hozzá
        // Ha nem üres a $result, akkor a 0. eleme a keresett user
        $row = !empty($result) ? $result[0] : [];

        // A $statement objectből többféle fetch módszerrel is kinyerhető az adat
        // Gyakorlási időszakban használd mindig a fetchAll-t ami az összes lekérdezett sort egy tömbben visszaadja
        // Módként pedig a PDO::FETCH_ASSOC, ami miatt a sorok asszociatív tömbökként lesznek jelen az eredményben
        // Én 95%-ban még a mai napig ezt a fetch módszert használom mert szerintem ez a legegyértelműbb és igyekszem egy projekten belül azonos stílusban dolgozni

        //endregion

        //region Példa insert-re

        // A query kétféle paraméterezéssel készülhet: egyszerű helyörzőkkel és nevesített helyörzőkkel

        // Az egyszerű helyörzők szimpla ? jelek és a hozzá tartozó paraméterlistában sorrendben vannak az adatok
        // Általában akkor használjuk, ha csak egy-két paramétert kell átadni a pdo-nak (pl. a fenti select userId alapján)
        // De használható ez a paraméterezés az összes lehetséges query-ben is, pl. insert update vagy delete

        $query = '
        INSERT INTO users (username, first_name, birth_date, created_at, updated_at)
        VALUES (?,?,?,?,?)';

        $params = [
            '2022-01-01',
            'username3',
            'Trab Antal',
            date('Y-m-d H:i:s', time()),
            date('Y-m-d H:i:s', time()),
        ];

        // Nevesített helyörzőkkel átláthatóbb a dolog, főleg a sok paramétert tartamazó query esetén
        // Ilyenkor a pdo-nak átadott paraméterlista egy asszociatív tömb lesz

        $query = '
        INSERT INTO users (username, first_name, birth_date, created_at, updated_at)
        VALUES (:username_valami, :first_name, :birth_date, :created_at, :updated_at)';

        $params = [
            'birth_date'      => '2022-01-01',
            'username_valami' => 'username3',
            'first_name'      => 'Trab Antal',
            'created_at'      => date('Y-m-d H:i:s', time()),
            'updated_at'      => date('Y-m-d H:i:s', time()),
        ];

        // Adatbázisírás
        $statement = $pdo->prepare($query);
        $statement->execute($params);

        // Az execute visszatérési értéke boolean
        // Ha a pdo-ba beállítottuk az exceptiont (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) akkor nem kell vizsgálni a true/false értéket
        // Ilyenkor siker esetén true, hiba esetén elszáll az egész egy exceptionnal (amit később persze elkapunk és a megfelelő módon kezeljük)

        // A beszúrt sor id-ja így kérhető le (mysql-ben fixen működik)
        $id = $pdo->lastInsertId();

        // Egyéb megoldások

        // A pdo-t lehet más módon is paraméterezni, pl. a bindParam vagy bindValue utasítással
        // Szerintem a bemutatott két módszer a legegyszerűbb, én 99%-ban ezt használom a mai napig

        // Egy projekten belül vagy az execute paramétert vagy a bindParam/bindValue függvényeket használd
        // A két módszert "csak úgy" ne váltogasd, az a jó ha egységes a kód

        // Értékátadás
        $statement = $pdo->prepare($query);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->bindValue(':age', $age, PDO::PARAM_INT);
        $statement->execute();

        // Referenciaátadás
        $statement = $pdo->prepare($query);
        $statement->bindParam(':username', $user->getName(), PDO::PARAM_STR);
        $statement->bindParam(':first_name', $firstName, PDO::PARAM_INT);
        $statement->execute();

        // https://stackoverflow.com/questions/1179874/what-is-the-difference-between-bindparam-and-bindvalue

        // A Codeigniter nem PDO-t használ, hanem egy ahhoz nagyon hasonló de saját készítésű objectet
        // A Codeigntierben a fenti megoldás az egyedüli, úgyhogy ezért is jobb ha ahhoz szoksz hozzá :)

        //endregion

        //region Példa update query-re

        // Az update is lehet egyszerű ?-es vagy nevesített paraméteres
        // Itt is az dönt főleg hogy milyen sok a paraméter

        $query = '
        UPDATE users
        SET username=:username,
            first_name=:first_name,
            birth_date=:birth_date,
            updated_at=:updated_at
        WHERE id=:id';

        $params = [
            'id'         => 3,
            'username'   => 'username3',
            'first_name' => 'Városi Virág',
            'birth_date' => '2022-01-01',
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];

        $statement = $pdo->prepare($query);
        $statement->execute($params);

        // Az excecute itt is boolean, de itt sem vizsgáljuk
        // Hiba esetén exceptiont várunk, amit majd feldolgozunk

        //endregion

        //region Példa az adatok törlésére

        // Törölni lehet véglegesen is az adatbázisból

        $query = 'DELETE FROM users WHERE id=?';
        $params = [$userId];

        $statement = $pdo->prepare($query);
        $statement->execute($params);

        // Nagyobb rendszerekben ez inkább egy udpate, ahol értéket kap a deleted_at tulajdonság
        // Az ügyviteli rendszerben is ritka az olyan tábla, ahonnan véglegesen kitöröljük az adatokat

        $query = 'UPDATE users SET deleted_at=? WHERE id=?';
        $params = [date('Y-m-d H:i:s', time()), $userId]; // sorrend a query-ben lévő ? jeleknek megfelelően!!

        $statement = $pdo->prepare($query);
        $statement->execute($params);

        // Az ilyen soft delete befolyásolja a select utasításokat is
        // Ilyen esetben az adatbázisban így keresünk

        // Az összes user keresése
        $query = 'SELECT * FROM users WHERE deleted_at IS NULL';
        $params = [];

        // vagy

        // Egy konkrét user keresése
        $query = 'SELECT * FROM users WHERE id=? AND deleted_at IS NULL';
        $params = [$userId];

        //endregion
    }


    //region Fájlkezelésről leírás

    private function getTestContent() {

        $content = 'Lórum ipse feltehetőleg ötves, de anás, hogy nem a korhely veség van beállítva. A havinra füremek cseti körment számodjanak magukkal. Egy ártázás tanság, puszték 8-14 merci gulások részére. A csavinós handiumot nyüzsgés várda, válás parna, vasmás kösztés, bőgő nyugazás, pula, búgatások talapítják. A jöverének hurcolhatják a lelőhöz pertő fagyás frázásokat. Jógat zúgánok runuta (hanyus, vítás, tőség, girgálság, sivada). A táncok után a jöverének szónhatnak, zelságba izálhatnak más maritár és fáros bonákat. A vinidés és szecska után betető 10-14 merci jöverének a párias zatisztatban kező házások során sározhatnak meg a körverhevék angyáival, katáival.' . PHP_EOL . PHP_EOL;
        return $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content . $content;
    }


    // marci2.dev/file/createFile1
    public function createFile1() {

        $filename = './uploads/tmp/createFile1.txt';
        $content = $this->getTestContent();

        $index = 0;

        do {
            if (($handle = fopen($filename, 'a')) === false) {
                die('A fájt nem sikerült megnyitni.');
            }
            if (flock($handle, LOCK_EX) === false) {
                die('A fájlt nem sikerült kizárólagos használatba venni.');
            }
            if (fwrite($handle, $content) === false) {
                die('A fájlt nem sikerült írni.');
            }
            if (fclose($handle) === false) {
                die('A fájlt nem sikerült lezárni.');
            }
        } while ($index++ < 100);

        $this->render('index/index');
    }


    // marci2.dev/file/createFile2
    public function createFile2() {

        $filename = './uploads/tmp/createFile2.txt';
        $content = $this->getTestContent();

        // file_put_contents() ezt a három eljárást futtatja: fopen(), fwrite() fclose() a LOCK_EX esetén még ezt is: flock()
        // FILE_APPEND: az új tartalmat az előző után fűzi a fájlban, ha ez nincs, akkor a meglévő tartalom felülírásra kerül
        // LOCK_EX: kizárólagos használat, amig a fájllal dolgozik, addig más nem tudja módosítani

        $index = 0;

        do {
            if (file_put_contents($filename, $content, FILE_APPEND | LOCK_EX) === false) {
                die('A fájl írása nem sikerült');
            }
        } while ($index++ < 100);

        $this->render('index/index');
    }


    // marci.dev/file/lockTest1/chrome
    public function lockTest1() {

        $request = new Request();
        $param3 = $request->getGet('param3', FILTER_SANITIZE_SPECIAL_CHARS);

        $filename = './uploads/tmp/lockTest.txt';
        $content = $param3 . PHP_EOL;

        $index = 0;

        if (($handle = fopen($filename, 'a')) === false) {
            die('A fájt nem sikerült megnyitni.');
        }
        if (flock($handle, LOCK_EX) === false) {
            die('A fájlt nem sikerült kizárólagos használatba venni.');
        }

        do {

            if (fwrite($handle, $content) === false) {
                die('A fájlt nem sikerült írni.');
            }

            sleep(1);

        } while ($index++ <= 10);

        if (fclose($handle) === false) {
            die('A fájlt nem sikerült lezárni.');
        }

        $this->render('index/index');
    }


    // marci.dev/file/lockTest2/edge
    public function lockTest2() {

        $request = new Request();
        $param3 = $request->getGet('param3', FILTER_SANITIZE_SPECIAL_CHARS);

        $filename = './uploads/tmp/lockTest.txt';
        $content = $param3 . PHP_EOL;

        $index = 0;

        do {
            if (file_put_contents($filename, $content, FILE_APPEND | LOCK_EX) === false) {
                die('A fájl írása nem sikerült');
            }

            sleep(1);

        } while ($index++ <= 10);

        $this->render('index/index');
    }


    // marci.dev/file/lockTest3/firefox
    public function lockTest3() {

        $request = new Request();
        $param3 = $request->getGet('param3', FILTER_SANITIZE_SPECIAL_CHARS);

        $filename = './uploads/tmp/lockTest.txt';
        $content = $param3 . PHP_EOL;

        $index = 0;

        if (($handle = fopen($filename, 'a')) === false) {
            die('A fájt nem sikerült megnyitni.');
        }
        if (flock($handle, LOCK_EX) === false) {
            die('A fájlt nem sikerült kizárólagos használatba venni.');
        }

        do {
            if (fwrite($handle, $content) === false) {
                die('A fájlt nem sikerült írni.');
            }

            sleep(1);

        } while ($index++ <= 10);

        if (fclose($handle) === false) {
            die('A fájlt nem sikerült lezárni.');
        }

        $this->render('index/index');
    }


    public function read() {

        $filename = './uploads/tmp/createFile1.txt';

        if (($content = file_get_contents($filename)) === false) {
            die('A fájlt nem sikerült megnyitni és a tartalmát beolvasni.');
        }

        //echo $content;

        // memóriafelszabadítás
        $content = null;
        unset($content);

        // Az unset után a változó nem létezik (az echo hibát fog dobni)
        // echo $content;

        $this->render('index/index');
    }

    //endregion

    //endregion
}
