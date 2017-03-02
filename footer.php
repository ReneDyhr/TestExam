</div>
</div>
<div class="col-3">
    <div class="widget cart">
        <h1 class="title">Indkøbskurv</h1>
        <div class="padding-left-5">
            <table>
                <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Pris</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getCart = $Cart->get(session_id());
                    if(empty($getCart)){
                        echo "<tr><td>Din kurv er tom.</td><td></td></tr>";
                    }else{
                        foreach ($getCart as $cart) {
                            $cartProduct = $Products->get("", $cart->product_id);
                            $price = $cartProduct->price*$cart->qty;
                            echo "<tr><td>{$cartProduct->name}</td><td class=\"price\">$price,-</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            <footer>
                <a href="/cart">Til kassen</a>
            </footer>
        </div>
    </div>

    <div class="widget">
        <?php
        if(!$loggedIn){
            ?>
            <h1 class="title">Kunde login</h1>
            <div class="padding-left-5">
                <form method="post">
                    <div class="form-group">
                        <label>Brugernavn</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kodeord</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="Login" class="btn form-control">
                    </div>
                </form>
                <a href="/create-account.php">Opret kunde</a>
            </div>
            <?php
        }else{
            ?>
            <h1 class="title">Velkommen <?php echo $AccountInfo->surname; ?></h1>
            <div class="padding-left-5 list">
                <ul>
                    <li><a href="/settings">Indstillinger</a></li>
                    <?php if($AccountInfo->status==2){ ?><li><a href="/admin">Administration</a></li><?php } ?>
                    <li><a href="/logout">Log ud</a></li>
                </ul>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="clear"></div>
</main>


<footer class="container page-footer">
    Mettes planteskole &middot; Industrivej 132 &middot; 4000 roskilde
</footer>
<?php
echo Alert::printAlerts();
?>
</body>
</html>
