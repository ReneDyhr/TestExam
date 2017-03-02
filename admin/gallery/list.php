<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

ini_set('memory_limit', '-1');

$dir_pics = $_SERVER['DOCUMENT_ROOT'].'/images/uploads/';

if(isset($_POST['add_cat'])){
    $name = $_POST['name'];

    if(empty($name)){
        $errors[] = "You have to give it a name!";
    }

    if(empty($errors)){
        // IT'S EMPTY
        Alert::setAlert('success', array("The category is now added!"));
        $Gallery->addCategory($name);
        header("location:/admin/gallery/list");
        exit();
    }else{
        // IT'S NOT EMPTY
        Alert::setAlert('danger', $errors);
    }
}


if(isset($_POST['save'])){
    $image_id = $_GET['item'];
    $name = $_POST['name'];
    $category_id = $_POST['category'];
    $degrees = $_POST['degrees'];

    if(empty($name)){
        $errors[] = "The image doesn\'t have a name!";
    }

    if(empty($Gallery->getCategories($category_id))){
        $errors[] = "The category doesn\'t exist!";
    }

    if(empty($errors)){
        $image = $Gallery->getImages($image_id);
        if($degrees!=0){
            $Gallery->rotateImage($degrees, $dir_pics.'thumb_'.$image->path);
            $Gallery->rotateImage($degrees, $dir_pics.'org_'.$image->path);
        }
        $Gallery->update($image_id, $category_id, $name);
        Alert::setAlert('success', array("The image is now updated!"));
        header("location:/admin/gallery/list");
        exit();
    }else{
        Alert::setAlert('danger', $errors);
    }
}


if(isset($_POST['delete'])){
    $image_id = $_GET['item'];

    $image = $Gallery->getImage($image_id);

    if(empty($errors)){

        unlink($dir_pics."org_".$image->path);
        unlink($dir_pics."thumb_".$image->path);

        $Gallery->delete($image_id);
        Alert::setAlert('success', array("The image is now deleted!"));
        header("location:/admin/gallery/list");
        exit();
    }else{
        Alert::setAlert('danger', $errors);
    }
}


if(isset($_POST['upload'])){

    $name = $_POST['name'];
    $category_id = $_POST['category'];

    $mime = mime_content_type($_FILES['file']['tmp_name']);

    $time = time();
    $Upload = new Upload($_FILES['file']);
    $Upload->setMaxSize(32, "MB");
    $Upload->AllowedTypes(array("image/png", "image/jpeg"));

    $Upload->setPrefix("org_".$time."_");
    $Upload->setPath($dir_pics);
    $Upload->Render();

    $Upload->setPrefix("thumb_".$time."_");
    $Upload->setPath($dir_pics);
    $Upload->setWidth(120);
    $Upload->setHeight(90);
    $path = $Upload->Render();

    $path = substr($path, 6);

    $Upload->Clean();

    foreach ($Upload->errors() as $error) {
        $errors[] = $error;
    }

    if(empty($name)){
        $errors[] = "The image doesn\'t have a name!";
    }

    if(empty($Gallery->getCategories($category_id))){
        $errors[] = "The category doesn\'t exist!";
    }


    if(empty($errors)){
        $Gallery->add($category_id, $name, $path, $mime);
        Alert::setAlert('success', array("The image is now uploaded!"));
        header("location:/admin/gallery/list");
        exit();
    }else{
        unlink($dir_pics."org_".$path);
        unlink($dir_pics."thumb_".$path);
        Alert::setAlert('danger', $errors);
    }

}


include $_SERVER['DOCUMENT_ROOT'].'/admin/header.php';

?>
<div class="content">
    <div class="header">
        <h1>Gallery</h1>
        <div class="clear"></div>
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#manager" aria-controls="manager" role="tab" data-toggle="tab">File Manager</a></li>
        <li role="presentation"><a href="#upload" aria-controls="upload" role="tab" data-toggle="tab">Upload</a></li>
        <li role="presentation"><a href="#categories" aria-controls="categories" role="tab" data-toggle="tab">Categories</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="manager">
            <div id="file-manager"></div>

            <script>
            $.get('/admin/gallery/loader.php', function(data) {
                $('#file-manager').html(data);
            });
            </script>

        </div>
        <div role="tabpanel" class="tab-pane" id="upload">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control">
                        <?php
                        foreach ($Gallery->getCategories() as $category) {
                            echo "<option value=\"{$category->id}\">{$category->name}</option>\n";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Files</label>
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="form-group">
                    <input class="btn btn-success" type="submit" name="upload" value="Upload">
                </div>
            </form>
        </div>
        <div role="tabpanel" class="tab-pane" id="categories">


            <div class="col-lg-4 col-md-6 col-sm-6">
                <h3>Add Category</h3>
                <form method="post">
                    <div class="form-group">
                        <label for="form-name">Name</label>
                        <input id="form-name" class="form-control" name="name" type="text">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="add_cat" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-6">
                <h3>List</h3>
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Images</th>
                            <th style="width:10px;" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($Gallery->getCategories() as $category) {
                            $images = count($Gallery->getImages($category->id));
                            echo "<tr>\n";
                            echo "<td>{$category->name}</td>\n";
                            echo "<td>{$images}</td>\n";
                            echo "<td class=\"text-right\">\n";
                            echo "    <a href=\"categories/delete/{$category->id}\" class=\"btn btn-danger float-left\"><i class=\"fa fa-trash\"></i></a>\n";
                            echo "</td>\n";
                            echo "</tr>\n";
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>






    </div>
</div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<script>
function rotate(image_id, degrees){
    $("#image").html('<img src="getImage.php?image_id=' + image_id + '&degrees=' + degrees + '">');
    $('#form-degrees').val(degrees);
}
function selectImage(e){
    var item_id = $(e).attr('data-id');
    $.get('/admin/gallery/loader.php?item=' + item_id, function(html){
        $('#modal .modal-content').html(html);
        $('#modal').modal('show');
    });
    window.history.pushState("", "", 'list?item=' + item_id);
}

$('#modal').on('hidden.bs.modal', function () {
    window.history.pushState("", "", 'list');
    // $('#modal .modal-content').html('');
})

</script>

<?php if(isset($_GET['item'])){
    echo "<script>\n";
    echo "$( document ).ready(function() {\n";
        echo "\n";
        echo "        $('#modal').modal({\n";
            echo "            show: true,\n";
            echo "            remote: 'loader.php?item={$_GET['item']}'\n";
            echo "        });\n";
            echo "});\n";
            echo "</script>\n";
        }

        include $_SERVER['DOCUMENT_ROOT'].'/admin/footer.php';
        ?>
