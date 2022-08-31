<style>

    .img-container {
        width: 100%;
        height: 600px;

        background-repeat: no-repeat;
        background-size: cover;

    }

    .container {
        width: 300px;
        height: 150px;

    }

    .user-name {
        padding: 0;
        margin: 0;
        font-family: "Arial Black", serif;
        color: blue;
    }

    .msg {
        padding: 0;
        margin: 0;
        font-family: "Century Gothic", serif;
    }

    .msg-container {
        display: flex;
        padding: 0;
        margin-bottom: 10px;
    }

    .date {
        margin-left: 5px;
        margin-bottom: 0;
        width:300px;
    }
    .btn-container{
        width: 100%;
        display: flex;
        justify-content: flex-end;

    }


</style>


<?php use app\model\comment\Comment;
use app\model\forum\Forum;
use app\model\user\UserModel;

include '../app/view/_header.php';

/** @var Forum $forum */
/** @var Comment[] $chiefComments */

?>

<div class = "container">
    <h1><?= $forum->getTitle() ?></h1>
    <h3><?= $forum->getSmallContent() ?></h3>
    <div class = "img-container" style = "background-image:url('<?= $forum->getImg() ?>');"></div>

    <p><?= $forum->getContent() ?></p>
    <hr>



    <div class = "container container col-sm-15 col-sm" style="margin: 0px !important; padding: 0px !important;">
        <form action = "/ForumController/insert" style="margin: 0px !important; padding: 0px !important; method = "post">
            <div class = "card" style="border: none !important;">
                <div  style="border: none !important; margin: 0px !important; padding: 0px !important;"class = "card-body">
                    <?php if (!empty($errorMsg)): ?>
                        <div class = "alert alert-danger">
                            <p class = "m-0"><?= $errorMsg ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($successMsg)): ?>
                        <div class = "alert alert-success">
                            <p class = "m-0"><?= $successMsg; ?></p>
                        </div>
                    <?php endif; ?>

                    <label for = "year_of_manufacture" >Új hozzászólás:</label>
                        <input  type = "text"
                               class = "form-control <?= !isset($errors) ? '' : (!empty($errors['message']) ? 'is-invalid' : 'is-valid'); ?>"
                               id = "message"
                               name = "message"
                               value = "<?= !empty($car) ? $car->getKilometersTraveled() : ''; ?>"
                               minlength = "3"
                        >
                        <div class = "invalid-feedback"><?= $errors['kilometers_traveled'] ?? ''; ?></div>
                    </div>
                </div>

        <div style="margin-top: 10px">
            <button type = "button" class = "btn btn-primary" id = "save-edited-data2">Küldés</button>
        </div>
        </form>
    </div>




















    <div class = "comment-container">
        <?php
        $userModel = new UserModel();
        foreach ($chiefComments as $item) {
            ?>
            <div class = "msg-container">
                <div>
                    <div style = "display: flex;margin: 0">
                        <p class = "user-name"> <?= $userModel->getById($item->getUserId())->getUsername() ?></p>
                        <p class = "date"><?= $item->getCreatedAt() ?></p>
                    </div>

                    <p class = "msg"><?= $item->getMessage() ?></p>
                </div>

                <div class="btn-container" >
                    <button style="margin-right: 10px" type = "button" data-id = "<?= $item->getId() ?>" class = "btn btn-info get-car-modal edit-msg"><a class = "nav-link"><i class = "fa fa-edit " style = "color:white;"></i></a>
                    </button>
                    <button type = "button" class = "btn btn-danger delete-msg"><a class = "nav-link" href = "/"><i class = "fa fa-trash " style = "color:white;"></i></a></button>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>


<?php include '../app/view/_footer.php' ?>
