<?php use Core\{Form, Session}; ?>

<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('content'); ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= $this->getSiteTitle() ?></h1>
        <a href="<?= ROOT ?>admin/categories" class="btn btn-sm btn-success">Categories list</a>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">

            <?= Session::displaySessionAlerts(); ?>

            <form action="" method="POST">
                <?= Form::csrfField(); ?>
                <div class="row">
                    <?= Form::input('Name', 'name', $this->category->name, ['class' => 'form-control'], ['class' => 'form-group col-md-6 mb-2'], $this->errors); ?>
                </div>

                <div class="mt-3">
                    <input class="btn btn-primary" type="submit" value="Submit">
                    <a href="<?= ROOT ?>admin/categories" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
<?php $this->end(); ?>