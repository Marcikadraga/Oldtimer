<?php include '../app/view/_header.php' ?>
<?php
/** @var array $user A sikeres mentés eredménye */

?>
<style>
    .button-container {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    button {
        margin-left: 10px;
    }

    img {
        width: 100%;
        margin-top: 15px;
    }

</style>

<div class = "container">
    <div class = "row">
        <div class = "col-12 col-md-4 border">
            <img src = "https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt = "">
            <hr>
            <button type = "button" data-id = "<?= $user->getId() ?>" class = "btn btn-primary edit-user" data-toggle = "modal" data-target = "#exampleModal4Password">
                <i class = 'fas fa-edit' style = 'font-size:20px;color:white'>Get new password</i>
            </button>

        </div>
        <div>

        </div>
        <div class = "col-12 col-md-8">
            <div class = "card">
                <div class = "card-body">

                    <div class = "row" style = "display:none">
                        <div class = "col-sm-6">
                            <p class = "mb-0">ID</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getId() ?></p>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Név</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getUsername() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Email</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getEmail() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Keresztnév</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getFirstName() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Középső név</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getMiddleName() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Vezeték név</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getLastName() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Születési dátum</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getBirthDate() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Telefonszám</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getPhoneNumber() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Irányítószám</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getZipCode() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Város</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getCity() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Kerület</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getDistrict() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Cím</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getMoreAddress() ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class = "row">
                        <div class = "col-sm-6">
                            <p class = "mb-0">Role</p>
                        </div>
                        <div class = "col-sm-6">
                            <p class = "text-muted mb-0"><?php echo $user->getRole() ?></p>
                        </div>
                    </div>
                    <hr>

                    <div class = "row">
                        <div class = "button-container">
                            <button type = "button" data-id = "" class = "btn btn-info get-car-modal edit-car" data-toggle = "modal" data-target = "#exampleModal"><a class = "nav-link"><i class = "fa fa-edit " style = "color:white"></i></a>
                            </button>
                            <button type = "button" data-id = "" class = "btn btn-danger delete-car"><a class = "nav-link" href = "/"><i class = "fa fa-trash " style = "color:white"></i></a></button>
                        </div>
                    </div>
                </div>
            </div>
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

                            <div class = "form-group" style = "display:none">
                                <label for = "recipient-name" class = "col-form-label">Id</label>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-user-id"
                                        value = "<?php echo $user->getId() ?>"
                                >

                            </div>
                            <div class = "form-group">
                                <label for = "recipient-name" class = "col-form-label">Felhasználónév</label>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-username"
                                        value = "<?php echo $user->getUsername() ?>"

                                >

                            </div>
                            <div class = "form-group">
                                <label for = "recipient-name" class = "col-form-label">Email</label>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-email"
                                        value = "<?php echo $user->getEmail() ?>"
                                >

                            </div>
                            <div class = "form-group">
                                <label for = "recipient-name" class = "col-form-label">Keresztnév</label>
                                <input type = "text" class = "form-control" id = "edit-firstName" value = "<?php echo $user->getFirstName() ?>">
                            </div>
                            <div class = "form-group">
                                <label for = "recipient-name" class = "col-form-label">Középső név</label>
                                <input type = "text" class = "form-control" id = "edit-middleName" value = "<?php echo $user->getMiddleName() ?>">
                            </div>
                            <div class = "form-group">
                                <label for = "recipient-name" class = "col-form-label">Vezetéknév</label>
                                <input type = "text" class = "form-control" id = "edit-lastName" value = "<?php echo $user->getLastName() ?>">
                            </div>
                            <div class = "form-group">
                                <label for = "recipient-name" class = "col-form-label">Születési dátum</label>
                                <input type = "text" class = "form-control" id = "edit-birthdate" value = "<?php echo $user->getBirthDate() ?>">
                            </div>
                            <div class = "form-group">
                                <label for = "recipient-name" class = "col-form-label">Telefonszám</label>
                                <input type = "text" class = "form-control" id = "edit-phoneNumber" value = "<?php echo $user->getPhoneNumber() ?>">
                            </div>
                            <div class = "form-group">
                                <label for = "message-text" class = "col-form-label">Irányítószám</label>
                                <input type = "text" class = "form-control" id = "edit-zip_code" value = "<?php echo $user->getZipCode() ?>">
                            </div>
                            <div class = "form-group">
                                <label for = "message-text" class = "col-form-label">Város</label>
                                <input type = "text" class = "form-control" id = "edit-city" value = "<?php echo $user->getCity() ?>">
                            </div>
                            <div class = "form-group">
                                <label for = "message-text" class = "col-form-label">Kerület</label>
                                <input type = "text" class = "form-control" id = "edit-district" value = "<?php echo $user->getDistrict() ?>">
                            </div>
                            <div class = "form-group">
                                <label for = "message-text" class = "col-form-label">Teljes cím</label>
                                <input type = "text" class = "form-control" id = "edit-moreAddress" value = "<?php echo $user->getMoreAddress() ?>">
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

        <div class = "modal fade" id = "exampleModal4Password" tabindex = "-1" aria-labelledby = "exampleModal4PasswordLabel" aria-hidden = "true">
            <div class = "modal-dialog">
                <div class = "modal-content">
                    <div class = "modal-header">
                        <h5 class = "modal-title" id = "exampleModal4PasswordLabel">New message</h5>
                        <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                            <span aria-hidden = "true">&times;</span>
                        </button>
                    </div>
                    <div class = "modal-body">
                        <form method = "POST">
                            <div class = "form-group" style = "display:none">
                                <label for = "recipient-name" class = "col-form-label">Id</label>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-user-id"
                                        value = "<?php echo $user->getId() ?>"
                                >
                                </div>

                            <div class = "form-group" >
                                <label for = "recipient-name" class = "col-form-label">Jelszó</label>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-password1"
                                        name="password1"
                                >

                            </div>
                            <div class = "form-group">
                                <label for = "recipient-name" class = "col-form-label">Jelszó újra</label>
                                <input
                                        type = "text"
                                        class = "form-control"
                                        id = "edit-password2"
                                        name="password2"
                                >
                            </div>
                        </form>
                    </div>
                    <div class = "modal-footer">
                        <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Mégse</button>
                        <button type = "button" id = "save-edited-password" class = "btn btn-primary save-new-password">Mentés</button>
                    </div>
                </div>
            </div>
        </div>


        <script src = "/assets/js/pages/users/index.js" type = "module"></script>
        <?php include '../app/view/_footer.php'; ?>

