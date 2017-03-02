<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(isset($_POST['updateCart'])){
    foreach ($_POST['cart'] as $product_id => $data) {
        if($data['check']){
            if(empty($Products->get("", $product_id))){
                $errors[] = "Produktet eksisterer ikke!";
            }
            if(empty($errors)){
                $Cart->add(session_id(), $product_id, $data['qty']);
                Alert::setAlert('success', array("Produkterne er nu tilføjet til din kurv!"));
            }else{
                Alert::setAlert('danger', $errors);
            }
        }
    }
}

include_once $_SERVER['DOCUMENT_ROOT'].'/header.php';

$getCat = $Products->getCatBySlug($_GET['slug']);
?>
<h1 class="title"><?php echo $getCat->name;?></h1>
<div class="padding-left-5">
    <form method="post">
        <table>
            <thead>
                <tr>
                    <th>Tilføj</th>
                    <th>Stk</th>
                    <th>Produkt navn</th>
                    <th>Pris</th>
                    <th>mere info</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($Products->getByCat($getCat->id) as $product) {
                    $style="";
                    $soldout="";
                    if($product->inventory<=$product->min_inventory AND $product->inventory!=-1){
                        $style="style=\"color:#CBCBCB;\"";
                        $soldout="(udsolgt)";
                    }
                    echo "<tr>\n";
                    echo "    <td><input name=\"cart[{$product->id}][check]\" type=\"checkbox\" value=\"1\"></td>\n";
                    echo "    <td><input name=\"cart[{$product->id}][qty]\" type=\"number\" min=\"0\" value=\"1\" class=\"form-control\" style=\"width:45px;\"></td>\n";
                    echo "    <td $style>{$product->name}$soldout</td>\n";
                    echo "    <td class=\"price\">{$product->price},-</td>\n";
                    echo "    <td><a href=\"/product/{$product->slug}\">mere info</a></td>\n";
                    echo "</tr>\n";
                }
                ?>
            </tbody>
        </table>

        <input type="submit" name="updateCart" value="Opdater Kurv" style="margin-top:20px;" class="btn form-control">
    </form>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
