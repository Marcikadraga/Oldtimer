<?php

namespace app\core\pdo;

use Exception;
use PDO;

class PDOConnect {

    protected ?PDO             $pdo      = null;
    private static ?PDOConnect $instance = null;


    private function __construct() {

        $this->connect();
    }


    /**
     * Visszaadja az adatbáziskapcsolatot tartalmazó példányt
     * Singleton pattern: ez az osztály csak egyszer példányosodik
     * Ezt az egy példányt pedig maga az osztály tartalmazza
     * @return PDOConnect
     */
    public static function getInstance(): PDOConnect {

        if (is_null(self::$instance)) {
            self::$instance = new PDOConnect();
        }
        return self::$instance;
    }


    /**
     * Adatbáziskapcsolat létesítése
     * PDO példányosítása az osztályváltozóba
     * @return void
     */
    public function connect(): void {

        $file = "../app/config/PDOConfig.php";
        $settings = include $file;

        try {
            $dsn = 'mysql:host=' . $settings['DB_HOST'] . ';dbname=' . $settings['DB_NAME'] . ';charset=' . $settings['DB_CHARSET'];
            $this->pdo = new PDO($dsn, $settings['DB_USER'], $settings['DB_PASSWORD']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS, [CustomStatement::class, []]);
        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    /**
     * Adatbáziskapcsolat használata
     * @return PDO|null Null, ha nincs kapcsolat
     */
    public function getPDO(): ?PDO {

        return $this->pdo;
    }


    /**
     * Adatbáziskapcsolat bontása
     * @return void
     */
    public function destroy(): void {

        $this->pdo = null;
    }

}
