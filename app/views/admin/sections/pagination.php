<?php

use Core\Request;

$request = new Request();
$page = $request->get('page');

if(! $page || $page < 1) {
    $page = 1;
}

$limit = $request->get('limit') ? $request->get('limit') : 15;
$total = ceil($this->total / $limit); 
$backButton = $page > 1;
$forwardButton = $page < $total;

?>

<form action="" method="GET" id="paginationForm">
    <div class="d-flex justify-content-center align-items-center my-5">
        <input type="hidden" id="page" name="page" value="<?= $page ?>">
        <input type="hidden" id="limit" name="limit" value="<?= $limit ?>">
        <button class="btn btn-sm btn-dark" <?= $backButton ? "" : "disabled" ?> onclick="pagination(<?= $page - 1 ?>)"><</button>
        <div class="mx-3"><?= $page ?> of <?= $total ?></div>
        <button class="btn btn-sm btn-dark" <?= $forwardButton ? "" : "disabled" ?> onclick="pagination(<?= $page + 1 ?>)">></button>
    </div>
</form>

<script>
    function pagination(page) {
        document.getElementById('page').value = page;
        let form = document.getElementById('paginationForm');
        form.submit();
    }
</script>