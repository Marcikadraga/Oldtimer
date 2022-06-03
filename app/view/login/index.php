<style>
    body{
        background-repeat: no-repeat;
        background-size: cover;
        background-image: url("/images/car4.png");
        color: black !important;
        background-position: center;
    }
</style>
<?php
include '../app/view/_header.php';

/** @var string $invalidAuthenticator */
?>

<div class = "container col-sm-3 col-sm">
    <form action = "/login/signin" method = "post">
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
                           class = "form-control <?= !empty($errors['username']) ? 'is-invalid' : 'is-valid'; ?>"
                           id = "username"
                           name = "username"
                           value = "<?= !empty($user) ? $user->getUsername() : ''; ?>"
                           minlength = "3"
                           required>
                    <div class = "invalid-feedback"><?= $errors['username'] ?? ''; ?></div>
                </div>
                <div class = "form-row">
                    <div class = "col-sm-12 col-sm">
                        <label for = "password" class = "input-required">Jelszó</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['password']) ? 'is-invalid' : 'is-valid'; ?>"
                               name = "password"
                               required>
                        <div class = "invalid-feedback"><?= $errors['password'] ?? ''; ?></div>
                    </div>

                </div>
            </div>
            <div class = "card-footer">
                <div class = "row">
                    <button type = "submit" class = "btn btn-outline-primary ml-auto ">Küldés</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php include '../app/view/_footer.php'; ?>
