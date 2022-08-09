<?php use app\model\carType\CarType;

include '../app/view/_header.php' ?>

<?php
/** @var Cartype[] $cartype */

?>


<table class = "table">
    <thead class = "thead-dark">
    <tr>
        <th>ID</th>
        <th>Gyártó</th>
        <th>Típus</th>
        <th>Státusz</th>
        <th>Gyártás kezdete</th>
        <th>Gyártás vége</th>
        <th>Feltöltve</th>
        <th>Frissítve</th>
        <th>Műveletek</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($cartypes)): ?>
        <tr>
            <td colspan = "11">Nincs adat</td>
        </tr>
    <?php else: ?>
        <?php foreach ($cartypes as $cartype): ?>
            <tr>
                <td class = "text-wrap align-middle">
                    <?= $cartype->getId() ?>
                </td>
                <td class = "text-wrap align-middle">
                    <?= $cartype->getManufacturer() ?>
                </td>
                <td class = "text-wrap align-middle">
                    <?= $cartype->getType() ?>
                </td>

                <?php if ($cartype->getIsActive() == 0): ?>
                    <td class = "text-wrap align-middle">
                        inaktív
                    </td>
                <?php elseif ($cartype->getIsActive() == 1): ?>
                    <td class = "text-wrap align-middle">
                        aktív
                    </td>
                <?php endif; ?>

                <td class = "text-wrap align-middle">
                    <?= $cartype->getStartOfProductionTime() ?>
                </td>
                <td class = "text-wrap align-middle">
                    <?= $cartype->getEndOfProductionTime() ?>
                </td>
                <td class = "text-wrap align-middle">
                    <?= $cartype->getCreatedAt() ?>
                </td>
                <td class = "text-wrap align-middle">
                    <?= $cartype->getUpdatedAt() ?>
                </td>
                <td>

                    <button type = "button"
                            data-id = "<?= $cartype->getId() ?>"

                            class = "btn btn-info get-car-modal edit-carType ">
                        <a class = "nav-link"><i class = "fa fa-edit " style = "color:white"></i></a>
                    </button>
                    <button type = "button" data-id = "<?= $cartype->getId() ?>" class = "btn btn-danger delete-carType">
                        <a class = "nav-link"><i class = "fa fa-trash " style = "color:white"></i></a>
                    </button>
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
                <h5 class = "modal-title" id = "exampleModalLabel">Típus beállítása</h5>
                <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                    <span aria-hidden = "true">&times;</span>
                </button>
            </div>
            <div class = "modal-body">
                <form method = "POST">
                    <div class = "form-group">
                        <label for = "edit-manufacturer" class = "col-form-label">ID</label><br>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-car-id"
                        >
                    </div>
                    <div class = "form-group">
                        <label for = "edit-manufacturer" class = "col-form-label">Gyártó</label><br>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-manufacturer"
                        >
                    </div>
                    <div class = "form-group">
                        <label for = "edit-type" class = "col-form-label">Típus</label><br>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-type"
                        >
                    </div>
                    <p style = "padding: 0;margin-bottom: 10px">Státusz</p>
                    <div class = "custom-control custom-switch">
                        <input
                                type = "checkbox"
                                class = "custom-control-input"
                                id = "edit-is-active"
                        >
                        <label for = "edit-is-active" class = " custom-control-label"></label><br>
                    </div>
                    <div class = "form-group">
                        <label for = "edit-startOfProduction" class = "col-form-label">Gyártás kezdete</label><br>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-startOfProduction"

                        >
                    </div>
                    <div class = "form-group">
                        <label for = "edit-endOfProduction" class = "col-form-label">Gyártás vége</label><br>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-endOfProduction"
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
</div>


<script src = "/public/assets/js/pages/carTypes/index.js" type = "module"></script>
<?php include '../app/view/_footer.php'; ?>

