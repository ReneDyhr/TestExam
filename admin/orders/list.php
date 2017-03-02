<?php
include $_SERVER['DOCUMENT_ROOT'].'/admin/header.php';

?>
<div class="content">
    <div class="header">
        <h1>Orders</h1>
        <div class="clear"></div>
    </div>
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Products</th>
                <th>Total Price</th>
                <th>Status</th>
                <th style="width:14px;" class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($Order->get() as $order_id => $products) {
                $total = 0;
                foreach ($products as $product) {
                    $user_id = $product['user_id'];
                    $total += $product['price']*$product['qty'];
                }
                if($product['status']==0){
                    $status="Unclaimed";
                }elseif($product['status']==1){
                    $status="Claimed";
                }
                $getUser = $Account->get($user_id);
                $count = count($products);
                echo "<tr>\n";
                echo "<td>{$order_id}</td>\n";
                echo "<td>{$getUser->surname} {$getUser->lastname}</td>\n";
                echo "<td>{$count}</td>\n";
                echo "<td>{$total}</td>\n";
                echo "<td>{$status}</td>\n";
                echo "<td class=\"text-right\">\n";
                echo "    <a href=\"order/{$order_id}\" class=\"btn btn-default float-left\"><i class=\"fa fa-eye\"></i></a>\n";
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
