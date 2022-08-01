<?php

use app\model\color\Color;

/** @var Color[] $colors */

include '../app/view/_header.php';
?>


    <table class = "table table-striped table-bordered text-center">
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
                        <button type = "button" data-id = "<?= $color->getId() ?>" class = "btn btn-info get-car-modal edit-color" data-toggle = "modal" data-target = "#exampleModal"><a class = "nav-link"><i class = "fa fa-edit "
                                                                                                                                                                                                              style = "color:white"></i></a>
                        </button>
                        <button type = "button" data-id = "<?= $color->getId() ?>" class = "btn btn-danger delete-color"><a class = "nav-link"><i class = "fa fa-trash " style = "color:white"></i></a></button>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>


        <div class = "modal fade" id = "exampleModal" tabindex = "-1" aria-labelledby = "exampleModalLabel" aria-hidden = "true">
            <div class = "modal-dialog">
                <div class = "modal-content">
                    <div class = "modal-header">
                        <h5 class = "modal-title" id = "exampleModalLabel">New message</h5>
                        <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                            <span aria-hidden = "true">&times;</span>
                        </button>
                    </div>
                    <div class = "modal-body">
                        <form method = "POST">
                            <div class = "form-group">
                                <label for = "edit-color-id" class = "col-form-label">ID</label><br>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-color-id"
                                >
                            </div>
                            <div class = "form-group">
                                <label for = "edit-name-of-color" class = "col-form-label">Gyártó</label><br>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-name-of-color"
                                >
                            </div>
                            <div class = "form-group">
                                <label for = "edit-rgb" class = "col-form-label">Típus</label><br>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-rgb"
                                >
                            </div>
                        </form>
                    </div>
                    <div class = "modal-footer">
                        <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Mégse</button>
                        <button type = "button" class = "btn btn-primary" id = "save-edited-data">Mentés</button>
                    </div>
                </div>
            </div>

        </tbody>
    </table>



<?= addReference("assets/js/pages/colors/index.js", true) ?>

<!--<script src = "/assets/js/pages/colors/index.js" type = "module"></script>-->

<?php
//include '../app/view/_footer.php';
?>
