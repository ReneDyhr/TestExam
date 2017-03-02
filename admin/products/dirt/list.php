<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(isset($_POST['add'])){
    $name = $_POST['name'];

    if(empty($name)){
        $errors[] = "You have to give it a name!";
    }

    if(empty($errors)){
        // IT'S EMPTY
        Alert::setAlert('success', array("The dirt type is added!"));
        $Products->addDirt($name);
        header("location:/admin/products/dirt");
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
        <h1>Dirt Types</h1>
        <div class="clear"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
            <h3>Add Dirt Type</h3>
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
            <h3>Dirt Type List</h3>
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th style="width:148px;" class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($Products->getDirt() as $dirt) {
                        echo "<tr>\n";
                        echo "<td>{$dirt->name}</td>\n";
                        echo "<td class=\"text-right\">\n";
                        echo "    <a href=\"delete/{$dirt->id}\" class=\"btn btn-danger float-left\"><i class=\"fa fa-trash\"></i></a>\n";
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
