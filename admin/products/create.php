<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(isset($_POST['create'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $status = $_POST['status'];
    $category = $_POST['category'];

    $inventory = $_POST['inventory'];
    $minInventory = $_POST['minInventory'];
    $maxInventory = $_POST['maxInventory'];

    $image_1 = $_POST['image_id_1'];
    $image_2 = $_POST['image_id_2'];
    $image_3 = $_POST['image_id_3'];

    $culturing = $_POST['culturing'];
    $dirttype = (int)$_POST['dirttype'];

    $price = (float)$_POST['price'];

    $description = $_POST['description'];

    if(empty($title)){
        $errors[] = "You have to type in a title!";
    }

    if(empty($Products->getCategories($category))){
        $errors[] = "This category doesn\'t exist!";
    }

    if(empty($Products->getDirt($dirttype))){
        $errors[] = "This dirt type doesn\'t exist!";
    }

    if(empty($inventory) AND strlen($inventory)==0){
        $errors[] = "You have to enter your inventory!";
    }

    if(!Basics::validateFloat($inventory)){
        $errors[] = "You have to enter a valid inventory!";
    }

    if(empty($culturing)){
        $errors[] = "You have to enter the culturing!";
    }

    if(empty($price)){
        $errors[] = "You have to enter the price!";
    }
    if(!Basics::validateFloat($price)){
        $errors[] = "You have to enter a valid price!";
    }

    if(empty($description)){
        $errors[] = "You have to type in a description!";
    }

    if(empty($errors)){
        $getLast=$Products->getLast()->id+1;
        $slug = Basics::slugify($getLast.'-'.$title);
        // IT'S EMPTY
        Alert::setAlert('success', array("Your products is now created!"));
        $Products->create($id, $user_id, $slug, $title, $category, $inventory, $minInventory, $maxInventory, $image_1, $image_2, $image_3, $culturing, $dirttype, $price, $description, $status);
        header("location:/admin/products/list");
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
        <h1>Create Product</h1>
        <div class="clear"></div>
    </div>
    <form method="post">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="form-title">ID *</label>
                    <input id="form-title" min="0" class="form-control" name="id" type="number">
                </div>
                <div class="form-group">
                    <label for="form-title">Title *</label>
                    <input id="form-title" class="form-control" name="title" type="text">
                </div>
                <div class="form-group">
                    <label for="form-status">Status *</label>
                    <select id="form-status" class="form-control" name="status">
                        <option value="0">Public</option>
                        <option value="1">Draft</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="form-status">Kategori *</label>
                    <select id="form-status" class="form-control" name="category">
                        <?php
                        foreach ($Products->getCategories() as $category) {
                            echo "<option value=\"{$category->id}\">{$category->name}</option>\n";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="form-title">Inventory * (enter -1 for unlimited)</label>
                    <input id="form-title" class="form-control" value="0" name="inventory" type="number">
                </div>
                <div class="form-group">
                    <label for="form-title">Min Inventory</label>
                    <input id="form-title" class="form-control" value="0" name="minInventory" type="number">
                </div>
                <div class="form-group">
                    <label for="form-title">Max Inventory</label>
                    <input id="form-title" class="form-control" value="0" name="maxInventory" type="number">
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label for="form-category">Image 1 - <a href="#" data-toggle="modal" data-target="#image-1">Choose Thumbnail</a></label>
                    <input type="number" name="image_id_1" class="form-control" id="image-1-id" value="0" style="display:none;">
                    <input type="text" class="form-control" id="image-1-name" disabled value="">
                </div>
                <div class="form-group">
                    <label for="form-category">Image 2 - <a href="#" data-toggle="modal" data-target="#image-2">Choose Thumbnail</a></label>
                    <input type="number" name="image_id_2" class="form-control" id="image-2-id" value="0" style="display:none;">
                    <input type="text" class="form-control" id="image-2-name" disabled value="">
                </div>
                <div class="form-group">
                    <label for="form-category">Image 3 - <a href="#" data-toggle="modal" data-target="#image-3">Choose Thumbnail</a></label>
                    <input type="number" name="image_id_3" class="form-control" id="image-3-id" value="0" style="display:none;">
                    <input type="text" class="form-control" id="image-3-name" disabled value="">
                </div>
                <div class="form-group">
                    <label for="form-title">Culturing *</label>
                    <input id="form-title" class="form-control" name="culturing" type="text">
                </div>
                <div class="form-group">
                    <label for="form-status">Recommended Dirt type *</label>
                    <select id="form-status" class="form-control" name="dirttype">
                        <?php
                        foreach ($Products->getdirt() as $dirt) {
                            echo "<option value=\"{$dirt->id}\">{$dirt->name}</option>\n";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="form-title">Price *</label>
                    <input id="form-title" class="form-control" name="price" step="0.01" type="number">
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


<div class="modal fade" id="image-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thumbnail</h4>
            </div>
            <div class="modal-body">
                <div id="file-manager1"></div>
                <script>
                $.get('/admin/gallery/loader.php?extra_id=1', function(data) {
                    $('#file-manager1').html(data);
                });
                </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="deselect('image-1');">Deselect</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="image-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thumbnail</h4>
            </div>
            <div class="modal-body">
                <div id="file-manager2"></div>
                <script>
                $.get('/admin/gallery/loader.php?extra_id=2', function(data) {
                    $('#file-manager2').html(data);
                });
                </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="deselect('image-2');">Deselect</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="image-3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thumbnail</h4>
            </div>
            <div class="modal-body">
                <div id="file-manager3"></div>
                <script>
                $.get('/admin/gallery/loader.php?extra_id=3', function(data) {
                    $('#file-manager3').html(data);
                });
                </script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="deselect('image-3');">Deselect</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function deselect(id){
    $('#'+id+'-id').val(0);
    $('#'+id+'-name').val("");
}
function selectImage(element){
    var parent = ($(element).parent().parent().parent().parent().parent().parent().parent().parent().parent().attr('id'));
    var image_id = $(element).attr('data-id');
    $.get('/admin/gallery/getData.php?image_id='+image_id, function(data) {
        $('#'+parent+'-id').val(JSON.parse(data)['id']);
        $('#'+parent+'-name').val(JSON.parse(data)['name']);
    });
    $('#'+parent).modal('hide');
}
</script>


<script src="/editor/ckeditor.js"></script>
<script src="/editor/init.js"></script>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/footer.php';
?>
