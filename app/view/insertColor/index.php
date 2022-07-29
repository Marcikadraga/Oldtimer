<?php

include '../app/view/_header.php' ;

?>


<?php include '../app/view/_header.php' ?>

 <div class = "container container col-sm-3 col-sm">
        <form action = "/CarController/insertColor" method = "post">
            <div class = "card">
                <div class = "card-header">
                    <h5>Új szín felvétele</h5>
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
                        <label for = "manufacturer" class = "input-required">Szín neve</label>
                        <input type = "text"
                               class = "form-control <?= !isset($errors) ? '' :(!empty($errors['name_of_color']) ? 'is-invalid' : 'is-valid'); ?>"
                               id = "manufacturer"
                               name = "manufacturer"
                               value = "<?= !empty($car) ? $car->getManufacturer() : ''; ?>"
                               minlength = "3"
                               >

                        <label for = "rgb" class = "input-required">RGB</label>
                        <input type = "text"
                               class = "form-control <?= !isset($errors) ? '' :(!empty($errors['rgb']) ? 'is-invalid' : 'is-valid'); ?>"
                               id = "rgb"
                               name = "rgb"
                               value = "<?= !empty($car) ? $car->rgb() : ''; ?>"
                               minlength = "3"
                        >
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


<?php
include '../app/view/_footer.php';
?>
