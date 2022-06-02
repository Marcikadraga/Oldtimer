<?php

namespace app\core\pdo;

use Exception;
use PDOStatement;

/**
 * Class CustomStatement
 *
 * Kiterjesztett PDOStatement osztály
 * Az execute sikeres lefutása esetén átadja a végrehajtott utasítást a CustomStatementDebug számára
 * Az execute hibája esetén a normál PDOException helyett egy bővített CustomStatementException exceptiont dob
 * A bővített kivételből lekérhető a hibát okozó utasítás és a hozzá tartozó paraméterlista
 *
 * @package app\core\pdo
 */
class CustomStatement extends PDOStatement {

    protected function __construct() {
        // need this empty construct()!
    }


    /**
     * Executes a prepared statement
     * @param array|null $params
     * @return bool
     * @throws CustomStatementException
     */
    public function execute(?array $params = null): bool {

        try {

            $res = parent::execute($params);

            // Az execute eredményétől függetlenül rögzítésre kerül az utolsó adatbázis-utasítás
            // A PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION miatt hiba esetén az execute kivételt dob
            // Ezért ha már itt tart a függvény, akkor valószínű nem volt hiba a query végrehajtásában

            CustomStatementDebug::getInstance()->addQuery($this->queryString, $params);

            return $res;

        } catch (Exception $exception) {
            // Az execute által dobott exception-t továbbvisszaük, kiegészítve a hibát okozó paraméterekkel
            throw new CustomStatementException($exception, $this->queryString, $params);
        }
    }
}
