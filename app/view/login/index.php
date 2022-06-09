<style>
    body {
        background-repeat: no-repeat;
        background-size: cover;
        background-image: url("/images/car4.png");
        color: black !important;
        background-position: center;
    }
</style>
<?php
include '../app/view/_header.php';

/** @var array $errors A validációs hibák tömbje, kulcsa az inputok name értéke */
/** @var string $errorMsg A hiba szövege */
/** @var string $successMsg A sikeres mentés eredménye */
/** @var User $user A hibás regisztrációs adatokat tartalmazó usert */

/** @var string $invalidAuthenticator */
?>

<div class = "container col-sm-3 col-sm">
    <form action = "/login/signin" method = "post" id = "login-form">
        <div class = "card">
            <div class = "card-header">
                <h5>Bejelentkezés</h5>
            </div>
            <div class = "card-body">
                <?php if (!empty($invalidAuthenticator)): ?>
                    <div class = "alert alert-danger">
                        <p class = "m-0"><?= $invalidAuthenticator ?></p>
                    </div>
                <?php endif; ?>
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
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['username'])); ?>"
                           id = "username"
                           name = "username"

                           minlength = "3"
                           required>
                    <div class = "invalid-feedback"><?= $errors['username'] ?? ''; ?></div>
                </div>
                <div class = "form-row">
                    <div class = "col-sm-12 col-sm">
                        <label for = "password" class = "input-required">Jelszó</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['password']) ? 'is-invalid' : ''; ?>"
                               id = "password"
                               name = "password"
                               required>
                        <div class = "invalid-feedback"><?= $errors['password'] ?? ''; ?></div>
                    </div>

                </div>
            </div>
            <div class = "card-footer">
                <div class = "row">
                    <button type = "submit" class = "btn btn-outline-primary ml-auto " id = "login-user-button">Küldés</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src = "/assets/js/pages/login/index.js" type = "module"></script>

<?php include '../app/view/_footer.php'; ?>
