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
<?php include '../app/view/_header.php';
/** @var array[] $allTopics */
?>


<br>
<?php if (empty($allTopics)): ?>
    <p>
    <td colspan = "11">Nincs adat</td>
    <p>
<?php else: ?>

<?php //var_dump($allTopics); ?>

    <?php foreach ($allTopics as $topic): ?>
        <div class = "card" style = "background-image: url('<?= $topic->getImg() ?>'">
            <h1><?= $topic->getTitle(); ?></h1>
        </div>
        <br>
    <?php endforeach ?>
<?php endif; ?>

<?php include '../app/view/_footer.php' ?>


