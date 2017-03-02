<?php
include $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(isset($_POST['claimed'])){
    $Order->claimed($_GET['order_id']);
    Alert::setAlert("success", array("Order status is set to \"Claimed\""));
    header("location:/admin/orders/list");
    exit();
}
if(isset($_POST['unclaimed'])){
    $Order->unclaimed($_GET['order_id']);
    Alert::setAlert("success", array("Order status is set to \"Unclaimed\""));
    header("location:/admin/orders/list");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'].'/admin/header.php';

$orders = $Order->get($_GET['order_id']);
$user = $Account->get($orders[0]->user_id);
if($orders[0]->status==0){
    $status="Unclaimed";
}elseif($orders[0]->status==1){
    $status="Claimed";
}
?>
<div class="content">
    <div class="header">
        <h1>Order</h1>
        <div class="clear"></div>
    </div>
    <h2>Information</h2>
    Order Date: <?php echo $orders[0]->time;?><br>
    User: <?php echo $user->surname;?> <?php echo $user->lastname;?><br>
    Status: <?php echo $status;?>

    <h2>Products</h2>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th style="width:14px;" class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($orders as $order) {
                $product = $Products->get("", $order->product_id);
                echo "<tr>\n";
                echo "<td>{$product->name}</td>\n";
                echo "<td>{$order->qty}</td>\n";
                echo "<td>{$order->price}</td>\n";
                echo "<td class=\"text-right\">\n";
                echo "    <a href=\"order/{$order_id}\" target=\"_blank\" class=\"btn btn-default float-left\"><i class=\"fa fa-eye\"></i></a>\n";
                echo "</td>\n";
                echo "</tr>\n";
            }
            ?>
        </tbody>
    </table>
    <form method="post">
        <div class="form-group">
            <?php
            if($status=="Claimed"){
                echo "<input value=\"Status: Unclaimed\" name=\"unclaimed\" type=\"submit\" class=\"btn btn-success\">\n";
            }else{
                echo "<input value=\"Status: Claimed\" name=\"claimed\" type=\"submit\" class=\"btn btn-success\">\n";
            }
            ?>
        </div>
    </form>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/footer.php';
?>
