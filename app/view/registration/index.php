<style>
    body{
        background-repeat: no-repeat;
        background-size: cover;
        background-image: url("/images/car5.png");
        color: black !important;
        background-position: center;
    }
</style>
<?php

use app\model\user\User;

include '../app/view/_header.php';

/** @var array $errors A validációs hibák tömbje, kulcsa az inputok name értéke */
/** @var string $errorMsg A hiba szövege */
/** @var string $successMsg A sikeres mentés eredménye */
/** @var User $user A hibás regisztrációs adatokat tartalmazó usert */

?>

<div class = "container">
    <form action = "/Login/insert" method = "post">
        <div class = "card">
            <div class = "card-header">
                <h5>Regisztráció</h5>
                <p>Kérem töltse ki az űrlapot!</p>
            </div>
            <div class = "card-body">
                <?php if (!empty($errorMsg)): ?>
                    <div class = "alert alert-danger">
                        <p class = "m-0"><?= $errorMsg ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($successMsg)): ?>
                    <div class = "alert alert-success">
                        <p class = "m-0"><?= $successMsg; ?></p>
                    </div>
                <?php endif; ?>
                <div class = "form-group">
                    <label for = "username" class = "input-required">Username</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['username']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "username"
                           name = "username"
                           value = "<?= !empty($user) ? $user->getUsername() : ''; ?>"
                           minlength = "3"
                           required>
                    <div class = "invalid-feedback"><?= $errors['username'] ?? ''; ?></div>
                </div>
                <div class = "form-row">
                    <div class = "col-sm-12 col-lg">
                        <label for = "password-1" class = "input-required">Jelszó</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['password1']) ? 'is-invalid' : ''; ?>"
                               id = "password-1"
                               name = "password1"
                               required>
                        <div class = "invalid-feedback"><?= $errors['password1'] ?? ''; ?></div>
                    </div>
                    <div class = "col-sm-12 col-lg">
                        <label for = "password-2" class = "input-required">Jelszó ismét</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['password2']) ? 'is-invalid' : ''; ?>"
                               id = "password-2"
                               name = "password2"
                               required>
                        <div class = "invalid-feedback"><?= $errors['password2'] ?? ''; ?></div>
                    </div>
                </div>
                <div class = "form-group">
                    <label for = "email" class = "input-required">Email cím</label>
                    <input type = "email"
                           class = "form-control <?= !empty($errors['email']) ? 'is-invalid' : ''; ?>"
                           id = "email"
                           name = "email"
                           value = "<?= !empty($user) ? $user->getEmail() : ''; ?>"
                           required>
                    <div class = "invalid-feedback"><?= $errors['email'] ?? ''; ?></div>
                </div>
                <div class = "form-row">
                    <div class = "col-sm-12 col-lg">
                        <label for = "first-name" class = "input-required">Keresztnév</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['first_name']) ? 'is-invalid' : ''; ?>"
                               id = "first-name"
                               name = "first_name"
                               value = "<?= !empty($user) ? $user->getFirstName() : ''; ?>"
                               required>
                        <div class = "invalid-feedback"><?= $errors['first_name'] ?? ''; ?></div>
                    </div>
                    <div class = "col-sm-12 col-lg">
                        <label for = "middle-name">Középső név</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['middle_name']) ? 'is-invalid' : ''; ?>"
                               id = "middle-name"
                               name = "middle_name"
                               value = "<?= !empty($user) ? $user->getMiddleName() : ''; ?>">
                        <div class = "invalid-feedback"><?= $errors['middle_name'] ?? ''; ?></div>
                    </div>
                    <div class = "col-sm-12 col-lg">
                        <label for = "last-name" class = "input-required">Vezetéknév</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['last_name']) ? 'is-invalid' : ''; ?>"
                               id = "last-name"
                               name = "last_name"
                               value = "<?= !empty($user) ? $user->getLastName() : ''; ?>"
                               required>
                        <div class = "invalid-feedback"><?= $errors['last_name'] ?? ''; ?></div>
                    </div>
                    <div class = "col-sm-12 col-lg">
                        <label for = 'phoneNumber' class = "input-required">teló</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['phoneNumber']) ? 'is-invalid' : ''; ?>"
                               id = "phoneNumber"
                               name = "phoneNumber"
                               value = "<?= !empty($user) ? $user->getPhoneNumber() : ''; ?>"
                               required>
                        <div class = "invalid-feedback"><?= $errors['phoneNumber'] ?? ''; ?></div>
                    </div>
                    <div class = "col-sm-12 col-lg">
                        <label for = "webpage" class = "input-required">weboldal</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['webpage']) ? 'is-invalid' : ''; ?>"
                               id = "webpage"
                               name = "webpage"
                               value = "<?= !empty($user) ? $user->getWebpage() : ''; ?>"
                               >
                        <div class = "invalid-feedback"><?= $errors['webpage'] ?? ''; ?></div>
                    </div>
                    <div class = "col-sm-12 col-lg">
                        <label for = "birth-date" class = "input-required">Születési idő</label>
                        <input type = "date"
                               class = "form-control <?= !empty($errors['birth_date']) ? 'is-invalid' : ''; ?>"
                               id = "birth-date"
                               name = "birth_date"
                               value = "<?= !empty($user) ? $user->getBirthDate() : ''; ?>"
                               required>
                        <div class = "invalid-feedback"><?= $errors['birth_date'] ?? ''; ?></div>
                    </div>
                </div>
                <div class = "form-row">
                    <div class = "col-sm-12 col-lg-2">
                        <label for = "zip-code" class = "input-required">Irányítószám</label>
                        <input type = "number"
                               class = "form-control <?= !empty($errors['zip_code']) ? 'is-invalid' : ''; ?>"
                               id = "zip-code"
                               name = "zip_code"
                               min = "1000"
                               max = "9999"
                               step = "1"
                               value = "<?= !empty($user) ? $user->getZipCode() : ''; ?>"
                               required>
                        <div class = "invalid-feedback"><?= $errors['zip_code'] ?? ''; ?></div>
                    </div>
                    <div class = "col-sm-12 col-lg-auto">
                        <label for = "city" class = "input-required">Város</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['city']) ? 'is-invalid' : ''; ?>"
                               id = "city"
                               name = "city"
                               value = "<?= !empty($user) ? $user->getCity() : ''; ?>"
                               required>
                        <div class = "invalid-feedback"><?= $errors['city'] ?? ''; ?></div>
                    </div>
                    <div class = "col-sm-12 col-lg">
                        <label for = "district">Kerület</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['district']) ? 'is-invalid' : ''; ?>"
                               id = "district"
                               name = "district"
                               value = "<?= !empty($user) ? $user->getDistrict() : ''; ?>">
                        <div class = "invalid-feedback"><?= $errors['district'] ?? ''; ?></div>
                    </div>
                    <div class = "col-sm-12">
                        <label for = "more_address">Utca házszám</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['more_address']) ? 'is-invalid' : ''; ?>"
                               id = "more_address"
                               name = "more_address"
                               value = "<?= !empty($user) ? $user->getMoreAddress() : ''; ?>"
                               required>
                        <div class = "invalid-feedback"><?= $errors['more_address'] ?? ''; ?></div>
                    </div>
                </div>
            </div>
            <div class = "card-footer">
                <div class = "row">
                    <button type = "submit" class = "btn btn-outline-primary ml-auto">Küldés</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include '../app/view/_footer.php'; ?>
