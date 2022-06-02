<?php

namespace app\model;

use app\core\logger\SystemLog;
use app\core\pdo\CustomStatementException;
use app\core\pdo\PDOConnect;
use PDO;
use Throwable;

abstract class BaseModel {

    /**
     * PDO adatbáziskapcsolat
     * A konstruktorban kap értéket
     * @var PDO|null
     */
    protected ?PDO $pdo;

    /**
     * Modelhibák tömbje
     * Értéke kiolvasható a getErrors és a getErrorsAsString fügvényekkel
     * @var array
     */
    protected array $errors = [];

    /**
     * A model hibakezelője által használt naplófájl
     * Az app/config/LogConfig.php logTypes array kulcsai közül lehet kiválasztani a lehetséges naplókat
     * Ha értéke empty string, akkor a központi naplófájlba írja logot
     * @var string
     */
    protected string $logType = '';


    /**
     * Minden Model kontroller konsturktora
     * Ha van paraméterben pdo, akkor azt használja a Model az összes query futtatása során
     * Ha a paraméter üres, akkor a központi pdo objectet használja (singleton pattern!)
     * @param PDO|null $pdo
     */
    public function __construct(?PDO &$pdo = null) {

        $this->pdo = $pdo ?? PDOConnect::getInstance()->getPDO();
    }


    /**
     * A model adatbáziskezelőiben javasolt egységes logolási eljárás
     * @param Throwable $exception A handler által kezelt exception
     * @param string $queryType A hibát okozó query típusa select | insert | update | delete
     */
    protected function errorHandling(Throwable $exception, string $queryType = 'select'): void {

        $log = new SystemLog($this->logType);

        if (isDevMode()) {

            // Ha fejlesztői módban vagyunk, akkor összeállítunk egy tetszőleges de informatív hibaüzenetet
            // És kiírjuk a képernyőre a hiba részleteit. A scriptet E_USER_ERROR hibával állítjuk meg.
            // Egy adatbázis-hiba nem feltétlenül okoz rendszerösszeomlást, úgyhogy az E_USER_ERROR egy kicsit erős hiba itt
            // Azért alkalmazzuk, hogy a fejlesztés/tesztelés során biztosan felderítésre kerüljön minden hibás adatbázis-művelet

            $msg = [];
            $msg[] = 'Adatbázishiba! ' . $exception->getMessage();

            // Ha az exceptiont a $statement->execute() dobja, akkor CustomStatementException-t kapunk
            // Ebben azért lehetünk biztosak, mert a core/pdo mappában felüldefiniáltunk egy sor alapértelmezett eljárást
            // A CustomStatementException azért készült, hogy a hibakezelés során ismert legyen a hibát okozó query string

            if ($exception instanceof CustomStatementException) {

                $msg[] = PHP_EOL;
                $msg[] = 'Query String';
                $msg[] = $exception->getQueryString();

                $msg[] = PHP_EOL;
                $msg[] = 'Debug Query';
                $msg[] = $exception->getDebugQuery();
            }

            $msg[] = PHP_EOL;
            $msg[] = $exception->getTraceAsString();

            $msg = implode(PHP_EOL, $msg);

            $log->debug($msg);
            trigger_error($msg, E_USER_ERROR);

        } else {

            // Ha éles üzemben vagyunk, akkor csak egy sablonüzenetet engedünk ki a rendszerből
            // A hiba valódi okát logoljuk a későbbi hibakeresés érdekében

            $log->exceptionLog($exception, 'alert');
            $this->errors[] = match ($queryType) {
                'select' => 'Hiba történt az adatok lekérdezése során.',
                'insert' => 'Hiba történt az adatok beszúrása során.',
                'update' => 'Hiba történt az adatok frissítése során',
                'delete' => 'Hiba történt az adatok törlése során',
                default => 'Ismeretlen hiba történt, kérjük próbálja meg később',
            };
        }
    }


    /**
     * Visszaadja a modelhibák tömbjét
     * @return array
     */
    public function getErrors(): array {

        return $this->errors;
    }


    /**
     * Visszaadja a modelhibákat
     * @param string $separator A hibák közötti elválasztó karakter/karaktersorozat
     * @return string
     */
    public function getErrorsAsString($separator = '<br>'): string {

        return implode($separator, $this->errors);
    }
}
