<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$imageurl = $_POST['key'];
// echo $imageurl;
$token = uniqid();
$id = $token . ".png";
file_put_contents($id, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$imageurl)));
$dest = imagecreatefrompng($id);
$src = imagecreatefrompng($_POST['overlay']);
imagecopy($dest, $src, 0, 0, 0, 0, 500, 500);
header('Content-type: image/png');

imagejpeg($dest, $id, 100);

imagedestroy($dest);
imagedestroy($src);
echo $_POST['overlay'];
?>