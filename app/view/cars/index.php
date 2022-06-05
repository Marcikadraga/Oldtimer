<?php include '../app/view/_header.php' ?>

    <table class = "table">
        <thead class = "thead-dark">
        <tr>
            <?php
            //lekérem a key-ket és beállítom őket theadnek
            if (!empty($fields)) {
                foreach ($fields as $field) {
                    ?>
                    <th><?php echo $field ?></th>
                    <?php
                }
            } else {
                ?>
                <th>Nincs adat</th>
                <?php
            }
            ?>
            <th style = "text-align: center" colspan = "2">műveletek</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($cars)) {
            foreach ($cars as $car) {
                ?>
                <tr class = "trValues">
                    <?php
                    $id = $car['id'];
                    foreach ($car as $key => $value) {
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
                    <form>
                        <div class = "form-group">
                            <label for = "edit-manufacturer" class = "col-form-label">ID</label><br>
                            <input
                                    type = "text"
                                    class = "get-car-modal"
                                    id = "edit-car-id"
                            >
                        </div>
                        <div class = "form-group">
                            <label for = "edit-manufacturer" class = "col-form-label">manufacturer</label><br>
                            <input
                                    type = "text"
                                    class = "get-car-modal"
                                    id = "edit-manufacturer"
                            >
                        </div>
                        <div class = "form-group">
                            <label for = "edit-type" class = "col-form-label">Type</label><br>
                            <input
                                    type = "text"
                                    class = "get-car-modal"
                                    id = "edit-type"
                            >
                        </div>
                        <div class = "form-group">
                            <label for = "edit-startOfProduction" class = "col-form-label">Start of production time</label><br>
                            <input
                                    type = "text"
                                    class = "get-car-modal"
                                    id = "edit-startOfProduction"
                            >
                        </div>
                        <div class = "form-group">
                            <label for = "edit-endOfProduction" class = "col-form-label">End of production time</label><br>
                            <input
                                    type = "text"
                                    class = "get-car-modal"
                                    id = "edit-endOfProduction"
                            >
                        </div>
                    </form>
                </div>
                <div class = "modal-footer">
                    <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Close</button>
                    <button type = "button" class = "btn btn-primary" id = "save-edited-data">Save</button>
                </div>
            </div>
        </div>
    </div>


    <script src = "/assets/js/pages/cars/index.js" type = "module"></script>
<?php include '../app/view/_footer.php'; ?>

