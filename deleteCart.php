<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

$Cart->delete(session_id(), $_GET['product_id']);
Alert::setAlert("success", array("Produktet er nu fjernet!"));
header("location:/cart");
