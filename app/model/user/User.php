<?php

namespace app\model\user;

use DateTime;
use Exception;

class User {

    private $id                    = 0;
    private $username              = '';
    private $password_hash         = '';
    private $email                 = '';
    private $first_name            = '';
    private $middle_name           = '';
    private $last_name             = '';
    private $birth_date            = '';
    private $phoneNumber           = '';
    private $webpage               = '';
    private $zip_code              = '';
    private $city                  = '';
    private $district              = '';
    private $more_address          = '';
    private $role                  = '';
    private $created_at            = '';
    private $updated_at            = '';
    private $deleted_at            = '';
    private $last_login_at         = '';
    private $failed_login_counter  = '';
    private $is_banned             = '';
    private $lastPasswordChange_at = '';




    /** @var string Y-m-d H:i:s string */
    private         $banned_at = '';
    protected array $errors    = [];
    private const ROLES = ['admin', 'guest'];

    // Jelszó erősség karakterkészlete és követleményei
    private const LOWERCASE     = 'aábcdeéfghiíjklmnoóöőpqrstuúüűvwxyzäß';
    private const UPPERCASE     = 'AÁBCDEFGHIÍJKLMNOÓÖŐPQRSTUÚÜŰVWXYZÄ';
    private const MIN_LENGTH    = 8;          // jelszó minimális hossza
    private const MIN_LC        = 1;          // kisbetűk minimális száma
    private const MIN_UC        = 1;          // nagybetűk minimális száma
    private const MIN_DIGIT     = 1;          // számok minimális mennyisége
    private const LIMIT         = '-5 minutes'; // büntetés időtartama
    private const LOGIN_CHANCES = 5;         // belépésnél rontási lehetőségek


    public function __construct(?array $data = null) {

        $this->fill($data);
    }


    public function fill(?array $data = null): void {

        if (!is_null($data)) {
            foreach ($this as $key => $value) {
                if (array_key_exists($key, $data)) {
                    $this->{$key} = $data[$key];
                }
            }
        }
    }


    /**
     * Annak vizsgálata, hogy az user admin-e vagy sem
     * @return bool True ha admin | False ha nem
     */
    public function isAdmin(): bool {

        return $this->role === 'admin';
    }


    /**
     * Annak vizsgálata, hogy a jelszó elég erős-e vagy sem
     * @param string $password
     * @return bool True ha a jelszó elég erős | False ha nem
     * A hiba okát a belső errors tömb tartalmazza
     */
    public function isPasswordStrongTest($password): bool {

        $this->errors = [];

        $countLc = 0; // kisbetűk száma a jelszóban
        $countUc = 0; // nagybetűk száma a jelszóban
        $countDigit = 0; // számjegyek száma a jelszóban

        $strlen = mb_strlen($password);
        if ($strlen < self::MIN_LENGTH) {
            $this->errors['min_length'] = 'A jelszó minimális hossza ' . self::MIN_LENGTH . ' karakter legyen.';
        }

        for ($i = 0; $i < $strlen; $i++) {
            if (mb_strpos(self::LOWERCASE, $password[$i]) !== false) {
                $countLc++;
            }
            if (mb_strpos(self::UPPERCASE, $password[$i]) !== false) {
                $countUc++;
            }
            if (is_numeric($password[$i]) !== false) {
                $countDigit++;
            }
        }

        if ($countLc < self::MIN_LC) {
            $this->errors['min_lc'] = 'A jelszó tartalmazzon legalább ' . self::MIN_LC . ' db kisbetűt.';
        }
        if ($countUc < self::MIN_UC) {
            $this->errors['min_uc'] = 'A jelszó tartalmazzon legalább ' . self::MIN_UC . ' db nagybetűt.';
        }
        if ($countDigit < self::MIN_DIGIT) {
            $this->errors['min_digit'] = 'A jelszó tartalmazzon legalább ' . self::MIN_DIGIT . ' db számjegyet.';
        }

        return empty($this->errors);
    }


    /**
     * Jelszó és megerősítő jelszó azonosságának tesztelése
     * [Két string binary safe, case sensitive összehasonlítása]
     * @param string $string_1
     * @param string $string_2
     * @return bool True, ha a két string egyezik | False ha nem
     */
    public function isEquals(string $string_1, string $string_2): bool {

        return strcmp($string_1, $string_2) === 0;
    }


    public function getFields(): array {

        return [
            'id',
            'username',
            'password_hash',
            'email',
            'first_name',
            'middle_name',
            'last_name',
            'birth_date',
            'phoneNumber',
            'webpage',
            'zip_code',
            'city',
            'district',
            'more_address',
            'role',
            'updated_at',
            'deleted_at',
            'created_at',
            'last_login_at',
            'failed_login_counter',
            'is_banned',
            'banned_at',
        ];
    }


    /**
     * Visszaadja a user teljes nevét
     * @return string
     */
    public function getFullName(): string {

        if (empty($this->middle_name)) {
            return $this->first_name . ' ' . $this->last_name;
        } else {
            return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
        }
    }


    /**
     * Visszaadja a user teljes címét
     * @return string
     */
    public function getFullAddress(): string {

        if (empty($this->district)) {
            return $this->zip_code . ', ' . $this->city . ' ' . $this->more_address;
        } else {
            return $this->zip_code . ', ' . $this->city . ' (' . $this->district . ' kerület) ' . $this->more_address;
        }
    }


    /**
     * Jelszó hashelése - az adatbázis ezt a formát tárolja
     * @param string $password Az eredeti jelszó
     */
    public function setPasswordHash(string $password): void {

        $this->password_hash = password_hash($password, PASSWORD_BCRYPT);
        if (empty($this->password_hash)) {
            die('A jelszó titkosítása során váratlan hiba lépett fel.');
        }
    }


    /**
     * Példány jelszavának tesztelése
     * @param string $password A bejelentkezéskor használt jelszó
     * @return bool True ha a jelszó megfelelő | False ha nem
     */
    public function passwordVerify(string $password): bool {

        //Ha nincs jelszó, nem tesztelünk
        if (empty($password)) {
            return false;
        }

        return password_verify($password, $this->getPasswordHash());
    }


    /**
     * @throws Exception
     */
    public function isBanned(): bool {

        if ($this->is_banned == 0) {
            return false;
        } else {
            return true;
        }

    }


    public function increaseFailedLoginCounter() {

        if ($this->failed_login_counter < 5) {
            $this->failed_login_counter++;
        }
    }


    public function showHowManyChancesLeftForTheUser() {

        return self::LOGIN_CHANCES - $this->getFailedLoginCounter();
    }


    public function isEndOfBan() {

        return date("Y-m-d H:i:s", strtotime($this->getBannedAt() . ' + 5 mins')) < date("Y-m-d H:i:s");

    }


    public function deleteUserBanStatus() {

        if ($this->isEndOfBan()) {

            $this->setBannedAt(null);
            $this->setFailedLoginCounter(0);
            $this->setIsBanned(0);

        }
    }


    /**
     * Módosítja az entitást egy hibás bejelentkezés után
     * @return void
     */
    public function failAttempt(): void {

        $this->increaseFailedLoginCounter();

        if ($this->failed_login_counter > 4) {
            $this->setBannedAt(date("Y-m-d H:i:s"));
            $this->setIsBanned(1);
        }
    }


    public function checkIsValidInsert(): bool {

        $this->errors = [];

        if (mb_strlen($this->username) < 3) {
            $this->errors['username'] = 'A felhasználónév minimum 3 karakter legyen.';
        }
        if (empty($this->password_hash)) {
            // TODO trigger_error (?)
            $this->errors['password_hash'] = 'A jelszó hash hiányzik az user entitásból.';
        }
        if (empty($this->first_name)) {
            $this->errors['first_name'] = 'A keresztnév hiányzik.';
        }
        if (empty($this->last_name)) {
            $this->errors['last_name'] = 'A vezetéknév hiányzik.';
        }
        if (empty($this->zip_code)) {
            $this->errors['zip_code'] = 'A irányítószám hiányzik.';
        }
        if (empty($this->city)) {
            $this->errors['city'] = 'A város hiányzik';
        }
        if (mb_strtolower($this->city) == 'budapest' && empty($this->district)) {
            $this->errors['district'] = 'A kerület hiányzik';
        }
        if (empty($this->more_address)) {
            $this->errors['more_address'] = 'A teljes cím hiányzik';
        }
        if (empty($this->role)) {
            $this->errors['role'] = 'A "role" hiányzik';
        } elseif (!in_array($this->role, self::ROLES)) {
            $this->errors['role'] = 'A szerep nem megfelelő.';
        }

        helper('date');
        if (empty($this->birth_date)) {
            $this->errors['birth_date'] = 'A születési dátum hiányzik.';
        } elseif (!isValidDateFormat($this->birth_date, 'Y-m-d')) {
            $this->errors['birth_date'] = 'A születési dátum formátuma hibás, a várt formátum: éééé-hh-nn.';
        } elseif (!compareDateString($this->birth_date, '-150 year')) {
            $this->errors['birth_date'] = 'A születési dátum nem lehet 150 évnél korábbi.';
        } elseif (!compareDateString('now', $this->birth_date)) {
            $this->errors['birth_date'] = 'A születési dátum nem lehet nagyobb, mint az akutális dátum.';
        }

        //Weboldal validálása
        if (!empty($this->webpage) && filter_var($this->webpage, FILTER_VALIDATE_URL) === false) {
            /**
             * valid url-hez kell a https.
             * @link https://stackhowto.com/how-to-check-if-a-url-is-valid-in-php/
             */
            $this->errors['webpage'] = 'A weboldal címe nem megfelelő.' . $this->webpage;
        }

        return empty($this->errors);
    }


    public function checkIsValidUpdate(): bool {

        $this->errors = [];

        $this->checkIsValidInsert();

        if (empty($this->id)) {
            $this->errors['id'] = 'Hiba! Az entitás id-ja üres.';
        }

        return empty($this->errors);
    }


    public function isPasswordMatch($inputPassword, $hashedPassword): bool {

        if (password_verify($inputPassword, $hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }


    public function checkIsValidSave(): bool {

        if (empty($this->id)) {
            return $this->checkIsValidInsert();
        } else {
            return $this->checkIsValidUpdate();
        }
    }


    public function getErrors(): array {

        return $this->errors;
    }


    public function getErrorsAsString($separator = '<br>'): string {

        return implode($separator, $this->errors);
    }


    /**
     * @return int
     */
    public function getId(): int {

        return $this->id;
    }


    /**
     * @return string
     */
    public function getUsername(): string {

        return $this->username;
    }


    /**
     * @return string
     */
    public function getPasswordHash(): string {

        return $this->password_hash;
    }


    /**
     * @return string
     */
    public function getEmail(): string {

        return $this->email;
    }


    /**
     * @return string
     */
    public function getFirstName(): string {

        return $this->first_name;
    }


    /**
     * @return string
     */
    public function getMiddleName(): string {

        return $this->middle_name;
    }


    /**
     * @return string
     */
    public function getLastName(): string {

        return $this->last_name;
    }


    /**
     * @return string
     */
    public function getBirthDate(): string {

        return $this->birth_date;
    }


    /**
     * @return string
     */
    public function getPhoneNumber(): string {

        return $this->phoneNumber;
    }


    /**
     * @return string
     */
    public function getWebpage(): string {

        return $this->webpage;
    }


    /**
     * @return string
     */
    public function getZipCode(): string {

        return $this->zip_code;
    }


    /**
     * @return string
     */
    public function getCity(): string {

        return $this->city;
    }


    /**
     * @return string
     */
    public function getDistrict(): string {

        return $this->district;
    }


    /**
     * @return string
     */
    public function getMoreAddress(): string {

        return $this->more_address;
    }


    /**
     * @return string
     */
    public function getRole(): string {

        return $this->role;
    }


    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string {

        return $this->created_at;
    }


    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string {

        return $this->updated_at;
    }


    /**
     * @return string|null
     */
    public function getDeletedAt(): ?string {

        return $this->deleted_at;
    }


    /**
     * @return string|null
     */
    public function getLastLoginAt(): ?string {

        return $this->last_login_at;
    }


    /**
     * @return string
     */
    public function getFailedLoginCounter(): string {

        return $this->failed_login_counter;
    }


    /**
     * @return string|null
     */
    public function getBannedAt(): ?string {

        return $this->banned_at;
    }


    /**
     * @return string
     */
    public function getIsBanned(): string {

        return $this->is_banned;
    }


    /**
     * @param int $id
     */
    public function setId(int $id): void {

        $this->id = $id;
    }


    /**
     * @param string $username
     */
    public function setUsername(string $username): void {

        $this->username = $username;
    }


    /**
     * @param string $email
     */
    public function setEmail(string $email): void {

        $this->email = $email;
    }


    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void {

        $this->first_name = $first_name;
    }


    /**
     * @param string $middle_name
     */
    public function setMiddleName(string $middle_name): void {

        $this->middle_name = $middle_name;
    }


    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void {

        $this->last_name = $last_name;
    }


    /**
     * @param string $birth_date
     */
    public function setBirthDate(string $birth_date): void {

        $this->birth_date = $birth_date;
    }


    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void {

        $this->phoneNumber = $phoneNumber;
    }


    /**
     * @param string $webpage
     */
    public function setWebpage(string $webpage): void {

        $this->webpage = $webpage;
    }


    /**
     * @param string $zip_code
     */
    public function setZipCode(string $zip_code): void {

        $this->zip_code = $zip_code;
    }


    /**
     * @param string $city
     */
    public function setCity(string $city): void {

        $this->city = $city;
    }


    /**
     * @param string $district
     */
    public function setDistrict(string $district): void {

        $this->district = $district;
    }


    /**
     * @param string $more_address
     */
    public function setMoreAddress(string $more_address): void {

        $this->more_address = $more_address;
    }


    /**
     * @param string $role
     */
    public function setRole(string $role): void {

        $this->role = $role;
    }


    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void {

        $this->created_at = $created_at;
    }


    /**
     * @param string $last_login_at
     */
    public function setLastLoginAt(string $last_login_at): void {

        $this->last_login_at = $last_login_at;
    }


    /**
     * @param string $failed_login_counter
     */
    public function setFailedLoginCounter(string $failed_login_counter): void {

        $this->failed_login_counter = $failed_login_counter;
    }


    /**
     * @param string|null $banned_at
     */
    public function setBannedAt(?string $banned_at): void {

        $this->banned_at = $banned_at;
    }


    /**
     * @param string $is_banned
     */
    public function setIsBanned(string $is_banned): void {

        $this->is_banned = $is_banned;
    }

    /**
     * @return string
     */
    public function getLastPasswordChangeAt(): string {

        return $this->lastPasswordChange_at;
    }


    /**
     * @param string $lastPasswordChange_at
     */
    public function setLastPasswordChangeAt(string $lastPasswordChange_at): void {

        $this->lastPasswordChange_at = $lastPasswordChange_at;
    }

}
