<style>
    .name-time-container {
        display: flex;
        margin-bottom: 0;
    }

    .user {
        margin-right: 10px;
        color: red;
        margin-bottom: 0;
    }

    .time {
        color: blue;
        margin-bottom: 0;
    }

    .card-body {
        padding: 0 !important;
    }

    .date {
        color: gray;
    }

    .name-time-container {
        width: 30%
    }

    .comment-container {
        display: flex;
        width: 100%;

    }

    .option-container {
        width: 70%;
        display: flex;
        justify-content: flex-end;
    }

    .card-footer {
        margin-bottom: 20px;
    }
    .img-content-container{
        display: flex;
    }
    .content{
        margin-left: 10px;
        padding: 5px;
        font-family: "Lucida Console", "Courier New", monospace;
    }
</style>


<?php use app\model\comment\Comment;
use app\model\forum\Forum;
use app\model\user\Authenticator;
use app\model\user\UserModel;

include '../app/view/_header.php';

/** @var Forum $topic */
/** @var Comment[] $allComment */
/** @var Forum $forum */
/** @var Comment[] $comments */
/** @var $numberOfComments */

$userModel = new UserModel();
$user = new Authenticator();

?>

<div class = "container container col-sm-9 col-sm">
    <form action = "/ForumController/insert" method = "post">


        <div style = "display: flex;margin-bottom: 10px ">
            <div>
                <h1 style = "margin-bottom:0px"><?= $topic->getTitle() ?></h1>
            </div>

            <div style = "display: flex ;justify-content: flex-start; width: 80%;align-items: flex-end;margin-left: 10px">
                <p style = "margin-bottom:2px" class = "date"> <?= $topic->getCreatedAt() ?></p>
            </div>

        </div>


        <h4 style = "text-decoration: underline"><?= $topic->getSmallContent() ?></h4>

        <hr>

        <div class="img-content-container">
            <div>
                <img src = "<?php echo $topic->getImg() ?>" alt = "Girl in a jacket" width = "500px" height = "300px"style="margin-top: 5px">
            </div>
            <div class="content">
                <h6><?= $topic->getContent() ?></h6>
            </div>
        </div>



        <hr>

        <div class = "card-body col-sm-12">
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
            <div style = "display: none" class = "form-group">
                <label for = "user-id" class = "input-required">User ID</label>
                <input type = "text"
                       class = "form-control <?= !isset($errors) ? '' : (!empty($errors['user-id']) ? 'is-invalid' : 'is-valid'); ?>"
                       id = "user-id"
                       name = "user-id"
                       value = "<?= $user->getUserId() ?>"

                >
                <div class = "invalid-feedback"><?= $errors['manufacturer'] ?? ''; ?></div>
            </div>
            <div>
                <div style = "display: none" class = "form-group">
                    <label for = "topic-id" class = "input-required">Topic</label>
                    <input type = "text"
                           class = "form-control <?= !isset($errors) ? '' : (!empty($errors['topic-id']) ? 'is-invalid' : 'is-valid'); ?>"
                           id = "topic-id"
                           name = "topic-id"
                           value = "<?= $topic->getId() ?>"
                    >
                </div>

            </div>



            <p><?= $numberOfComments ?> hozzászólás</p>
            <div class = "form-group">
                <label style = "display: none" for = "topic-id" class = "input-required">Message</label>
                <input type = "text"
                       class = "form-control <?= !isset($errors) ? '' : (!empty($errors['message']) ? 'is-invalid' : 'is-valid'); ?>"
                       id = "message"
                       name = "message"
                       placeholder = "Írj megjegyzést..."

                >
                <div class = "invalid-feedback"><?= $errors['message'] ?? ''; ?></div>
            </div>


            <div class = "card-footer ">
                <div class = "row ">
                    <button class = "btn btn-outline-primary ml-auto text-center" id = "save-data">Küldés</button>
                </div>
            </div>


            <?php
            foreach ($comments as $item) {
                ?>
                <?php if ($item->getDeletedAt() === null): ?>

                    <div id = "<?= $item->getId() ?>">

                        <div class = "comment-container">
                            <div class = "name-time-container">
                                <p class = "user"><?= $item->getRealName() ?></p>
                                <p class = "time"><?= $item->getCreatedAt() ?></p>
                            </div>

                            <div class = "option-container">
                                <button type = "button" data-id = "<?= $item->getId() ?>" class = "btn btn-info get-car-modal edit-comment"><a class = "nav-link"><i class = "fa fa-edit " style = "color:white"></i></a>
                                </button>
                                <button type = "button" data-id = "<?= $item->getId() ?>" id = "edit-comment" class = "btn btn-danger delete-comment"><a class = "nav-link"><i class = "fa fa-trash " style = "color:white"></i></a></button>
                            </div>
                        </div>
                        <p><?= $item->getMessage() ?></p>
                        <hr>
                    </div>

                <?php endif; ?>
                <?php
            }
            ?>
    </form>

    <div class = "modal fade" id = "exampleModal" tabindex = "-1" aria-labelledby = "exampleModalLabel" aria-hidden = "true">
        <div class = "modal-dialog">
            <div class = "modal-content">
                <div class = "modal-header">
                    <h5 class = "modal-title" id = "exampleModalLabel">Autó beállítása</h5>
                    <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                        <span aria-hidden = "true">&times;</span>
                    </button>
                </div>
                <div class = "modal-body">
                    <form method = "POST">
                        <div>
                            <label for = " edit-comment-id" class = "col-form-label">ID</label><br>
                            <input
                                    type = "text"
                                    class = "form-control"
                                    id = "edit-comment-id"
                            >

                            <div>
                            <label for = " edit-name" class = "col-form-label">Name</label><br>
                            <input
                                    type = "text"
                                    class = "form-control"
                                    id = "edit-uid"
                            >

                            <div>
                            <label for = "edit-message" class = "col-form-label">Comment</label><br>
                            <input
                                    type = "text"
                                    class = "form-control"
                                    id = "edit-message"
                            >
                    </form>
                </div>
                <div class = "modal-footer">
                    <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">Mégse</button>
                    <button type = "button" class = "btn btn-primary" id = "save-edited-data">Mentés</button>
                </div>
            </div>
        </div>

        <?= addReference("assets/js/pages/comments/index.js", true) ?>
        <?php include '../app/view/_footer.php' ?>
