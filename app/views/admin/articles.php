<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('content'); ?>

	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2"><?= $this->getSiteTitle() ?></h1>
		<a href="<?= ROOT ?>admin/article/new" class="btn btn-sm btn-success">&plus;&nbsp;Add article</a>
	</div>

	<?php if(count($this->articles) > 0): ?>
		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th scope="col">Title</th>
						<th scope="col">Created at</th>
						<th scope="col">Status</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($this->articles as $article) : ?>
					<tr>
						<td><?= $article->title ?></td>
						<td><?= date("M j, Y @g:i a", strtotime($article->created_at)) ?></td>
						<td><?= $article->status ?></td>
						<td style="text-align: right;">
							<a href="<?= ROOT ?>admin/article/<?= $article->id ?>" class="btn btn-sm btn-info">Edit</a>
							<button class="btn btn-sm btn-danger" onclick="confirmAction('<?= $article->id ?>')">Delete</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		
			<?php $this->section('admin/sections/pagination'); ?>
		
		</div>
	<?php endif; ?>
	
	<script>
		function confirmAction(articleId) {
			if (window.confirm("Are you sure for this action?")) {
				window.location.href = `<?= ROOT ?>admin/deleteArticle/${articleId}`;
			}
		}
	</script>

<?php $this->end(); ?>