<style>
    body {
        height: 80vh;
        width: 100%;
        background-repeat: no-repeat;
        background-size: cover;
        background-image: url("/images/car1.png");
        color: white !important;
        background-position: center;
    }

    .card {
        width:400px;
        height: 200px;

        background-repeat: no-repeat;
        background-size: cover;
    }

</style>
<?php

use app\model\topic\Topic;

include '../app/view/_header.php';
/** @var Topic[] $allTopics */
?>


<br>
<?php if (empty($allTopics)): ?>
    <p>
    <td colspan = "11">Nincs adat</td>
    <p>
<?php else: ?>



    <?php foreach ($allTopics as $topic): ?>
        <div class = "card" style = "background-image: url('<?= $topic->getImg() ?>'">
            <h1><?= $topic->getTitle(); ?></h1>
            <button  type="button" class="read-more" data-topic-id="<?= $topic->getId(); ?>" style="background-color: darkgrey">
                <a href="../forumController/showView/<?= $topic->getId(); ?>" style="color: blue;">read more</a>
            </button>
        </div>
        <br>
    <?php endforeach ?>
<?php endif; ?>




