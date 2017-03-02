<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

$product = $Products->getBySlug($_GET['slug']);
$dirt = $Products->getDirt($product->dirt_id)->name;

if(isset($_POST['addToCart'])){
    if(empty($Products->get("", $product->id))){
        $errors[] = "Produktet eksisterer ikke!";
    }
    if(empty($errors)){
        $Cart->add(session_id(), $product->id, $_POST['qty']);
        Alert::setAlert('success', array("Produktet er nu tilføjet til din kurv!"));
    }else{
        Alert::setAlert('danger', $errors);
    }
}
include_once $_SERVER['DOCUMENT_ROOT'].'/header.php';
?>
<h1 class="title">Butikken</h1>
<div class="padding-left-5 single-product">
    <h1><?php echo $product->name; ?></h1>

    <div class="images">
        <?php
        if(!empty($product->image_1)){
            $getImage_1 = $Gallery->getImage($product->image_1);
            echo "<div class=\"col-4 no-height\">\n";
            echo "    <img src=\"/images/uploads/thumb_{$getImage_1->path}\" class=\"col-11 no-height\">\n";
            echo "</div>\n";
        }
        if(!empty($product->image_2)){
            $getImage_2 = $Gallery->getImage($product->image_2);
            echo "<div class=\"col-4 no-height\">\n";
            echo "    <img src=\"/images/uploads/thumb_{$getImage_2->path}\" class=\"col-11 no-height\">\n";
            echo "</div>\n";
        }
        if(!empty($product->image_3)){
            $getImage_3 = $Gallery->getImage($product->image_3);
            echo "<div class=\"col-4 no-height\">\n";
            echo "    <img src=\"/images/uploads/thumb_{$getImage_3->path}\" class=\"col-11 no-height\">\n";
            echo "</div>\n";
        }
        ?>
        <div class="clear"></div>
    </div>


    <div class="description">
        <?php echo $product->description; ?>
    </div>


    <div class="col-8">
        <b>Jordtype:</b><br>
        <?php echo $dirt; ?><br>
        <b>Dyrkningstid:</b><br>
        <?php echo $product->culturing; ?><br>
        <b>Vare Nr.:</b><br>
        <?php echo $product->id; ?><br><br>
        <a href="#" onclick="window.history.back();">Tilbage</a>
    </div>
    <div class="col-4 addToCart no-height">
        <form method="post">
            <h1>Køb nu</h1>
            <div class="content">
                <p class="price">Pris: <?php echo $product->price; ?> kr.</p>
                <div class="qty"><span>Antal:</span><input class="form-control" name="qty" type="number" style="width:45px;height:20px;" min="0" value="0"></div>
                <input type="submit" value="Tilføj til kurv" class="form-control btn" name="addToCart">
            </div>
        </form>
    </div>


</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
