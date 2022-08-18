<?php $this->start('head'); ?>
	<style>
		.thumbnail-link img {
			height: 250px;
			object-fit: cover;
		}
	</style>
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

<div class="site-section bg-light">
    <div class="container">
        <div class="row">
			<?php foreach($this->articles as $article) : ?>
				<div class="col-lg-4 col-md-6 mb-4">
					<div class="post-entry-1 h-100">
						<a href="<?= ROOT ?>articles/show/<?= $article->id ?>" class="thumbnail-link">
							<img src="<?= ROOT . $article->cover_image ?>" alt="Image" class="img-fluid">
						</a>
						<div class="post-entry-1-contents">
							<h2><a href="<?= ROOT ?>articles/show/<?= $article->id ?>"><?= $article->title ?></a></h2>
							<span class="meta d-inline-block mb-3"><a href="<?= ROOT ?>articles/author/<?= $article->user_id ?>"><?= $article->first_name . ' ' . $article->last_name ?></a>&nbsp;<span class="mx-2">in</span>[<a href="<?= ROOT ?>articles/category/<?= $article->category_id ?? 0 ?>"><?= $article->category ?? 'Uncategorized' ?></a>]</span>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
        </div>

        <div class="row">
            <div class="col-5">
                <div class="custom-pagination">
					<?php $this->section('admin/sections/pagination'); ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $this->end(); ?>