<?php

use app\model\car\Car;
use app\model\user\Authenticator;

include '../app/view/_header.php';

/** @var Car[] $cars */
/** @var bool $userIsAdmin True, ha a belépett tag admin */
/** @var bool $isLoggedInUser True, ha van belépett user */
/** @var Authenticator $userId  */


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
    <th class = "text-wrap align-middle">Tulajdonos</th>


<?php if ($isLoggedInUser): ?>

    <th class = "text-wrap align-middle">Létrehozva</th>
    <th class = "text-wrap align-middle">Frissítve</th>
    <th class = "text-wrap align-middle">Műveletek</th>

<?php endif; ?>


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
                <td class = "text-wrap align-middle" data-id = "<?= $car->getId() ?>">
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
                <td class = "text-wrap align-middle">
                    <?= $car->getNameOfOwnerById() ?>
                </td>


                <?php if ($userIsAdmin): ?>
                    <td class = "text-wrap align-middle">
                        <?= $car->getCreatedAt() ?>
                    </td>
                    <td class = "text-wrap align-middle">
                        <?= $car->getUpdatedAt() ?>
                    </td>
                    <td style = "text-align: center">
                        <button type = "button" data-id = "<?= $car->getId()?>"  class = "btn btn-info get-car-modal edit-car" data-toggle = "modal" data-target = "#exampleModal"><a class = "nav-link" ><i class="fa fa-edit "style="color:white"></i></a></button>
                        <button type = "button" data-id = "<?= $car->getId()?>"  class = "btn btn-danger delete-car">
                            <a class = "nav-link" href = "/"><i class="fa fa-trash " style="color:white"></i></a></button>
                    </td>
                <?php endif; ?>


                <?php if ($car->getIdOfOwner()==$userId && !$userIsAdmin): ?>
                    <td class = "text-wrap align-middle">
                        <?= $car->getCreatedAt() ?>
                    </td>
                    <td class = "text-wrap align-middle">
                        <?= $car->getUpdatedAt() ?>
                    </td>
                    <td style = "text-align: center">
                        <button type = "button"  data-id = "<?= $car->getId()?>"  class = "btn btn-info get-car-modal edit-car" data-toggle = "modal" data-target = "#exampleModal"><a class = "nav-link" ><i class="fa fa-edit "style="color:white"></i></a></button>
                        <button type = "button"   class = "btn btn-danger delete-car"><a class = "nav-link" href = "/"><i class="fa fa-trash " style="color:white"></i></a></button>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach ?>
    <?php endif ?>
    </tbody>
    </table>
    </div>

    <script src = "/public/assets/js/pages/cars/index.js" type = "module"></script>
    <?php include '../app/view/_footer.php';
