<?php

include '../app/view/_header.php';

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
                    <label for = "name_of_color" class = "input-required">Szín neve</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['name_of_color']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "name_of_color"
                           name = "name_of_color"
                           value = "<?= !empty($color) ? $color->getNameOfColor() : ''; ?>"
                    >
                    <label for = "Range0" class = "form-label">RED</label>
                    <br>
                    <input type = "range" class = "form-range" min = "0" max = "255" id = "Range0" onclick = "showColor()" style = "width: 300px">
                    <br>
                    <label for = "Range1" class = "form-label">GREEN</label>
                    <br>
                    <input type = "range" class = "form-range" min = "0" max = "255" id = "Range1" onclick = "showColor()" style = "width: 300px">
                    <br>
                    <label for = "Range2" class = "form-label">BLUE</label>
                    <br>
                    <input type = "range" class = "form-range" min = "0" max = "255" id = "Range2" onclick = "showColor()" style = "width: 300px">


                    <div id = "resultColor" style = "width: 100px; height: 100px;background-color: grey;border: 3px solid black">

                    </div>


                    <label for = result""></label>
                    <p id = "result"></p>


                    <script>


                        let range0 = document.getElementById("Range0");
                        let range1 = document.getElementById("Range1");
                        let range2 = document.getElementById("Range2");
                        let colorResult = document.getElementById("resultColor");


                        function showColor() {
                            document.getElementById("rgb").value = colorResult.style.backgroundColor = "rgb(" + range0.value + "," + range1.value + "," + range2.value + ")";
                            colorResult.style.backgroundColor = "rgb(" + range0.value + "," + range1.value + "," + range2.value + ")";
                        }


                    </script>

                    <label for = "rgb" class = "input-required">RGB</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['rgb']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "rgb"
                           name = "rgb"
                           value = "<?= !empty($color) ? $color->getRgb() : ''; ?>"

                    >
                </div>
            </div>
            <div class = "card-footer ">
                <div class = "row ">
                    <button type = "submit" class = "btn btn-outline-primary ml-auto text-center">Küldés</button>
                </div>
            </div>
        </div>
    </form>
</div>


<?php
include '../app/view/_footer.php';
?>
