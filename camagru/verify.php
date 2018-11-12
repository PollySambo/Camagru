<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//include 'signup.php';
//Get the unique user ID of the user that has just registered.
include 'config/database.php';
//Create a "unique" token.
$token = bin2hex(openssl_random_pseudo_bytes(16));
$email = 'dieselpolite@gmail.com';
//Construct the URL.
$url = "http://127.0.0.1:8080/camagru/verify.php?email=$email&token=$token";
 
//Build the HTML for the link.
$link = '<a href="' . $url . '">' . $url . '</a>';
 
//Send the email containing the $link above.


//Make sure that our query string parameters exist.
if(isset($_GET['token']) && isset($_GET['email']))
{
    $token = trim($_GET['token']);
    $email = trim($_GET['email']);

    // print_r($_GET);

    $pdo = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    // // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND token = :token");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':token', $token);

    $stmt->execute();
    $result = $stmt->fetch();
    //var_dump($result);
    if($result)
    {   

        // print_r($result);

            $active	= 1;

            //$pdo = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);

            //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE users SET active = 1 WHERE email = '$email'";  
            $stmt = $pdo->prepare($sql);
            // die($sql);
            $stmt->execute();

        header('location: login.php');
    } 
    else{
        //Token is not valid.
        echo 'Check your emails.';
    }
    $pdo = null;
}
?>
