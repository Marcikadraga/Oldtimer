<?php
/** @var bool $isLoggedInUser True, ha van belépett user */
/** @var bool $userIsAdmin True, ha van belépett user */
?>
<!doctype html>
<html lang = "hu" class = "h-100">
<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel = "stylesheet" href = "/assets/css/bootstrap.4.5.css">
    <link rel = "stylesheet" href = "/assets/css/custom.css">
    <link rel = "stylesheet" href = "/assets/plugins/fontawesome-free-5.15.4-web/css/all.min.css">

</head>
<body class = "d-flex flex-column h-100">

<nav class = "navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <div class = "container">
        <button class = "navbar-toggler" type = "button" data-toggle = "collapse" data-target = "#navbar-toggler-region" aria-controls = "navbar-toggler-region" aria-expanded = "false" aria-label = "Toggle navigation">
            <span class = "navbar-toggler-icon"></span>
        </button>
        <div class = "collapse navbar-collapse" id = "navbar-toggler-region">
            <ul class = "navbar-nav mr-auto mt-2 mt-lg-0">
                <li class = "nav-item">
                    <a style = "margin-right: 20px" class = "nav-link" href = "/"><i style="margin-right: 5px" class = "fa fa-home fa-lg"></i>Főoldal</a>
                </li>
                <li class = "nav-item">
                    <a style = "margin-right: 20px" class = "nav-link" href = "/UserController/showUserProfile"> <i style="margin-right: 5px" class = "fas fa-user-cog fa-lg"></i>Profil</a>
                </li>

                <ul class = "navbar-nav">
                    <li class = "nav-item dropdown">
                        <a class = "nav-link dropdown-toggle" href = "#" id = "navbarDropdownMenuLink" role = "button" data-toggle = "dropdown" aria-haspopup = "true" aria-expanded = "false">
                            <i style="margin-right: 5px" class = "fas fa-car fa-lg"></i>Autók
                        </a>
                        <div class = "dropdown-menu" aria-labelledby = "navbarDropdownMenuLink">
                            <a class = "nav-link" href = "/CarController"> <i style="margin-right: 5px" class = "fas fa-car-side fa-lg"></i>Autóim</a>
                            <a style = "width:200px " class = "nav-link" href = "/carController/insert"> <i style="margin-right: 5px" class = "fas fa-ambulance fa-lg"></i>Autó hozzáadása</a>
                            <a class = "nav-link" href = "/CarController"> <i  style="margin-right: 5px" class = "fas fa-car fa-lg"></i>Összes Autó</a>
                        </div>
                    </li>
                </ul>


            </ul>
            <?php if ($isLoggedInUser): ?>
                <ul class = "navbar-nav">
                    <li class = "nav-item dropdown">
                        <?php if ($userIsAdmin): ?>
                            <a class = "nav-link dropdown-toggle" href = "#" id = "navbarDropdownMenuLink" role = "button" data-toggle = "dropdown" aria-haspopup = "true" aria-expanded = "false">
                                <i style="margin-right: 5px" class = "fas fa-cog fa-lg"></i>Admin
                            </a>

                            <div class = "dropdown-menu" aria-labelledby = "navbarDropdownMenuLink">
                                <a class = "nav-link" href = "/carTypeController/insert">Új autótípus</a>
                                <a class = "nav-link" href = "/carTypeController">Autótípusok</a>
                                <a class = "nav-link" href = "/userController">Felhasználók</a>
                            </div>
                        <?php endif; ?>
                </ul>
            <?php endif; ?>


            <ul class = "navbar-nav ml-auto mt-2 mt-lg-0">
                <?php if (!$isLoggedInUser): ?>
                    <li class = "nav-item">
                        <a class = "nav-link" href = "/login">Belépés</a>
                    </li>
                <?php else: ?>


                    <?php if (!$userIsAdmin): ?>
                        <li class = "nav-item"><a href = "/UserController/showUserProfile" class = "nav-link" = "">
                            Szervusz <?= !empty($greetingsName) ? $greetingsName . "! " : ''; ?><?= !empty($loginTime) ? $loginTime . "! " : 'sry'; ?></a></li>
                    <?php endif; ?>

                    <?php if ($userIsAdmin): ?>
                        <li class = "nav-item"><a href = "/UserController/showUserProfile" class = "nav-link" = "">
                            Szervusz <?= !empty($greetingsName) ? $greetingsName . "! " : ''; ?><?= !empty($loginTime) ? $loginTime . "! " : 'sry'; ?></a></li>
                    <?php endif; ?>


                    <li class = "nav-item">
                        <a class = "nav-link" href = "/login/logout"><i class = "fas fa-running fa-lg"></i>Kijelentkezés</a>
                    </li>

                <?php endif; ?>
                <?php if (!$isLoggedInUser): ?>
                    <li class = "nav-item">
                        <a class = "nav-link" href = "UserController/insert">Regisztráció</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
<main id = "main-content">
