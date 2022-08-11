<?php

use Core\{Form, Session}; ?>

<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('content'); ?>

<div class="site-section-cover overlay" style="background-image: url('<?= ROOT ?>app/public/site/images/hero_bg.jpg');">

    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-10 text-center">
                <h1><strong><?= $this->getSiteTitle() ?></strong></h1>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-8 offset-md-2 poster">

        <?= Session::displaySessionAlerts(); ?>

        <form action="" method="POST">
            <?= Form::csrfField(); ?>
            <div class="row">
                <?= Form::input('Email', 'email', $this->user->email, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= Form::input('Password', 'password', $this->user->password, ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            </div>

            <div class="row">
                <div class="col">
                    <?= Form::checkbox('Remember me', 'remember', $this->user->remember == 'on', ['class' => 'form-check-input'], ['class' => 'form-group form-check'], $this->errors); ?>
                </div>
            </div>

            <div class="text-right">
                <a href="<?= ROOT ?>" class="btn btn-secondary">Cancel</a>
                <input class="btn btn-primary" type="submit" value="Login">
            </div>
        </form>
    </div>
</div>

<?php $this->end(); ?>