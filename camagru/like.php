<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// var_dump($_GET['type']);
// var_dump($_GET['id']);

// echo "now";
require 'config/database.php';

if (isset($_GET['type'], $_GET['image_id']))
{

    $type   = $_GET['type'];
    $id     = $_GET['image_id'];

    switch($type){
        case 'image':
        $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
            // set the PDO error mode to exception
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $con->query("INSERT INTO likes (user, image_id)
                                SELECT '".$_SESSION['Username']."', '".$id."'
                                FROM images
                                WHERE EXISTS (
                                    SELECT image_id
                                    FROM images
                                WHERE image_id = '".$id."')
                                AND NOT EXISTS (
                                    SELECT image_id
                                    FROM likes
                                    WHERE user = '".$_SESSION['Username']."'
                                    AND image_id = '".$id."')
                                    LIMIT 1
                                    ");
        break;
    }
}

header('location:gallery.php');
?>