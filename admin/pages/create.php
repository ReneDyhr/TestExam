<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(isset($_POST['create'])){
    $title = $_POST['title'];

    $status = $_POST['status'];

    $description = $_POST['description'];

    if(empty($title)){
        $errors[] = "You have to type in a title";
    }

    if(empty($description)){
        $errors[] = "You have to type in a description";
    }

    if(empty($errors)){

        $getLast=$Pages->getLast()->id+1;
        $slug = Basics::slugify($getLast.'-'.$title);
        // IT'S EMPTY
        Alert::setAlert('success', array("Your page is now created!"));
        $Pages->create($user_id, $slug, $title, $description, $status);
        header("location:/admin/pages/list");
        exit();
    }else{
        // IT'S NOT EMPTY
        Alert::setAlert('danger', $errors);
    }

}
include $_SERVER['DOCUMENT_ROOT'].'/admin/header.php';
?>
<div class="content">
    <div class="header">
        <h1>Create Page</h1>
        <div class="clear"></div>
    </div>
    <form method="post">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="form-title">Title *</label>
                    <input id="form-title" class="form-control" name="title" type="text">
                </div>
                <div class="form-group">
                    <label for="form-status">Status *</label>
                    <select id="form-status" class="form-control" name="status">
                        <<option value="0">Public</option>
                        <<option value="1">Draft</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="form-description">Description *</label>
                    <textarea id="form-description" class="ckeditor" name="description" class="form-control" rows="22" style="resize:none;"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <input type="submit" name="create" class="btn btn-success form-control" value="Create">
                </div>
            </div>
        </div>
    </form>
</div>
<script src="/editor/ckeditor.js"></script>
<script src="/editor/init.js"></script>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/footer.php';
?>
