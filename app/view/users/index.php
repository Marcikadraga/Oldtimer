<?php

use app\model\user\User;

include '../app/view/_header.php';

/** @var User[] $users A táblázatban szereplő userek */
?>

    <div class = "table-responsive">
        <table class = "table table-striped table-bordered text-center">
            <thead class = "thead-dark">
            <tr>
                <th class = "text-wrap align-middle">ID</th>
                <th class = "text-wrap align-middle">Név</th>
                <th class = "text-wrap align-middle">Születési idő</th>
                <th class = "text-wrap align-middle">Cím</th>
                <th class = "text-wrap align-middle">Email</th>
                <th class = "text-wrap align-middle">Telefonszám</th>
                <th class = "text-wrap align-middle">Weboldal</th>
                <th class = "text-wrap align-middle">Jogosultság</th>
                <th class = "text-wrap align-middle">Username</th>
                <th class = "text-wrap align-middle">Utolsó belépés ideje</th>
                <th class = "text-wrap align-middle">Műveletek</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan = "11">Nincs adat</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class = "text-wrap align-middle">
                            <?= $user->getId() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $user->getFullName() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $user->getBirthDate() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $user->getFullAddress() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $user->getEmail() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $user->getPhoneNumber() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?php if (!empty($user->getWebpage())): ?>
                                <a href = "<?= $user->getWebpage() ?>" target = "_blank">
                                    <?= $user->getWebpage() ?>
                                </a>
                            <?php else: ?>
                                -
                            <?php endif ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $user->getRole() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $user->getUsername() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <?= $user->getLastLoginAt() ?>
                        </td>
                        <td class = "text-wrap align-middle">
                            <button type = "button" data-id = "<?= $user->getId() ?>" class = "btn btn-primary edit-user" data-toggle = "modal" data-target = "#exampleModal">
                                <i class='fas fa-edit' style='font-size:20px;color:white'></i>
                            </button>
                            <button type = "button" data-id = "<?= $user->getId() ?>" class = "btn btn-danger delete-user">
                                <i class='fas fa-trash-alt' style='font-size:20px;color:white'></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
            </tbody>
        </table>
    </div>

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

                        <div class = "form-group">
                            <label for = "role" class = "col-form-label">Jogosultság</label>
                            <select class = "form-control" id = "edit-role" name = "role">
                                <option value = "admin">admin</option>
                                <option value = "guest">user</option>
                            </select>
                        </div>
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
