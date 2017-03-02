<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/header.php';

?>
<div class="content">
    <div class="header">
        <h1>Products</h1>
        <div class="header-btn">
            <a href="create" class="btn btn-success">Create</a>
            <a href="categories" class="btn btn-primary">Categories</a>
            <a href="dirt" class="btn btn-primary">Dirt Types</a>
        </div>
        <div class="clear"></div>
    </div>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Inventory / Min / Max</th>
                <th>Price</th>
                <th style="width:148px;" class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($Products->get(0, 0, true) as $product) {
                if($product->inventory==-1){
                    $inventory = "Unlimited";
                }else{
                    $inventory = $product->inventory . " / ".$product->min_inventory." / ".$product->max_inventory;
                }
                echo "<tr>\n";
                echo "<td>{$product->id}</td>\n";
                echo "<td>{$product->name}</td>\n";
                echo "<td>{$inventory}</td>\n";
                echo "<td>{$product->price}</td>\n";
                echo "<td class=\"text-right\">\n";
                echo "    <a href=\"/product/{$product->slug}\" target=\"_blank\" class=\"btn btn-default float-left\"><i class=\"fa fa-eye\"></i></a>\n";
                echo "    <a href=\"edit/{$product->id}\" class=\"btn btn-primary float-left\"><i class=\"fa fa-edit\"></i></a>\n";
                echo "    <a href=\"delete/{$product->id}\" class=\"btn btn-danger float-left\"><i class=\"fa fa-trash\"></i></a>\n";
                echo "</td>\n";
                echo "</tr>\n";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/footer.php';
?>
