<?php

use app\model\car\Car;
use app\model\user\Authenticator;

include '../app/view/_header.php';

/** @var Car[] $cars */
/** @var bool $userIsAdmin True, ha a belépett tag admin */
/** @var bool $isLoggedInUser True, ha van belépett user */
/** @var Authenticator $userId */
/** @var array[] $allCarType */

?>

<div class = "table-responsive">
    <table class = "table table-striped table-bordered text-center">
        <thead class = "thead-dark">
        <tr>
            <th class = "text-wrap align-middle">ID</th>
            <th class = "text-wrap align-middle">Típus</th>
            <th class = "text-wrap align-middle">Szín</th>
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
                    <td class = "text-wrap align-middle" data-id = "<?= $car->getType() ?>">
                        <?= $car->getType() ?>
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
                            <button type = "button" data-id = "<?= $car->getId() ?>" class = "btn btn-info get-car-modal edit-car" data-toggle = "modal" data-target = "#exampleModal"><a class = "nav-link"><i class = "fa fa-edit "
                                                                                                                                                                                                                style = "color:white"></i></a>
                            </button>
                            <button type = "button" data-id = "<?= $car->getId() ?>" class = "btn btn-danger delete-car">
                                <a class = "nav-link" href = "/"><i class = "fa fa-trash " style = "color:white"></i></a></button>
                        </td>
                    <?php endif; ?>


                    <?php if ($car->getIdOfOwner() == $userId && !$userIsAdmin): ?>
                        <td class = "text-wrap align-middle">
                            <?= $car->getCreatedAt() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $car->getUpdatedAt() ?>
                        </td>
                        <td style = "text-align: center">
                            <button type = "button" data-id = "<?= $car->getId() ?>" class = "btn btn-info get-car-modal edit-car" data-toggle = "modal" data-target = "#exampleModal"><a class = "nav-link"><i class = "fa fa-edit "
                                                                                                                                                                                                                style = "color:white"></i></a>
                            </button>
                            <button type = "button" class = "btn btn-danger delete-car"><a class = "nav-link" href = "/"><i class = "fa fa-trash " style = "color:white"></i></a></button>
                        </td>
                    <?php endif; ?>
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
                                <label for = "edit-color" class = "col-form-label">ID</label><br>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-car-id"
                                >

                                <div class = "form-group">
                                    <label for = "edit-color" class = "col-form-label input-required">Típus</label>
                                    <select class = "form-control" id = "edit-type">
                                        <option value = "null">Válasszon</option>
                                        <?php if (!empty($allCarType)): ?>
                                            <?php for ($i = 0; $i < count($allCarType); $i++): ?>
                                                <option value = "<?php echo $allCarType[$i]['type'] ?>"><?= $allCarType[$i]['type'] ?></option>
                                            <?php endfor; ?>
                                        <?php endif ?>
                                    </select>
                                </div>


                                <label for = "edit-color" class = "col-form-label">Szín</label><br>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-color"
                                >
                                <label for = "edit-color" class = "col-form-label">Megtett KM</label><br>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-kilometers-traveled"
                                >
                                <label for = "edit-color" class = "col-form-label">Gyártás éve</label><br>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-year-of-manufacture"

                                >
                                <label for = "edit-color" class = "col-form-label">Üzemanyag típusa</label><br>
                                <select class = "form-control" name = "cars" id = "edit-type-of-fuel">
                                    <option value = "0">benzin</option>
                                    <option value = "1">dízel</option>
                                </select>

                                <label for = "edit-color" class = "col-form-label">Állapot</label><br>
                                <select class = "form-control" name = "cars" id = "edit-car-condition">
                                    <option value = "0">leharcolt</option>
                                    <option value = "1">megkímélt</option>
                                    <option value = "2">felújított</option>
                                </select>

                        </form>
                    </div>
                    <div class = "modal-footer">
                        <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Mégse</button>
                        <button type = "button" class = "btn btn-primary" id = "save-edited-data2">Mentés</button>
                    </div>
                </div>
            </div>
        </div>


        </tbody>
    </table>
</div>

<script src = "/public/assets/js/pages/cars/index.js" type = "module"></script>
<?php include '../app/view/_footer.php'; ?>
