<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/header.php';
$page = $Pages->getBySlug($_GET['slug']);
?>
<h1 class="title"><?php echo $page->title; ?></h1>
<div class="padding-left-5">
    <?php
    echo $page->content;


    if($page->id==2){
        ?>
        <div class="col-6">
            <h1>Kontakt formular</h1>
            <form method="post">
                <div class="form-group">
                    <label>Navn</label>
                    <input class="form-control" name="name" type="text">
                </div>
                <div class="form-group">
                    <label>Emne</label>
                    <input class="form-control" name="subject" type="text">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" name="email" type="email">
                </div>
                <div class="form-group">
                    <label>Besked</label>
                    <textarea class="form-control" rows="6" name="message"></textarea>
                </div>
                <div class="form-group">
                    <input class="form-control btn" name="send" value="Send" type="submit">
                </div>
            </form>
        </div>
        <?php
    }
    ?>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
