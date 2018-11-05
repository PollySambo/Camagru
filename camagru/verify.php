<?php
include 'signup.php';
//Get the unique user ID of the user that has just registered.
 
//Create a "unique" token.
$token = bin2hex(openssl_random_pseudo_bytes(16));
$email = 'dieselpolite@gmail.com';
//Construct the URL.
$url = "http://127.0.0.1:8080/camagru/verify.php?email=$email&token=$token";
 
//Build the HTML for the link.
$link = '<a href="' . $url . '">' . $url . '</a>';
 
//Send the email containing the $link above.

include './config/database.php';
//Make sure that our query string parameters exist.
if(isset($_GET['token']) && isset($_GET['email'])){
    $token = trim($_GET['token']);
    $email = trim($_GET['email']);

    $pdo = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND token = :token");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $result = $stmt->fetch();
    if($result){
        //Token is valid. Verify the email address
        header('location: signedin.php');
    } else{
        //Token is not valid.
        echo 'Nothing';
    }
    $pdo = null;
}
?>