<?php

use app\model\color\Color;

/** @var Color[] $colors */

include '../app/view/_header.php';
?>

<table class = "table">
    <thead class = "thead-dark">
    <tr>
        <th>ID</th>
        <th>Szín</th>
        <th>rgb</th>
        <th>Készült</th>
        <th>Frissítve</th>
        <th>Műveletek</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($colors)): ?>
        <tr>
            <td colspan = "11">Nincs adat</td>
        </tr>
    <?php else: ?>
        <?php foreach ($colors as $color): ?>
            <tr>
                <td class = "text-wrap align-middle">
                    <?= $color->getId() ?>
                </td>
                <td class = "text-wrap align-middle">
                    <?= $color->getNameOfColor() ?>
                </td>
                <td class = "text-wrap align-middle" style = "display: flex;align-items: center ">
                    <div style = "display:flex;align-items: center;justify-content: center; width: 50%;height: 50px;background-color: <?= $color->getNameOfColor() ?>>;"><?= $color->getRgb() ?></div>
                    <div style = "width: 50%;height: 50px;background-color: <?= $color->getRgb() ?>"></div>
                </td>
                <td>
                    <?= $color->getCreatedAt() ?>
                </td>
                <td>
                    <?= $color->getUpdatedAt() ?>
                </td>
                <td>
                    <button type = "button" data-id = "<?= $color->getId() ?>" class = "btn btn-info get-car-modal edit-color"><a class = "nav-link"><i class = "fa fa-edit " style = "color:white"></i></a>
                    </button>
                    <button type = "button" data-id = "<?= $color->getId() ?>" class = "btn btn-danger delete-color"><a class = "nav-link"><i class = "fa fa-trash " style = "color:white"></i></a></button>
                </td>
            </tr>
        <?php endforeach ?>
    <?php endif ?>
    </tbody>
</table>

<div class = "modal fade" id = "exampleModal" tabindex = "-1" aria-labelledby = "exampleModalLabel" aria-hidden = "true">
    <div class = "modal-dialog">
        <div class = "modal-content">
            <div class = "modal-header">
                <h5 class = "modal-title" id = "exampleModalLabel">Szín beállítása</h5>
                <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                    <span aria-hidden = "true">&times;</span>
                </button>
            </div>
            <div class = "modal-body">
                <form method = "POST">
                    <div style="display: none" class = "form-group">
                        <label for = "edit-color-id" class = "col-form-label">ID</label><br>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-color-id"
                        >
                    </div>
                    <div class = "form-group">
                        <label for = "edit-name-of-color" class = "col-form-label">Szín</label><br>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-name-of-color"
                        >
                    </div>
                    <div class = "form-group">
                        <label for = "edit-rgb" class = "col-form-label">Rgb</label><br>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-rgb"
                        >
                    </div>


                    <label for = "Range0" class = "form-label">RED</label>
                    <br>
                    <input type = "range" class = "form-range" min = "0" max = "255" id = "Range0" style = "width: 300px">
                    <br>
                    <label for = "Range1" class = "form-label">GREEN</label>
                    <br>
                    <input type = "range" class = "form-range" min = "0" max = "255" id = "Range1" style = "width: 300px">
                    <br>
                    <label for = "Range2" class = "form-label">BLUE</label>
                    <br>
                    <input type = "range" class = "form-range" min = "0" max = "255" id = "Range2" style = "width: 300px">

                    <div id = "resultColor" style = "width: 100px; height: 100px;border: 3px solid black">

                    </div>

                    <script>
                        let range0 = document.getElementById("Range0").value;
                        let range1 = document.getElementById("Range1").value;
                        let range2 = document.getElementById("Range2").value;
                        document.getElementById("resultColor").style.backgroundColor = "rgb(" + range0 + "," + range1 + "," + range2 + ")";

                    </script>


                </form>
            </div>
            <div class = "modal-footer">
                <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Mégse</button>
                <button type = "button" class = "btn btn-primary" id = "save-edited-data">Mentés</button>
            </div>
        </div>
    </div>
</div>


<?= addReference("assets/js/pages/colors/index.js", true) ?>
<?= addReference("assets/js/pages/colors/insertColor.js", true) ?>

<!--<script src = "/assets/js/pages/colors/index.js" type = "module"></script>-->

<?php
include '../app/view/_footer.php';
?>
