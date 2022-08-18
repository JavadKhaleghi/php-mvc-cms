<?php use Core\Session; ?>

<div class="site-section-cover overlay" style="background-image: url('<?= ROOT ?>app/public/site/images/hero_bg.jpg');">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-10 text-center">
                <h1>The <strong>PHP</strong> power like a <strong>Framewrok</strong></h1>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">

        <?= Session::displaySessionAlerts(); ?>

        <div class="row">
            <div class="col">
                <div class="heading mb-4">
                    <span class="caption">Blog categories</span>
                    <h2>Choose Category</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-stretch">
			<?php foreach($this->categories as $category) : ?>
            <div class="col-lg-2">
                <a href="<?= ROOT ?>articles/category/<?= $category->id ?? 0 ?>" class="course">
                    <h3 class="text text-secondary"><?= $category->name ?></h3>
                </a>
            </div>
			<?php endforeach; ?>
        </div>
    </div>
</div>

<div class="site-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading mb-4">
                    <span class="caption">Latest</span>
                    <h2>Blog Articles</h2>
                </div>
            </div>
            <div class="col-lg-8">
				<?php foreach ($this->articles as $article) : ?>
                <div class="d-flex tutorial-item mb-4">
                    <div class="img-wrap">
                        <a href="<?= ROOT ?>articles/show/<?= $article->id ?>"><img src="<?= ROOT . $article->cover_image ?>" alt="Image" class="img-fluid"></a>
                    </div>
                    <div>
                        <h3><a href="<?= ROOT ?>articles/show/<?= $article->id ?>"><?= $article->title ?></a></h3>

                        <p class="mb-0">
                            <span class="brand-react h5"></span>
                            <span class="brand-javascript h5"></span>
                        </p>
                        <p class="meta">
                            <span class="mr-2 mb-2">Author:&nbsp;<a href="<?= ROOT ?>articles/author/<?= $article->user_id ?>"><?= $article->first_name . ' ' . $article->last_name ?></a></span>
                            <span class="mr-2 mb-2">In:&nbsp;<a href="<?= ROOT ?>articles/category/<?= $article->category_id ?? 0 ?>">[<?= $article->category ?? 'Uncategorized' ?>]</a></span>
                        </p>

                        <p><a href="<?= ROOT ?>articles/show/<?= $article->id ?>" class="btn btn-primary custom-btn">View more...</a></p>
                    </div>
                </div>
				<?php endforeach; ?>
            </div>
			
            <div class="col-lg-4">
                <div class="box-side mb-3">
                    <a href="#"><img src="<?= ROOT ?>app/public/site/images/img_1_horizontal.jpg" alt="Image" class="img-fluid"></a>
                    <h3><a href="#">Learning React Native</a></h3>
                </div>
                <div class="box-side mb-3">
                    <a href="#"><img src="<?= ROOT ?>app/public/site/images/img_2_horizontal.jpg" alt="Image" class="img-fluid"></a>
                    <h3><a href="#">Learning React Native</a></h3>
                </div>
                <div class="box-side">
                    <a href="#"><img src="<?= ROOT ?>app/public/site/images/img_3_horizontal.jpg" alt="Image" class="img-fluid"></a>
                    <h3><a href="#">Learning React Native</a></h3>
                </div>
            </div>
        </div>
    </div>
</div>