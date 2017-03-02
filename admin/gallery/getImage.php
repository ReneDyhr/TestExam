<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

$image_id = $_GET['image_id'];

$image = $Gallery->getImage($image_id);

$path   = $_SERVER['DOCUMENT_ROOT'].'/images/uploads';
$file   = $image->path;
if(isset($_GET['degrees'])){
    $degrees = $_GET['degrees'];
}else{
    $degrees = 0;
}

header("Content-type: {$image->mime_type}");

$filename = $path . "/thumb_" .$file;

if($image->mime_type=='image/jpeg'){
    $rotate = imagecreatefromjpeg($filename);
}elseif($image->mime_type=='image/png'){
    $rotate = imagecreatefrompng($filename);
}

if($degrees!=0){
    $rotate = imagerotate($rotate,$degrees,0);
}

if($image->mime_type=='image/jpeg'){
    imagejpeg($rotate);
}elseif($image->mime_type=='image/png'){
    imagealphablending($rotate, false);
    imagesavealpha($rotate, true);
    imagepng($rotate);
}

imagedestroy($rotate);
