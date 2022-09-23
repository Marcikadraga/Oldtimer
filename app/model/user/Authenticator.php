<?php

namespace app\model\user;

use app\core\logger\SystemLog;
use app\core\request\Request;
use Cassandra\Date;
use Exception;
use PDO;

/**
 * A bejelentkezett user validátora
 * Sessionkezelést végez - másra ne használd
 */
class Authenticator {

    /** @var array Validációs hibák gyűjtője */
    private array $errors = [];

    /** @var User|null A bejelentkezett user */
    private ?User $user = null;


    public function __construct() {

        sessionStart();
    }


    /**
     * Hozzáadja az user azonosítóját a sessionhoz
     * Sessionba kerül az összes további azonosító adat
     * @param int $userId
     * @return void
     */
    public function login($userId): void {

        $_SESSION['userid'] = $userId;
        $_SESSION['login_time'] = time();

        $request = new Request();
        $_SESSION['ip_address'] = $request->getIpAddress();
        $_SESSION['user_agent'] = $request->getUserAgent();
    }


    /**
     * Eltávolítja az usert a sessioból
     * @return void
     */
    public function logout(): void {

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }


    /**
     * A bejelentkezett usert validálja a session alapján
     * @return bool
     */
    public function validation(): bool {

        $this->errors = [];

        if (!$this->isLoggedInUser()) {
            $this->errors[] = 'Nincs bejelentkezett felhasználó, az oldal megtekintése regisztrációhoz kötött.';
        } else {
            if ($this->getLoginTime() + SESSION_VALIDITY_TIME < time()) {
                $this->errors[] = 'Letelt a rendszer használatára engedélyezett időkorlát.';
            }

            // Kérdés: az alábbi két vizsgálat eredményét ki kell-e írni a monitorra vagy utasítsuk-e inkább el a kérést
            // Ezek olyan hibák, amiket egy átlagos user nem tud elkövetni, ehhez már "ügyeskedés" kell
            // Ebben a teszt projektben kiírjuk a képernyőre, csak hogy gyakoroljuk a session push üzeneteket

            $request = new Request();
            if ($_SESSION['ip_address'] != $request->getIpAddress()) {
                $this->errors[] = 'Hiba! Az IP cím nem azonos a bejelentkezéskor rögzített IP címmel.';
            }
            if ($_SESSION['user_agent'] != $request->getUserAgent()) {
//                $this->errors[] = 'Hiba! A böngésző nem azonos a bejelentkezéskor rögzített böngészővel.';
            }
        }

        return empty($this->errors);
    }


    /**
     * Visszaadja a bejelentkezett user id-ját
     * @return int Ha nincs belépett user, akkr int(0)
     */
    public function getUserId(): int {

        if (array_key_exists('userid', $_SESSION)) {
            return (int)$_SESSION['userid'];
        }
        return 0;
    }


    /**
     * Visszaadja a bejelentkezés idejét UNIX timestamp formában
     * @return int Ha nincs belépett user, akkor int(0)
     */
    public function getLoginTime(): int {

        if (array_key_exists('login_time', $_SESSION)) {
            return (int)$_SESSION['login_time'];
        }
        return 0;
    }


    /**
     * Visszaadja a bejelentkezett usert
     * @return User|null Ha nincs belépett user, akkor null
     */
    public function getUser(): ?User {

        if (is_null($this->user) && !empty($this->getUserId())) {
            $userModel = new UserModel();
            $this->user = $userModel->getById($this->getUserId());
        }
        return $this->user;
    }


    /**
     * Annak vizsgálata, hogy van-e belépett user a rendszerben vagy nincs
     * @return bool True ha van belépett user | False ha nincs
     */
    public function isLoggedInUser(): bool {

        return !empty($this->getUserId()) && !empty($this->getLoginTime());
    }

    public function ShowLoginTime(){
        //TODO A Márk azt mondta, hogy szerinte nem a feladatot csináltam meg (jogos).
        return date('Y/m/d H:i:s', strtotime( SESSION_VALIDITY_TIME." seconds"));
    }


    /**
     * Annak vizsgálata, hogy a belépett user admin jogú-e vagy sem
     * @return bool True ha a belépett user admin | False ha nem
     */
    public function userIsAdmin(): bool {

        if (!is_null($this->getUser())) {
            return $this->getUser()->isAdmin();
        }
        return false;
    }



    /**
     * Visszaadja a user teljes nevét
     * @return string
     */
    public function getRealName():string{

        if (!is_null($this->getUser())) {
            return $this->getUser()->getFullName();
        }
        return '';
    }


    /**
     * Visszaadja a bejelentkezett user felhasználónevét
     * @return string
     */
    public function getUsername():string{

        if (!is_null($this->getUser())) {
            return $this->getUser()->getUsername();
        }
        return '';
    }
    /**
     * Visszaadja a bejelentkezett user email címét
     * @return string Ha nincs elérhető email cím, akkor empty string
     */
    public function getEmail(): string {

        if (!is_null($this->getUser())) {
            return $this->getUser()->getEmail();
        }
        return '';
    }


    public function getErrors(): array {

        return $this->errors;
    }


    public function getErrorsAsString($separator = '<br>'): string {

        return implode($separator, $this->errors);
    }

}
