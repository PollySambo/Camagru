<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require './config/database.php';
if(isset($_POST['Username']) && isset($_POST['Password'])){
    $Username = trim($_POST['Username']);
    $Password = trim($_POST['Password']);

    $pdo = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Username = :Username");
    $stmt->bindParam(':Username', $Username);
    $stmt->execute();
    $result = $stmt->fetch();
    if(password_verify ( $Password , $result['Passwrd'] )){
        //Token is valid. Verify the email address
        header('location: signedin.php');
    } else{
        //Token is not valid.
        echo '<br/>'.'Nothing'.'<br/>';
    }
    $pdo = null;
}
?>

<!doctype html>
<html>
    <head>
        <title>Camagru</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
<body>
    <header>
    <div class="logo-signup">
        <img src="pictures/logo.png">
        </div>
        <ul class="signup-nav">
            <li><a href="index.php"> HOME </a></li>
            <li><a href="signup.php"> SIGNUP </a></li>
            <li class="active"><a href=""> LOGIN </a></li>
            <li><a href="gallery.php"> GALLERY </a></li>

        </ul>
    </header>
    <div class="us" align="center">
    <form class="box" action="login.php" method="post">
        <h1>Login</h1>
        <input type="text" placeholder="Username" name='Username'>
        <input type="text" placeholder="Password" name='Password'>
        <input value="reset password" type="submit" name="submit"/>
        <input type="submit" name="" value="login">
        
    </form>
    </div>
</body>
</html>