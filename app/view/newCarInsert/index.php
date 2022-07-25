<style>
    body{
        background-repeat: no-repeat;
        background-size: cover;
        background-image: url("/images/car4.png");
        color: orange !important;
        background-position: center;
    }
</style>
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
                    <label for = "type" class = "input-required">Típus</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['manufacturer']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "type"
                           name = "type"
                           value = "<?= !empty($car) ? $car->getType() : ''; ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['type'] ?? ''; ?></div>
                </div>

                <div class = "form-group">
                    <label for = "color" class = "input-required">Szín</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['manufacturer']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "color"
                           name = "color"
                           value = "<?= (!empty($car) ? $car->getColor() : ''); ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['color'] ?? ''; ?></div>
                </div>

                <div class = "form-group">
                    <label for = "kilometers_traveled" class = "input-required">Megtett KM</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['kilometers_traveled']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "kilometers_traveled"
                           name = "kilometers_traveled"
                           value = "<?= !empty($car) ? $car->getKilometersTraveled() : ''; ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['kilometers_traveled'] ?? ''; ?></div>
                </div>

                <div class = "form-group">
                    <label for = "year_of_manufacture" class = "input-required">Gyártás éve</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['year_of_manufacture']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "year_of_manufacture"
                           name = "year_of_manufacture"
                           value = "<?= !empty($car) ? $car->getYearOfManufacture() : ''; ?>"
                           minlength = "3"
                    >
                    <div class = "invalid-feedback"><?= $errors['year_of_manufacture'] ?? ''; ?></div>
                </div>

                <label for = "edit-color" class = "col-form-label input-required"   >Üzemanyag típusa</label><br>
                <select class="form-control" name="type_of_fuel" id="type-of-fuel" >
                    <option name="type_of_fuel" value="null">válasszon</option>
                    <option name="type_of_fuel" value="0">benzin</option>
                    <option name="type_of_fuel" value="1">dízel</option>
                </select>
                <br>

                <div class = "form-group" >
                    <label for = "car_condition" class = "input-required">Autó állapota</label>
                    <select class="form-control" name="car_condition" id = "car_condition">
                        <option value="null">Válasszon</option>
                        <option value="0">leharcolt</option>
                        <option value="1">megkímélt</option>
                        <option value="2">felújított</option>
                    </select>
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