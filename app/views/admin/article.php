<?php use Core\{Form, Session}; ?>

<?php $this->start('head'); ?>
<style>
    #body {
        width: 1000px;
        margin: 20px auto;
    }

    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 500px;
    }

    .ck-content .image {
        /* block images */
        max-width: 80%;
        margin: 20px auto;
    }

    .is-invalid+.ck-editor .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        border-color: crimson;
    }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script>
    window.addEventListener('load', function() {
        ClassicEditor
            .create(document.querySelector('#body'))
            .catch(error => {
                console.error(error);
            });
    });
</script>
<?php $this->end(); ?>

<?php $this->start('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $this->getSiteTitle() ?></h1>
    <a href="<?= ROOT ?>admin/articles" class="btn btn-sm btn-success">Articles list</a>
</div>

<div class="row mt-2">
    <div class="col-md-12">

        <?= Session::displaySessionAlerts(); ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <?= Form::csrfField(); ?>
            <div class="row">
                <?= Form::input('Title', 'title', $this->article->title, ['class' => 'form-control'], ['class' => 'form-group col-md-8 mb-2'], $this->errors); ?>
                <?= Form::select('Category', 'category_id', $this->article->category_id, $this->categoryOptions, ['class' => 'form-control'], ['class' => 'form-group col-md-2 mb-2'], $this->errors); ?>
                <?= Form::select('Status', 'status', $this->article->status, $this->statusOptions, ['class' => 'form-control'], ['class' => 'form-group col-md-2 mb-2'], $this->errors); ?>
                <?= Form::textarea('Body', 'body', html_entity_decode($this->article->body), ['class' => 'form-control', 'rows' => '15'], ['class' => 'form-group col-md-12 mb-2'], $this->errors); ?>
				<?= Form::file('Cover image', 'cover_image', ['class' => 'form-control'], ['class' => 'form-group col-md-12 mb-2'], $this->errors); ?>
            </div>
			
			<?php if ($this->hasImage) : ?>
				<div class="d-flex align-items-center">
					<label>Image</label>&nbsp;&nbsp;
					<img src="<?= ROOT . $this->article->cover_image ?>" alt="" style="height:100px;object-fit: cover;">
				</div>
			<?php endif; ?>

            <div class="mt-3 mb-5">
                <input class="btn btn-primary" type="submit" value="Save">
                <a href="<?= ROOT ?>admin/articles" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $this->end(); ?>