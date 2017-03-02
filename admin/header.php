<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
if($loggedIn){
    $AccountInfo = $Account->get($user_id);
    if($AccountInfo->status != 2){
        header("location:/");
        exit();
    }
}else{
    header("location:/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Planteskole</title>

    <!-- Responsive Meta Tag -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/admin/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="/admin/css/style.css">
    <script src="/js/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/admin/js/jquery.nestable.js"></script>

</head>
<body>
    <div id="mySidenav" class="sidenav">
        <ul>
            <li><a href="/admin/">Dashboard</a></li>
            <li><a href="/admin/gallery/list">Gallery</a></li>
            <li><a href="/admin/users/list">Users</a></li>
            <li><a href="/admin/products/list">Products</a></li>
            <li><a href="/admin/orders/list">Orders</a></li>
            <li><a href="/admin/pages/list">Pages</a></li>
            <li><a href="/admin/menu/list">Menu</a></li>
        </ul>
    </div>
    <div id="main">
        <div class="menu">
            <a href="javascript:void(0)" id="closenav" style="display:none;" onclick="closeNav()"><i class="fa fa-bars"></i></a>
            <a href="javascript:void(0)" id="opennav" onclick="openNav()"><i class="fa fa-bars"></i></a>
        </div>
