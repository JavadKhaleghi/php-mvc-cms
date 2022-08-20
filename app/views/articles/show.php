<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('content'); ?>
	
	<div class="site-section-cover overlay" style="background-image: url('<?= ROOT ?>app/public/site/images/hero_bg.jpg');">
		
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-lg-10 text-center">
					<h1>
						<strong><?= html_entity_decode($this->getSiteTitle()) ?></strong>
					</h1>
					<div class="pb-4 get">
						<strong class="text-white">Posted on May 22, 2020 &bullet; By
							<a href="<?= ROOT ?>articles/author/<?= $this->article->user_id ?>" style="color: #fff"><?= $this->article->first_name . ' ' . $this->article->last_name ?></a></strong>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="site-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 blog-content">
					<p class="lead"><?= html_entity_decode($this->article->body) ?></p>
					
					<div class="pt-5">
						<p>Category:
							<a href="<?= ROOT ?>articles/category/<?= $this->article->category_id ?>"><?= $this->article->category ?? 'Uncategorized' ?></a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php $this->end(); ?>