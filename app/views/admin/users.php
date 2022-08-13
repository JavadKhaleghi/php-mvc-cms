<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('content'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $this->getSiteTitle() ?></h1>
    <a href="<?= ROOT ?>auth/register" class="btn btn-sm btn-success">&plus;&nbsp;Add user</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Level</th>
                <th scope="col">Status</th>
                <th scope="col text-right"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->users as $user) : ?>
                <tr>
                    <td><?= $user->displayFullName() ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= ucfirst($user->acl) ?></td>
                    <td>...</td>
                    <td>
                        <a href="<?= ROOT ?>auth/register/<?= $user->id ?>" class="btn btn-sm btn-info">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php $this->section('admin/sections/pagination'); ?>

</div>

<?php $this->end(); ?>