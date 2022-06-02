<?php

namespace app\core\pdo;

use Exception;

/**
 * Class CustomStatementDebug
 *
 * A PDO Statement debugolását segítő osztály
 * Egy belső változóban automatikusan gyűjti a statement execute által végrehajtott query stringeket
 *
 * @package app\core\pdo
 */
class CustomStatementDebug {

    /** @var CustomStatementDebug|null Singleton pattern példány */
    private static ?CustomStatementDebug $instance = null;

    /**
     * A statement execute által végrehajtott query stringek
     * A stringekben lévő helyörzők tényleges értékekkel helyettesítettek
     * @var string[]
     */
    private array $executedQueries = [];


    private function __construct() { }


    public static function getInstance(): CustomStatementDebug {

        if (is_null(self::$instance)) {
            self::$instance = new CustomStatementDebug();
        }
        return self::$instance;
    }


    /**
     * Lecseréli a query stringben lévő paramétereket a nekik megfelelő value értékkel
     * @param string $query A paraméteres query string
     * @param array $params A paramétereket tartalmazó array
     * @return string A végrehajtnató adatbázis utasítás
     * Hiba esetén visszaadja a $query eredeti tartalmát és E_USER_NOTICE
     */
    public function interpolateQuery($query, $params = []): string {

        if (empty($params)) {
            return $query;
        }

        try {
            // Ezt a függvényt nem csak debugolásra lehet használni
            // Automatikusan meghívja a statement is az execute során
            // Másolat azért készül, hogy a statementben lévő adatokat még véletlenül se tudja módosítani

            $pattern = [];
            $replacement = $params;
            $queryString = $query;

            foreach ($replacement as $key => &$value) {
                if (is_string($key)) {
                    $pattern[] = "/:$key/";
                } else {
                    $pattern[] = '/[?]/';
                }

                if (is_string($value)) {
                    $value = "'$value'";
                } elseif (is_null($value)) {
                    $value = 'NULL';
                } elseif (true === $value) {
                    $value = 'TRUE';
                } elseif (false === $value) {
                    $value = 'FALSE';
                }

                // integer és float esetén nincs művelet
            }

            $result = @preg_replace($pattern, $replacement, $queryString, 1);

            // A preg_replace hiba esetén NULL-t ad vissza vagy E_WARNING-ot dob
            // A két lehetőséget kivétellé alakítjuk és NOTICE szintre csökkentjük

            if (!empty($query) && empty($result)) {
                $errorMsg = 'Hiba történt a query string interpolációja során. A hiba oka: ';
                $errorLast = error_get_last();
                $errorMsg .= !empty($errorLast) ? $errorLast['message'] : 'nem ismert.';
                throw new Exception($errorMsg);
            }

            return $result;

        } catch (Exception $exception) {
            trigger_error($exception->getMessage(), E_USER_NOTICE);
        }

        return $query;
    }


    /**
     * Felesleges szóközök eltávolítása a stringből
     * @param string $query
     * @return string
     */
    public function clearQuery($query): string {

        while (str_contains($query, '  ')) {
            $query = str_replace('  ', ' ', $query);
        }

        $query = str_replace(PHP_EOL . ' ', PHP_EOL, $query);

        return trim($query);
    }


    /**
     * Annak vizsgálata, hogy van-e végrehajtott query string
     * @return bool True ha van végrehajtott query string | False ha nincs
     */
    public function hasExecutedQuery(): bool {

        return !empty($this->executedQueries);
    }


    /**
     * Bővíti a végrehajtott query stringek listát
     * @param string $query Interpolált query string
     */
    public function addQuery($query, $params = []): void {

        $string = $this->interpolateQuery($query, $params);
        $string = $this->clearQuery($string);

        $this->executedQueries[] = $string;
    }


    /**
     * Visszaadja a végrehajtott query stringek listáját
     * @return string[]
     */
    public function getAllQueries(): array {

        return $this->executedQueries;
    }


    /**
     * Visszaadja az utoljára végrehajtott query stringet
     * @return string Ha nem volt még adatbázis-művelet, akkor empty string
     */
    public function getLastQuery(): string {

        if (!empty($this->executedQueries)) {
            return end($this->executedQueries);
        }

        return '';
    }

}
