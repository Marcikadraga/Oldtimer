<?php

namespace app\core\logger;

use app\core\response\Response;
use Exception;
use Stringable;
use Throwable;

/**
 * Rendszerlog
 * @package app\core\logger
 */
class SystemLog {

    /**
     * A rendszerben lévő logfájlok mappájának relatív elérési útja
     * A helyes működés feltételezi hogy a string zárókaraktere egy "/" jel!
     * LogConfig-ból betöltött adat
     * @var string
     */
    private $folderRelativePath;

    /**
     * A rendszerben lévő logfájlok mappájának abszolut elérési útja a szerveren
     * A helyes működés feltételezi hogy a string zárókaraktere egy "/" jel!
     * A register_shutdown_function callback függvényében használjuk, ahol nem garantált a relatív elérési utak működése
     * @link https://www.php.net/manual/en/function.register-shutdown-function.php#59300
     * LogConfig-ból betöltött adat
     * @var string
     */
    private $folderAbsolutePath;

    /**
     * A naplóbejegyzésekben alkalmazott dátumformátum
     * A DateTime object konstruktora által elfogadott formátum
     * @link https://www.php.net/manual/en/datetime.format.php
     * LogConfig-ból betöltött adat
     * @var string
     */
    protected string $dateFormat;

    /**
     * Logtípusok olyan eseményekhez, amiket nem a default rendszerlogban szeretnénk rögzíteni
     * Ezeket a fájlokat a log-gyökérkönyvtáron belül az itt megadott almappákban hozza létre a rendszer
     * Mappanevek listája, ezért csak olyan karaktereket tartalmazzon, amiből mappa készíthető
     * LogConfig-ból betöltött adat
     * @var string[]
     */
    private $logTypes;

    /**
     * A logtípushoz tartozó logfájl elérési útja
     * A setLogFile ad értéket a paraméterében kapott logType alapján
     * @var string
     */
    protected string $logFile = '';


    /**
     * SystemLog constructor.
     */
    public function __construct($logType = '') {

        $file = "../app/config/LogConfig.php";
        if (!is_file($file)) {
            $file = 'C:\laragon\www\marci\app\config\LogConfig.php'; // todo shtudown handler probléma
        }
        $settings = include $file;

        $this->folderRelativePath = $settings['folderRelativePath'];
        $this->folderAbsolutePath = $settings['folderAbsolutePath'];
        $this->dateFormat = $settings['dateFormat'];
        $this->logTypes = $settings['logTypes'];

        $this->setLogFile($logType);
    }


    /**
     * A logtípushoz tartozó előre definiált logfájl beállítása
     * Ha a paraméter üres, akkor a gyökérben lévő default logfájl kerül beállításra (default)
     * @param string $logType A LogConfig a logTypes array egy kulcsa vagy 'shutdown'
     */
    public function setLogFile($logType = ''): void {

        // Ha létezik a paraméterben kapott típus a logTypes tömbben, akkor összeállítjuk a hozzá tartozó útvonalat,
        // Egyébként a gyökérben készül a log (shutdown funkció esetén a ez szerveren abszolut útvonal)

        if ($logType == 'shutdown') {
            $filepath = $this->folderAbsolutePath;
        } elseif (array_key_exists($logType, $this->logTypes)) {
            $filepath = $this->folderRelativePath . $logType . '/';
        } else {
            $filepath = $this->folderRelativePath;
        }

        // A fájlnév mindig fixen az aktuális dátum lesz egy 'log-' prefixel
        $filename = 'log-' . date('Y-m-d', time()) . '.log';

        // Az elérési út és a fájlnév összefűzése
        $this->logFile = $filepath . $filename;

        // A mappa létezésének biztosítása
        if (!is_dir($filepath)) {
            if (@mkdir($filepath, 0777, true) === false) {
                // A mappa létrehozásának hibáját a szerverlogban rögzítjük
                $errorMsg = ['Hiba történt a logfájl készítése során. A következő mappa nem hozható létre: ' . $filepath];
                $errorMsg[] = 'error_get_last: ' . json_encode(error_get_last(), JSON_UNESCAPED_UNICODE);
                error_log(implode(PHP_EOL, $errorMsg), 0);
            }
        }
    }


    /**
     * A paraméterben kapott érték stringgé alakítása
     * @param mixed $mixed A stringgé alakítandó változó
     * @return string
     */
    protected function parseToString($mixed): string {

        if (is_string($mixed)) {
            return $mixed;
        } elseif ($mixed === true) {
            return 'true';
        } elseif ($mixed === false) {
            return 'false';
        } elseif (is_null($mixed)) {
            return 'null';
        } elseif (is_array($mixed)) {
            return json_encode($mixed, JSON_UNESCAPED_UNICODE);
        } elseif (is_object($mixed)) {
            if (method_exists($mixed, '__toString')) {
                return strval($mixed);
            } else {
                return get_class($mixed) . ' object';
            }
        } else {
            $mixed = @strval($mixed);
        }

        if (is_string($mixed)) {
            return $mixed;
        } else {
            return 'Hiba! A logger nem képes stringgé alakítani a kapott $message változó értékét.';
        }
    }


    /**
     * Visszaadja a level NAGYBETŰS változatát
     * Az integerként kapott level dekódolására szolgál
     * @param mixed $level A hiba szintje, pl E_WARNING
     * @return string
     */
    protected function levelToString($level): string {

        // A level értéke lehet egy szövegesen megadott saják kifejezés, pl 'ERROR'
        // Vagy egy előre definiált php konstans, pl: E_USER_ERROR, ami mindig egy számjegyet takar
        // Az előre definiált konstanst olvasható stringgé alakítjuk. A szintek innen származnak:
        // https://www.php.net/manual/en/errorfunc.constants.php

        $levelString = trim((string)$level);

        if (is_numeric($levelString)) {
            switch ($levelString) {
                case E_ERROR:
                case E_USER_ERROR:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_RECOVERABLE_ERROR:
                case E_PARSE:
                    $levelString = 'error';
                    break;
                case E_WARNING:
                case E_USER_WARNING:
                case E_CORE_WARNING:
                case E_COMPILE_WARNING:
                    $levelString = 'warning';
                    break;
                case E_NOTICE:
                case E_USER_NOTICE:
                    $levelString = 'notice';
                    break;
                case E_STRICT:
                    $levelString = 'strict';
                    break;
                case E_DEPRECATED:
                case E_USER_DEPRECATED:
                    $levelString = 'deprecated';
                    break;
            }
        }

        return strtoupper($levelString);
    }


    /**
     * Logbejegyzés összeállítása
     * Biztosítja az egységes logszerkezetet a rendszerben
     * @param mixed $level A logbejegyzés szintje
     * @param mixed $message A logbejegyzés tartalma
     * @return string
     */
    protected function createContent($level, $message): string {

        // Level és message string jellegének biztosítása
        $level = $this->levelToString($level);
        $message = $this->parseToString($message);

        // Aktuális időpont meghatározása
        $date = date($this->dateFormat, time());

        // Egységes szerkezet biztosítása
        return $level . ' - ' . $date . ' --> ' . $message . PHP_EOL . PHP_EOL;
    }


    /**
     * Logfájl írása
     * @param string $content
     * @return void
     */
    protected function write(string $content): void {

        try {
            if (empty($this->logFile)) {
                throw new Exception('A logfájl nem létezik.');
            }

            $result = @file_put_contents($this->logFile, $content, FILE_APPEND | LOCK_EX);

            if ($result === false) {
                throw new Exception('A fájl írása nem sikerült. Error_get_last: ' . json_encode(error_get_last()));
            }
            if ($result == 0) {
                throw new Exception('A fájlba írt tartalom 0 byte. Error_get_last: ' . json_encode(error_get_last()));
            }
        } catch (Exception $exception) {

            // A logfájl írásának hibáját a szerver logba vezetjük
            // Ha az eredeti tartalom elérhető, azt is hozzáfűzzük

            $errorMsg = ['Hiba történt a logfájl készítése során.'];
            $errorMsg[] = 'A hiba oka: ' . $exception->getMessage();
            $errorMsg[] = 'A sikertelen log tartalma: ' . PHP_EOL . $content;
            error_log(implode(PHP_EOL, $errorMsg), 0);
        }
    }


    /**
     * Napló, tetszőleges szinttel
     * @param mixed $level
     * @param string|Stringable $message
     * @return void
     */
    public function log($level, $message): void {

        $this->write($this->createContent($level, $message));
    }


    /**
     * EMERGENCY: A rendszer használhatatlan
     * @param string|Stringable $message
     */
    public function emergency($message): void {

        $this->write($this->createContent('EMERGENCY', $message));
    }


    /**
     * CRITICAL: Kritikus hibák
     * @param string|Stringable $message
     */
    public function critical($message): void {

        $this->write($this->createContent('CRITICAL', $message));
    }


    /**
     * ALERT: Futásidejű hibák, amik azonnali beavatkozást igényelnek
     * @param string|Stringable $message
     */
    public function alert($message): void {

        $this->write($this->createContent('ALERT', $message));
    }


    /**
     * ERROR: Futásidejű hibák, amik nem igényelnek azonnali beavatkozást, de figyelni kell rájuk
     * @param string|Stringable $message
     */
    public function error($message): void {

        $this->write($this->createContent('ERROR', $message));
    }


    /**
     * WARNING: Rendszerösszeomlást nem okozó, de a működésre hatással lévő hibák
     * @param string|Stringable $message
     */
    public function warning($message): void {

        $this->write($this->createContent('WARNING', $message));
    }


    /**
     * NOTICE: normális, de jelentős események
     * @param string|Stringable $message
     */
    public function notice($message): void {

        $this->write($this->createContent('NOTICE', $message));
    }


    /**
     * INFO: Informális események
     * @param string|Stringable $message
     */
    public function info($message): void {

        $this->write($this->createContent('INFO', $message));
    }


    /**
     * DEBUG: Hibakeresés során történt bejegyzés
     * @param string|Stringable $message
     */
    public function debug($message): void {

        $this->write($this->createContent('DEBUG', $message));
    }


    /**
     * Kezelt kivételek logolása
     * @param Throwable|null $throwable
     */
    public function exceptionLog(?Throwable $throwable = null): void {

        try {
            if (empty($throwable)) {
                return;
            }

            $contentNew = 'Exception: ';
            $contentNew .= $throwable->getMessage() ?? 'nem ismert';
            $contentNew .= PHP_EOL;

            if (method_exists($throwable, 'getDebugQuery')) {
                $contentNew .= 'Debug query: ';
                $contentNew .= $throwable->getDebugQuery() ?? 'nem ismert';
                $contentNew .= PHP_EOL;
            }

            $contentNew .= 'Exception code: ';
            $contentNew .= $throwable->getCode() ?? 'nem ismert';
            $contentNew .= PHP_EOL;
            $contentNew .= 'Exception file: ';
            $contentNew .= $throwable->getFile() ?? 'nem ismert';
            $contentNew .= PHP_EOL;
            $contentNew .= 'Exception line: ';
            $contentNew .= $throwable->getLine() ?? 'nem ismert';
            $contentNew .= PHP_EOL;
            $contentNew .= 'Exception trace: ';
            $contentNew .= PHP_EOL;
            $contentNew .= $throwable->getTraceAsString() ?? 'nem ismert';
            $contentNew .= PHP_EOL;
            $contentNew .= 'LOGGED USER ID: ';
            $contentNew .= $this->getUserId();

            // A kivételek mindig error szintű hibával rögzülnek a naplóba
            $this->error($contentNew);

        } catch (Exception $exception) {
            error_log('Hiba történt az exception log összeállítása során.' . PHP_EOL . $exception->getMessage(), 0);
        }
    }


    /**
     * set_error_handler és register_shutdown_function által használt funkció
     * @link https://www.php.net/manual/en/function.set-error-handler.php
     * @param integer $errno
     * @param string $errstr
     * @param string $errfile
     * @param integer $errline
     * @return bool
     */
    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline): bool {

        // Ha a hiba szintje nem meghatározható, vagy nem szerepel a logolásra előírt típusok között, false
        if (empty($errno) || !in_array($errno, ERROR_REPORTING)) {
            return false;
        }

        $msg = $errstr . PHP_EOL;

        switch ($errno) {
            case E_ERROR:
            case E_USER_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_RECOVERABLE_ERROR:
            case E_PARSE:

                // Végzetes futásidejű hibák, a szkript leáll
                $msg .= 'Err type: FATAL ERROR (' . $errno . ')' . PHP_EOL;
                $msg .= 'Err file: ' . $errfile . PHP_EOL;
                $msg .= 'Err line: ' . $errline;
                $this->alert($msg);

                $response = new Response();
                $response->internalServerErrorHeader();
                break;

            case E_WARNING:
            case E_USER_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:

                // Figyelmeztetések, a script nem áll le, de nem működik megfelelően
                $msg .= 'Err type: WARNING (' . $errno . ')' . PHP_EOL;
                $msg .= 'Err file: ' . $errfile . PHP_EOL;
                $msg .= 'Err line: ' . $errline;
                $this->warning($msg);
                break;

            case E_NOTICE:
            case E_USER_NOTICE:
            case E_STRICT:

                // Futás idejű értesítések, a script nem áll le
                $msg .= 'Err type: NOTICE (' . $errno . ')' . PHP_EOL;
                $msg .= 'Err file: ' . $errfile . PHP_EOL;
                $msg .= 'Err line: ' . $errline;
                $this->notice($msg);
                break;

            case E_DEPRECATED:
            case E_USER_DEPRECATED:

                // Elavult, kivonásra kerülő dolgok
                $msg .= 'Err type: DEPRECATED (' . $errno . ')' . PHP_EOL;
                $msg .= 'Err file: ' . $errfile . PHP_EOL;
                $msg .= 'Err line: ' . $errline;
                $this->notice($msg);
                break;

            default:

                // Egyéb, ismeretlen hibák
                $msg .= 'Err type: UNKOWN ERROR (' . $errno . ')' . PHP_EOL;
                $msg .= 'Err file: ' . $errfile . PHP_EOL;
                $msg .= 'Err line: ' . $errline;
                $this->error($msg);
                break;
        }

        return true;
    }


    /**
     * Biztonsággal kiolvassa a sessionban tárolt userid-t
     * Ha nincs userid, akkor a válasz: "nem ismert"
     * @return string
     */
    protected function getUserId(): string {

        if (session_status() === PHP_SESSION_ACTIVE) {
            if (array_key_exists('userid', $_SESSION)) {
                return (string)$_SESSION['userid'];
            }
        }
        return 'nem ismert';
    }

}
