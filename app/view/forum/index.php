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

$userModel = new UserModel();
$user = new Authenticator();

?>

<div class = "container container col-sm-6 col-sm">
    <form action = "/ForumController/insert" method = "post">


        <h1><?= $topic->getTitle() ?></h1>
        <p><?= $topic->getSmallContent()?></p>
        <img src="<?php echo $topic->getImg() ?>" alt="Girl in a jacket" width="700px" height="400px">
        <p><?=$topic->getContent() ?></p>


        <?php
        foreach ($comments as $item) {
            ?>
            <div class = "name-time-container">
                <p class = "user"><?= $item->getRealName() ?></p>
                <p class = "time"><?= $item->getCreatedAt() ?></p>
            </div>

            <p><?= $item->getMessage() ?></p>

            <?php
        }

        ?>
        <div class = "card-body">
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
            <div style = "display: none" class = "form-group">
                <label for = "topic-id" class = "input-required">Topic</label>
                <input type = "text"
                       class = "form-control <?= !isset($errors) ? '' : (!empty($errors['topic-id']) ? 'is-invalid' : 'is-valid'); ?>"
                       id = "topic-id"
                       name = "topic-id"
                       value = "<?= $topic->getId() ?>"
                >
                <div class = "invalid-feedback"><?= $errors['message'] ?? ''; ?></div>
            </div>
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

    </form>
</div>

<?= addReference("assets/js/pages/comments/index.js", true) ?>
<?php include '../app/view/_footer.php' ?>
