<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('content'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $this->getSiteTitle() ?></h1>
    <a href="<?= ROOT ?>admin/category/new" class="btn btn-sm btn-success">&plus;&nbsp;Add category</a>
</div>

<?php if(count($this->categories) > 0): ?>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col text-right"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->categories as $category) : ?>
                <tr>
                    <td><?= $category->name ?></td>
                    <td>
                        <a href="<?= ROOT ?>admin/category/<?= $category->id ?>" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger" onclick="confirmAction('<?= $category->id ?>')">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php $this->section('admin/sections/pagination'); ?>

</div>
<?php endif; ?>

<script>
    function confirmAction(categoryId) {
        if (window.confirm("Are you sure for this action?")) {
            window.location.href = `<?= ROOT ?>admin/deleteCategory/${categoryId}`;
        }
    }
</script>

<?php $this->end(); ?>