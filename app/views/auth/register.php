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
                <?= Form::input('First Name', 'first_name', $this->user->first_name, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= Form::input('Last Name', 'last_name', $this->user->last_name, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= Form::input('Email', 'email', $this->user->email, ['class' => 'form-control', 'type' => 'text', 'autocomplete' => 'off'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= Form::select('Level', 'acl', $this->user->acl, $this->roleOptions, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            </div>

            <div class="row">
                <?= Form::input('Password', 'password', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= Form::input('Confirm Password', 'confirm', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            </div>

            <div class="text-right">
                <a href="<?= ROOT ?>" class="btn btn-secondary">Cancel</a>
                <input class="btn btn-primary" type="submit" value="Register">
            </div>
        </form>
    </div>
</div>

<?php $this->end(); ?>