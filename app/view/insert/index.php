<style>
    body{
        background-repeat: no-repeat;
        background-size: cover;
        background-image: url("/images/car5.png");
        color: black !important;
        background-position: center;
    }
</style>
<?php include '../app/view/_header.php' ?>

    <div class = "container container col-sm-3 col-sm">
        <form action = "insert/insert" method = "post">
            <div class = "card">
                <div class = "card-header">
                    <h5>Új autó felvétele</h5>
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
                        <label for = "manufacturer" class = "input-required">Manufacturer</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['manufacturer']) ? 'is-invalid' : 'is-valid'; ?>"
                               id = "manufacturer"
                               name = "manufacturer"
                               value = "<?= !empty($car) ? $car->getManufacturer() : ''; ?>"
                               minlength = "3"
                               >
                        <div class = "invalid-feedback"><?= $errors['manufacturer'] ?? ''; ?></div>
                    </div>

                    <div class = "form-group">
                        <label for = "type" class = "input-required">type</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['type']) ? 'is-invalid' : 'is-valid'; ?>"
                               id = "type"
                               name = "type"
                               value = "<?= !empty($car) ? $car->getType() : ''; ?>"
                               minlength = "3"
                              >
                        <div class = "invalid-feedback"><?= $errors['type'] ?? ''; ?></div>
                    </div>

                    <div class = "form-group">
                        <label for = "startOfProductionTime" class = "input-required">startOfProductionTime</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['startOfProductionTime']) ? 'is-invalid' : 'is-valid'; ?>"
                               id = "startOfProductionTime"
                               name = "startOfProductionTime"
                               value = "<?= !empty($car) ? $car->getStartOfProductionTime() : ''; ?>"
                               minlength = "3"
                               >
                        <div class = "invalid-feedback"><?= $errors['startOfProductionTime'] ?? ''; ?></div>
                    </div>

                    <div class = "form-group">
                        <label for = "endOfProductionTime" class = "input-required">endOfProductionTime</label>
                        <input type = "text"
                               class = "form-control <?= !empty($errors['endOfProductionTime']) ? 'is-invalid' : 'is-valid'; ?>"
                               id = "endOfProductionTime"
                               name = "endOfProductionTime"
                               value = "<?= !empty($car) ? $car->getEndOfProductionTime()() : ''; ?>"
                               minlength = "3"
                               >
                        <div class = "invalid-feedback"><?= $errors['endOfProductionTime'] ?? ''; ?></div>
                    </div>
                </div>
                <div class = "card-footer ">
                    <div class = "row ">
                        <button type = "submit" class = "btn btn-outline-primary ml-auto text-center" >Küldés</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

<?php include '../app/view/_footer.php'; ?>