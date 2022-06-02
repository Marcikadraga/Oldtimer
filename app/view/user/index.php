<?php

use app\model\user\User;

include '../app/view/_header.php';

/** @var User $user */

?>
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
        <th style = "width: 200px">műveletek</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo $user->getId() ?></td>
        <th style = "text-align: center ">
            <button type = "button" data-id = "<?php echo $user['id'] ?>" class = "btn btn-primary edit-user" data-toggle = "modal" data-target = "#exampleModal">Edit</button>
            <button type = "button" data-id = "<?php echo $user['id'] ?>" class = "btn btn-danger delete-user">Delete</button>
        </th>
    </tr>
    <?php


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
                        <label for = "recipient-name" class = "col-form-label">ID</label>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-user-id">
                    </div>
                    <div class = "form-group">
                        <label for = "recipient-name" class = "col-form-label">Username</label>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-username">
                    </div>
                    <div class = "form-group">
                        <label for = "recipient-name" class = "col-form-label">Email</label>
                        <input
                                type = "text"
                                class = "form-control"
                                id = "edit-email">
                    </div>
                    <div class = "form-group">
                        <label for = "recipient-name" class = "col-form-label">First name</label>
                        <input type = "text" class = "form-control" id = "edit-firstName">
                    </div>
                    <div class = "form-group">
                        <label for = "recipient-name" class = "col-form-label">Middle name</label>
                        <input type = "text" class = "form-control" id = "edit-middleName">
                    </div>
                    <div class = "form-group">
                        <label for = "recipient-name" class = "col-form-label">Last name</label>
                        <input type = "text" class = "form-control" id = "edit-lastName">
                    </div>
                    <div class = "form-group">
                        <label for = "recipient-name" class = "col-form-label">Birthdate</label>
                        <input type = "text" class = "form-control" id = "edit-birthdate">
                    </div>
                    <div class = "form-group">
                        <label for = "recipient-name" class = "col-form-label">PhoneNumber</label>
                        <input type = "text" class = "form-control" id = "edit-phoneNumber">
                    </div>
                    <div class = "form-group">
                        <label for = "message-text" class = "col-form-label">Zip_code</label>
                        <input type = "text" class = "form-control" id = "edit-zip_code">
                    </div>
                    <div class = "form-group">
                        <label for = "message-text" class = "col-form-label">City</label>
                        <input type = "text" class = "form-control" id = "edit-city">
                    </div>
                    <div class = "form-group">
                        <label for = "message-text" class = "col-form-label">District</label>
                        <input type = "text" class = "form-control" id = "edit-district">
                    </div>
                    <div class = "form-group">
                        <label for = "message-text" class = "col-form-label">More Address</label>
                        <input type = "text" class = "form-control" id = "edit-moreAddress">
                    </div>

                    <?php if ($user->getRole()=='admin'): ?>
                        <div class = "form-group">
                            <label for = "role" class = "col-form-label">Jogosultság</label>
                            <select class = "form-control" id = "edit-role" name = "role">
                                <option value = "admin">admin</option>
                                <option value = "guest">user</option>
                            </select>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            <div class = "modal-footer">
                <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Close</button>
                <button type = "button" id = "save-edited-data" class = "btn btn-primary save-edited-data">Save</button>
            </div>
        </div>
    </div>
</div>

    <script src = "/assets/js/pages/users/index.js" type = "module"></script>
<?php include '../app/view/_footer.php';
