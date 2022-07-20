<?php include '../app/view/_header.php' ?>

<div class = "container container col-sm-3 col-sm">
    <form action = "/CarController/insert" method = "post">
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
                    <label for = "type" class = "input-required">Type</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['manufacturer']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "type"
                           name = "type"
                           value = "<?= !empty($car) ? $car->getType : ''; ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['type'] ?? ''; ?></div>
                </div>

                <div class = "form-group">
                    <label for = "color" class = "input-required">Color</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['manufacturer']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "color"
                           name = "color"
                           value = "<?= !empty($car) ? $car->getColor : ''; ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['color'] ?? ''; ?></div>
                </div>

                <div class = "form-group">
                    <label for = "kilometers_traveled" class = "input-required">kilometers_traveled</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['kilometers_traveled']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "kilometers_traveled"
                           name = "kilometers_traveled"
                           value = "<?= !empty($car) ? $car->getKilometersTraveled : ''; ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['kilometers_traveled'] ?? ''; ?></div>
                </div>

                <div class = "form-group">
                    <label for = "year_of_manufacture" class = "input-required">year_of_manufacture</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['year_of_manufacture']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "year_of_manufacture"
                           name = "year_of_manufacture"
                           value = "<?= !empty($car) ? $car->getYearOfManufacture : ''; ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['year_of_manufacture'] ?? ''; ?></div>
                </div>

                <div class = "form-group">
                    <label for = "type_of_fuel" class = "input-required">type_of_fuel</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['type_of_fuel']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "type_of_fuel"
                           name = "type_of_fuel"
                           value = "<?= !empty($car) ? $car->getTypeOfFuel : ''; ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['type_of_fuel'] ?? ''; ?></div>
                </div>

                <div class = "form-group">
                    <label for = "car_condition" class = "input-required">car_condition</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['car_condition']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "car_condition"
                           name = "car_condition"
                           value = "<?= !empty($car) ? $car->getCarCondition : ''; ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['car_condition'] ?? ''; ?></div>
                </div>

                <div class = "form-group">
                    <label for = "id_of_owner" class = "input-required">id_of_owner</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['car_condition']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "id_of_owner"
                           name = "id_of_ownervvv"
                           value = "<?= !empty($car) ? $car->getIdOfOwner : ''; ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['id_of_owner'] ?? ''; ?></div>
                </div>

                <div class = "card-footer ">
                    <div class = "row ">
                        <button type = "submit" class = "btn btn-outline-primary ml-auto text-center">Küldés</button>
                    </div>
                </div>
            </div>
    </form>
</div>

<?php include '../app/view/_footer.php'; ?>
