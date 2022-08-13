<?php 
use Core\Helper; 

global $currentLoggedInUser;
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <?= Helper::menuItem('admin/articles', 'Articles'); ?>
            <?php if($currentLoggedInUser->hasPermission('admin')) : ?>
                <?= Helper::menuItem('admin/categories', 'Categories'); ?>
                <?= Helper::menuItem('admin/users', 'Users'); ?>
            <?php endif; ?>
        </ul>
    </div>
</nav>