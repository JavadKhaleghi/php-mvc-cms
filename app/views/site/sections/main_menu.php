<?php
global $currentLoggedInUser;

use Core\Helper;
?>

<nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
    <ul class="site-menu main-menu js-clone-nav ml-auto ">
        <li class="<?= Helper::menuActiveClass('') ?>"><a href="<?= ROOT ?>" class="nav-link">Home</a></li>
        <li class="<?= Helper::menuActiveClass('articles') ?>"><a href="<?= ROOT ?>articles" class="nav-link">Blog</a></li>

        <li class="nav-item dropdown <?php if(Helper::isCurrentPage('auth/login') || Helper::isCurrentPage('auth/register') || Helper::isCurrentPage('auth/register')): ?><?= 'active' ?><?php endif; ?>">
            <a href="#" class="nav-link dropdown-toggle" id="dropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Users
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <?php if (!$currentLoggedInUser) : ?>
                    <li><a href="<?= ROOT ?>auth/login" class="dropdown-item text-black">Login</a></li>
                    <li><a href="<?= ROOT ?>auth/register" class="dropdown-item text-black">Register</a></li>
                <?php else : ?>
                    <li><a href="#" class="dropdown-item text-black">Admin Panel</a></li>
                <?php endif; ?>
            </ul>
        </li>
        <?php if ($currentLoggedInUser) : ?>
            <li><a href="<?= ROOT ?>auth/logout" class="nav-link"><button class="btn btn-danger" class="nav-link">Logout</button></a></li>
        <?php endif; ?>
    </ul>
</nav>