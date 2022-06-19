<?php

namespace app\model\user;

use app\core\logger\SystemLog;
use app\model\BaseModel;
use Exception;
use PDO;

class UserModel extends BaseModel {

    /**
     * Annak vizsgálata, hogy a keresett username létezik-e az adatbázisban vagy sem
     * @param string $username A keresett username
     * @return bool True, ha már létezik | False ha még nem létezik az adatbázisban
     */
    public function existUsername($username): bool {

        try {
            $query = 'SELECT * FROM users WHERE username=? AND deleted_at IS NULL LIMIT 1';
            $params = [$username];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return !empty($result);

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'select');
        }

        return false;
    }


    /**
     * Annak vizsgálata, hogy az email már létezik-e az adatbázisban
     * @param string $email A keresett email
     * @return bool True ha már létezik | False ha még nem létezik az adatbázisban
     */
    public function existEmail($email): bool {

        try {
            $query = 'SELECT * FROM users WHERE email=? AND deleted_at IS NULL LIMIT 1';
            $params = [$email];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return !empty($result);

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'select');
        }

        return false;
    }


    /**
     * Az username-hez tartozó user keresése az adatbázisban
     * @param string $username A keresett username
     * @return User|null A példányostott user entitás | ha nincs találat akkor null
     */
    public function getByUsername($username): ?User {

        try {
            $query = 'SELECT * FROM users WHERE username=? AND deleted_at IS NULL LIMIT 1';
            $params = [$username];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                return new User($result[0]);
            }

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'select');
        }

        return null;
    }


    /**
     * Az id-hoz tartozó user keresése az adatbázisban
     * @param int $id A keresett user id-ja
     * @return User|null A példányostott user entitás | ha nincs találat akkor null
     */
    public function getById($id): ?User {

        try {
            $query = 'SELECT * FROM users WHERE id=? AND deleted_at IS NULL LIMIT 1';
            $params = [$id];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                return new User($result[0]);
            }
        } catch (Exception $exception) {
            $this->errorHandling($exception, 'select');
        }

        return null;
    }


    /**
     * Az összes elérhető user példányosítása
     * @return User[]
     */
    public function getAll(): array {

        $result = [];

        try {
            $query = 'SELECT * FROM users WHERE deleted_at IS NULL';

            $statement = $this->pdo->prepare($query);
            $statement->execute();

            $res = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($res)) {
                foreach ($res as $row) {
                    $result[] = new User($row);
                }
            }

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'select');
        }

        return $result;
    }


    /**
     * Új user beszúrása az adatbázisba
     * @param User $user
     * @return int|null Az új sor auto increment id-ja
     */
    public function insert(User $user): ?int {

        try {
            $query = '
            INSERT INTO users (username, password_hash, email, first_name, middle_name, last_name, birth_date, phoneNumber, webpage, zip_code, city, district, more_address, role, created_at, failed_login_counter, is_banned) 
            VALUES (:username, :password_hash, :email, :first_name, :middle_name, :last_name, :birth_date, :phoneNumber, :webpage, :zip_code, :city, :district, :more_address, :role, :created_at, :failed_login_counter, :is_banned)';

            $params = [
                'username'             => $user->getUsername(),
                'password_hash'        => $user->getPasswordHash(),
                'email'                => $user->getEmail(),
                'first_name'           => $user->getFirstName(),
                'middle_name'          => $user->getMiddleName(),
                'last_name'            => $user->getLastName(),
                'birth_date'           => $user->getBirthDate(),
                'phoneNumber'          => $user->getPhoneNumber(),
                'webpage'              => $user->getWebpage(),
                'zip_code'             => $user->getZipCode(),
                'city'                 => $user->getCity(),
                'district'             => $user->getDistrict(),
                'more_address'         => $user->getMoreAddress(),
                'role'                 => $user->getRole(),
                'created_at'           => $user->getCreatedAt(),
                'failed_login_counter' => $user->getFailedLoginCounter(),
                'is_banned'            => $user->getIsBanned(),
            ];

            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return $this->pdo->lastInsertId();

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'insert');
        }

        return null;
    }


    /**
     * User adatainak frissítése az adatbázisban
     * @param User $user
     * @return bool True, ha sikeres | False ha nem sikerült
     */
    public function update(User $user): bool {

        try {
            $query = '
            UPDATE users
            SET username =:username,
                password_hash =:password_hash,
                email =:email,
                first_name =:first_name,
                middle_name =:middle_name,
                last_name =:last_name,
                birth_date =:birth_date,
                phoneNumber =:phoneNumber,
                webpage =:webpage,
                zip_code =:zip_code,
                city =:city,
                district =:district,
                more_address =:more_address,
                role =:role,
                created_at=:created_at,
                updated_at=:updated_at,
                deleted_at=:deleted_at,
                last_login_at=:last_login_at,
                failed_login_counter=:failed_login_counter,
                is_banned=:is_banned,
                banned_at=:banned_at
                
            WHERE id =:id';

            $params = [
                'id'                   => $user->getId(),
                'username'             => $user->getUsername(),
                'password_hash'        => $user->getPasswordHash(),
                'email'                => $user->getEmail(),
                'first_name'           => $user->getFirstName(),
                'middle_name'          => $user->getMiddleName(),
                'last_name'            => $user->getLastName(),
                'birth_date'           => $user->getBirthDate(),
                'phoneNumber'          => $user->getPhoneNumber(),
                'webpage'              => $user->getWebpage(),
                'zip_code'             => $user->getZipCode(),
                'city'                 => $user->getCity(),
                'district'             => $user->getDistrict(),
                'more_address'         => $user->getMoreAddress(),
                'role'                 => $user->getRole(),
                'created_at'           => $user->getCreatedAt(),
                'updated_at'           => $user->getUpdatedAt(),
                'deleted_at'           => $user->getDeletedAt(),
                'last_login_at'        => $user->getLastLoginAt(),
                'failed_login_counter' => $user->getFailedLoginCounter(),
                'is_banned'            => $user->getIsBanned(),
                'banned_at'            => $user->getBannedAt()
            ];

            $statement = $this->pdo->prepare($query);

            return $statement->execute($params);

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'update');
        }

        return false;
    }


    public function updatePassword(User $user): bool {

        try {
            $query = '
            UPDATE users
            SET password_hash =:password_hash
            WHERE id=:id';

            $params = [
                'id'            => $user->getId(),
                'password_hash' => $user->getPasswordHash(),
            ];
            $statement = $this->pdo->prepare($query);

            return $statement->execute($params);

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'update');
        }
        return false;
    }


    /**
     * @param $username
     * @return array|false|void
     * @deprecated Ez nem usert ad vissza, hanem csak egy array-t, ami nem objektumorientált programozás
     */
    public function getDataFromUser($username) {

        try {
            $query = 'SELECT * FROM users WHERE username=?';
            $params = [$username];
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }


    /**
     * User adatainak mentése az adatbázisba (egyszerűsítő funkció)
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool {

        if (empty($user->getId())) {
            return !empty($this->insert($user));
        } else {
            return $this->update($user);
        }
    }


    /**
     * User adatainak törlése az adatbázisból
     * @param string $user_id
     * @param bool $softDelete false esetén végleges törlés (default true)
     * @return bool
     */
    public function delete($user_id, $softDelete = true): bool {

        try {

            if ($softDelete === true) {
                //TODO ,soft micsoda?
                $query = 'UPDATE users SET deleted_at=:deleted_at WHERE id=:id';
                $params = [
                    'id'         => $user_id,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ];
            } else {
                $query = 'DELETE FROM users WHERE id=?';
                $params = [$user_id];
            }

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'delete');
        }

        return false;
    }


    public function updateChangedPasswordAt(User $user) {

        try {
            $query = '
            UPDATE users
            SET changed_password_at=:changed_password_at 
            WHERE id=:id';
            $params = [
                'id'                  => $user->getId(),
                'changed_password_at' => date('Y-m-d H:i:s'),
            ];

            $statement = $this->pdo->prepare($query);
            return $statement->execute($params);

        } catch (Exception $exception) {
            $this->errorHandling($exception, 'updateChangedPasswordAt');
        }

        return false;
    }


    /**
     * @param $userId
     * @return mixed
     * @throws Exception
     * @deprecated Ez nem usert hanem arrayt ad vissza, ami nem objektumorientált
     */
    public function getUserById($userId) {

        try {
            $query = 'SELECT * FROM users WHERE id=? AND deleted_at IS NULL LIMIT 1';
            $statement = $this->pdo->prepare($query);
            $statement->execute([$userId]);
            return $statement->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $exception) {
            $log = new SystemLog();
            $log->exceptionLog($exception);
            throw new Exception('Adatbázishiba.' . $exception->getMessage());
        }
    }

}
