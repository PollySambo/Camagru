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
echo $_POST['overlay'];
?>