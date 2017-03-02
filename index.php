<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/header.php';
$homepage = $Pages->getBySlug('1-forside');
?>
<h1 class="title"><?php echo $homepage->title; ?></h1>
<div class="padding-left-5">
    <?php
    echo $homepage->content;
    ?>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
