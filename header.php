<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($Account->login($username, $password)){
        Alert::setAlert("success", array("Du er nu logget ind!"));
        header("refresh:0");
        exit();
    }else{
        Alert::setAlert("danger", array("Forkert brugernavn eller kodeord!"));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Planteskole</title>
    <!-- Responsive Meta Tag -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="/js/jquery.min.js"></script>
    <!-- main stylesheet -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <div class="container logo-image">
        <img class="cover" src="/images/cover.png">
    </div>
    <header class="container page-header">
        <nav class="navigation">
            <ul>


                <?php
                foreach ($Navigation->getNav(1) as $item) {
                    $sub_items=$Navigation->getNav(1, $item->id);
                    $class="";
                    if(!empty($sub_items)){ $class="dropdown"; }
                    echo "<li class=\"$class\"><a href=\"{$item->url}\">{$item->name}</a>\n";
                    if(!empty($sub_items)){
                        echo "<ul class=\"dropdown-content\">\n";
                        foreach ($sub_items as $sub_item) {
                            echo "    <li><a href=\"{$sub_item->url}\">{$sub_item->name}</a></li>\n";
                        }

                        echo "</ul>\n";
                    }
                    echo "</li>\n";
                }
                ?>
            </ul>
            <div class="clear"></div>
        </nav>
    </header>


    <main class="container">
        <div class="col-3">
            <div class="widget list">
                <h1 class="title">Mest populære</h1>
                <div class="padding-left-5">
                    <ul>
                        <?php
                        $getPopular = $Products->getByPopular(3);
                        if(empty($getPopular)){
                            echo "<li>Ingen populærer produkter</li>\n";
                        }else{
                            foreach ($getPopular as $popular) {
                                $product = $Products->get("", $popular->product_id);
                                echo "<li><a href=\"{$product->slug}\">{$product->name}</a></li>\n";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-content col-6">
            <div class="col-11 center">
