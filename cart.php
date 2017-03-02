<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
$cart = $Cart->get(session_id());

if(isset($_POST['order']) AND $loggedIn){
    $products = array();
    foreach ($cart as $product) {
        $getProduct = $Products->get("", $product->product_id);
        $products[] = array("product_id"=>$product->product_id, "qty"=>$product->qty, "price"=>$getProduct->price);
    }
    $Order->place($products, $user_id);
    Alert::setAlert("success", array("Tak for din bestilling!", "Dine varer er nu lagt til side og kan hentes i butikken"));
    $Order->clear(session_id());
    header("refresh:0;");
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'].'/header.php';


?>
<h1 class="title">Kassen</h1>
<div class="padding-left-5">
    <form method="post">
        <table>
            <thead>
                <tr>
                    <th>Stk</th>
                    <th>Produkt</th>
                    <th>Pr. stk.</th>
                    <th>I alt</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($cart as $product) {
                    $getProduct = $Products->get("", $product->product_id);
                    $price = $getProduct->price*$product->qty;
                    $total += $price;
                    $style="";
                    $soldout="";
                    if($getProduct->inventory<=$getProduct->min_inventory AND $getProduct->inventory!=-1){
                        $style="style=\"color:#CBCBCB;\"";
                        $soldout="(udsolgt)";
                    }
                    echo "<tr>\n";
                    echo "    <td>{$product->qty}</td>\n";
                    echo "    <td $style>{$getProduct->name}$soldout</td>\n";
                    echo "    <td class=\"price\">{$getProduct->price},-</td>\n";
                    echo "    <td class=\"price\">{$price},-</td>\n";
                    echo "    <td><a href=\"/cart/{$getProduct->id}\">slet</a></td>\n";
                    echo "</tr>\n";
                }
                ?>
            </tbody>
        </table>
        <table style="border:1px solid #EDEEE3;">
            <tr>
                <td><b>Samlet pris:</b></td>
                <td class="price"><b><?php echo $total;?> Kr.</b></td>
            </tr>
        </table>


        <?php if($loggedIn){ ?><input type="submit" name="order" value="Bestil" style="margin-top:20px;" class="btn form-control"><?php }else{ ?><input type="button" value="Login for at fortsætte" style="margin-top:20px;" class="btn form-control"><?php } ?>
    </form>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
