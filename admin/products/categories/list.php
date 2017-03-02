<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(isset($_POST['add'])){
    $name = $_POST['name'];

    if(empty($name)){
        $errors[] = "You have to give it a name!";
    }

    if(empty($errors)){
        $getLast=$Products->getLastCat()->id+1;
        $slug = Basics::slugify($getLast.'-'.$name);
        // IT'S EMPTY
        Alert::setAlert('success', array("The category is added!"));
        $Products->addCategory($slug, $name);
        header("location:/admin/products/categories");
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
        <h1>Product Categories</h1>
        <div class="clear"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
            <h3>Add Category</h3>
            <form method="post">
                <div class="form-group">
                    <label for="form-name">Name</label>
                    <input id="form-name" class="form-control" name="name" type="text">
                </div>
                <div class="form-group">
                    <input type="submit" name="add" class="btn btn-success" value="Add">
                </div>
            </form>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-6">
            <h3>Category List</h3>
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Products</th>
                        <th style="width:148px;" class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($Products->getCategories() as $category) {
                        $count = count($Products->getByCat($category->id));
                        echo "<tr>\n";
                        echo "<td>{$category->name}</td>\n";
                        echo "<td>{$count}</td>\n";
                        echo "<td class=\"text-right\">\n";
                        echo "    <a href=\"/category/{$category->slug}\" target=\"_blank\" class=\"btn btn-default float-left\"><i class=\"fa fa-eye\"></i></a>\n";
                        echo "    <a href=\"delete/{$category->id}\" class=\"btn btn-danger float-left\"><i class=\"fa fa-trash\"></i></a>\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/footer.php';
?>
