<?php include '../app/view/_header.php' ?>

    <table class = "table">
        <thead class = "thead-dark">
        <tr>
            <th>ID</th>
            <th>Gyártó</th>
            <th>Típus</th>
            <th>Gyártás kezdete</th>
            <th>Gyártás vége</th>
            <th>Feltöltve</th>
            <th>Frissítve</th>
            <th>Műveletek</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($carType)) {
            foreach ($carType as $car) {
                ?>
                <tr class = "trValues">
                    <?php
                    $id = $car['id'];
                    foreach ($car as $key => $value) {
                        if ($key == "deleted_at") continue;
                        ?>
                        <td><?php echo $value; ?></td>
                        <?php
                    }
                    ?>
                    <th style = "text-align: center">
                        <button type = "button" data-id = "<?php echo $car['id']; ?>" class = "btn btn-info get-car-modal edit-car" data-toggle = "modal" data-target = "#exampleModal"><a class = "nav-link" ><i class="fa fa-edit "style="color:white"></i></a></button>
                        <button type = "button" data-id = "<?php echo $id ?>" class = "btn btn-danger delete-car"><a class = "nav-link" href = "/"><i class="fa fa-trash " style="color:white"></i></a></button>
                    </th>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan = "5">Nincs adat</td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>


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

