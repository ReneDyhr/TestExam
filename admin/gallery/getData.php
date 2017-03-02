<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

$image_id = $_GET['image_id'];

$image = $Gallery->getImage($image_id);

echo json_encode($image);
