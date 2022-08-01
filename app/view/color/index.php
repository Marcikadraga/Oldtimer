<?php

use app\model\color\Color;

/** @var Color[] $colors */

//var_dump(count($colors));
//die();

include '../app/view/_header.php';
?>


<div class = "table-responsive">
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
                        <div style = "width: 50%;height: 50px;background-color: <?= $color->getNameOfColor() ?>"></div>
                    </td>
                    <td>
                        <?= $color->getCreatedAt() ?>
                    </td>
                    <td>
                        <?= $color->getUpdatedAt() ?>
                    </td>
                    <td>
                        <button type = "button" data-id = "<?= $color->getId() ?>" class = "btn btn-info get-car-modal edit-car" data-toggle = "modal" data-target = "#exampleModal"><a class = "nav-link"><i class = "fa fa-edit "
                                                                                                                                                                                                              style = "color:white"></i></a>
                        </button>
                        <button type = "button" data-id = "<?= $color->getId() ?>" class = "btn btn-danger delete-color"><a class = "nav-link"><i class = "fa fa-trash " style = "color:white"></i></a></button>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>
        </tbody>
    </table>
</div>





<?= addReference("assets/js/pages/colors/index.js", true) ?>

<!--<script src = "/assets/js/pages/colors/index.js" type = "module"></script>-->

<?php
include '../app/view/_footer.php';
?>
