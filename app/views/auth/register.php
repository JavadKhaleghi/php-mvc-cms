<?php use Core\Form; ?>

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
        <form action="" method="POST">
            <div class="row">
                <?= Form::inputBlock('First Name', 'first_name', '', ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= Form::inputBlock('Last Name', 'last_name', '', ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= Form::inputBlock('Email', 'email', '', ['class' => 'form-control', 'type' => 'email'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            </div>

            <div class="row">
                <?= Form::inputBlock('Password', 'password', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= Form::inputBlock('Confirm Password', 'confirm', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            </div>

            <div class="text-right">
                <a href="<?= ROOT ?>" class="btn btn-secondary">Cancel</a>
                <input class="btn btn-primary" value="Register" type="submit" />
            </div>
        </form>
    </div>
</div>

<?php $this->end(); ?>