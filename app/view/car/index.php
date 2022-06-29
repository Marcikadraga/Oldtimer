<?php

use app\model\car\Car;

include '../app/view/_header.php';

/** @var Car[] $cars */

?>

    <div class = "table-responsive">
        <table class = "table table-striped table-bordered text-center">
            <thead class = "thead-dark">
            <tr>
                <th class = "text-wrap align-middle">ID</th>
                <th class = "text-wrap align-middle">Color</th>
                <th class = "text-wrap align-middle">Megtett KM</th>
                <th class = "text-wrap align-middle">Gyártás éve</th>
                <th class = "text-wrap align-middle">Üzemanyag típusa</th>
                <th class = "text-wrap align-middle">Állapota</th>

<!--                <th class = "text-wrap align-middle">Létrehozva</th>-->
<!--                <th class = "text-wrap align-middle">Frissítve</th>-->
<!--                <th class = "text-wrap align-middle">Törölve</th>-->


            </tr>
            </thead>
            <tbody>
            <?php if (empty($cars)): ?>
                <tr>
                    <td colspan = "11">Nincs adat</td>
                </tr>
            <?php else: ?>
                <?php foreach ($cars as $car): ?>
                    <tr>
                        <td class = "text-wrap align-middle">
                            <?= $car->getId() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $car->getColor() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $car->getKilometersTraveled() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $car->getYearOfManufacture() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $car->getTypeOfFuelValueOfIndex() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $car->getIndexOfCondition() ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
            </tbody>
        </table>
    </div>


<?php include '../app/view/_footer.php';
