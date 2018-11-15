<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'config/database.php';

if (isset($_GET['commet_txt'], $_GET['image_id']))
{

    $type   = $_GET['commet_txt'];
    $id     = $_GET['image_id'];


        $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
            // set the PDO error mode to exception
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $stmt = $con->query("SELECT  '".$_SESSION['Username']."', '".$id."' FROM images");
        // $stmt =  $con->query()
        $name = $_SESSION['Username'];
        $sql = "INSERT INTO comments (Username, image_id, comment) 
        VALUES ('".$name."', '".$id."', '".$type."')";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':Username', $Username);
        $stmt->bindParam(':image_id', $image_id);
        $stmt->bindParam(':comment', $comment);
        $stmt->execute();
       
}

header('location:gallery.php');


?>