<?php
global $currentLoggedInUser;

use Core\{Helper, Session};
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>Admin Dashboard :: <?= $this->getSiteTitle() ?></title>
    <link href="<?= ROOT ?>app/public/admin/css/bootstrap.min.css" rel="stylesheet">

    <meta name="theme-color" content="#712cf9">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .nav li a:hover,
        .nav li.active a {
            color: #111;
            background-color: #c1c1c1;
            text-decoration: none;
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="<?= ROOT ?>app/public/admin/css/dashboard.css" rel="stylesheet">

    <?php $this->content('head'); ?>
    
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <?php if ($currentLoggedInUser) : ?>
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Welcome, <?= $currentLoggedInUser->first_name ?></a>
        <?php endif; ?>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <?php if ($currentLoggedInUser) : ?>
                    <a class="nav-link px-3" href="<?= ROOT ?>auth/logout">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <?php $this->section('admin/sections/navbar'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <br>
                <?= Session::displaySessionAlerts(); ?>

                <?php $this->content('content'); ?>
            </main>
        </div>
    </div>

    <script src="<?= ROOT ?>app/public/admin/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT ?>app/public/admin/feather.min.js"></script>
    <script src="<?= ROOT ?>app/public/admin/Chart.min.js"></script>
    <script src="<?= ROOT ?>app/public/admin/dashboard.js"></script>
</body>

</html>