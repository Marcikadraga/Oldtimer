<?php
/** @var bool $userIsAdmin True, ha a belépett user admin */
?>
<style>
    body {
        background-repeat: no-repeat;
        background-size: cover;
        background-image: url("/images/car2.png");
        color: white !important;
        background-position: center;
    }

    .container {
        display: flex;
        justify-content: center;
        padding: 10px;
    }

    .admin-button a {
        color: white !important;
    }

    .admin-button {

        height: 100px;
        width: 150px;
        border: 2px solid red;
        border-radius: 10px !important;
        color: white !important;
        font-size: 20px !important;
        background-color: red;
    }

    .right-buttons {
        margin-left: 10px;
    !important;
        margin-right: 10px;
    !important;
    }

    #admin-left {
        margin-right: 20px;
    }

    #admin-right {
        margin-left: 20px;
    !important;

    }
</style>
<?php include '../app/view/_header.php' ?>


<div class = "btn-group" role = "group" aria-label = "Basic example">

</div>
<div class = "container">
    <div class = "btn-toolbar" role = "toolbar" aria-label = "Toolbar with button groups">
        <div class = "btn-group mr-2" role = "group" aria-label = "First group" id = "admin-left">
            <button class = "admin-button" style = "margin-right: 5px"><a href = "../../userController">Felhasználók</a></button>
            <button class = "admin-button" style = "margin-right: 5px"><a href = "../../carTypeController">Autótípusok</a></button>
            <button class = "admin-button" style = "margin-right: 5px"><a href = "../../colorcontroller/getAllColor">Színek</a></button>
        </div>
        <div class = "btn-group mr-2 right-buttons" role = "group" aria-label = "Second group" id = "admin-right">

            <button class = "admin-button" style = "margin-right: 5px"><a href = "../../carTypeController/insert">Új autótípus</a></button>
            <button class = "admin-button" style = "margin-right: 5px"><a href = "../../colorController/insertColor">Új szín</a></button>
            <button class = "admin-button" style = "margin-right: 5px"><a href = "../../userController">Új gyártó</a></button>
        </div>
    </div>
</div>

<a href = ""></a>


<?php include '../app/view/_footer.php' ?>


