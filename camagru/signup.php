<?php
/* ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
*/
require 'config/database.php';
//var_dump($servername);
$errors = array();
try {
    $conn = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($_POST['signup']){

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $re_pwd =  $_POST['re_pwd'];


        echo "hello-".$_POST['fname']."-";

        if ((isset($fname) && !empty($fname))
        && (isset($lname) && !empty($lname)) 
        && (isset($username) && !empty($username))
        && (isset($email) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL))
        && (isset($pwd) && !empty($pwd) && isset($re_pwd) && !empty($re_pwd) && $re_pwd === $pwd))
        {
            $token = bin2hex(openssl_random_pseudo_bytes(16)); 
            $hashpass = password_hash($pwd, PASSWORD_DEFAULT);
            //var_dump($_POST);

            if (count($errors) == 0) 
            {
                $sql = "INSERT INTO users (firstname, lastname, Username, email, Passwrd, token)
                VALUES (:fname, :lname, :username, :email, :pwd, :token)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':fname', $fname);
                $stmt->bindParam(':lname', $lname);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pwd', $hashpass);
                $stmt->bindParam(':token', $token);
                $stmt->execute();
                
                            $message ="
Thank you for registering with camagru.
You can log in using the following credentals after verification:
-------------------
USERNAME :".$username."
PASSWORD :".$password."
-------------------
please verify your account by clicking the link below
http://127.0.0.1:8080/camagru/verify.php?email=$email&token=$token

Kind regards
camagru Team";
                
                $subject = "verify your account";
                if (mail($email,$subject,$message))
                {
                    $msg = "Mail sent OK";
                }
                $conn = null;
            }
        }
    }
    //echo "Connected successfully";
 
    }
    catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>

<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Sign Up</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
        <div class="logo-signup">
        <img src="pictures/logo.png">
        </div>
        <ul class="signup-nav">
            <li><a href="index.php"> HOME </a></li>
            <li class="active"><a href=""> SIGNUP </a></li>
            <li><a href="login.php"> LOGIN </a></li>
            <li><a href="gallery.php"> GALLERY </a></li>
        </ul>
    </header>
    <form class="box2" action="signup.php" method="post">
        <h1>Sign Up</h1>
        <input type="text" placeholder=" First Name" name="fname" required>
        <input type="text" placeholder="Last Name" name="lname" required>
        <input type="text" placeholder="Username" name="username" required>
        <input type="email" placeholder="Email Address" name="email" required>
        <input type="password" placeholder="Password" name="pwd" required>
        <input type="password" placeholder="ReType Password" name="re_pwd" required>
        <input type="submit" name="signup" value="signup">
    </form>
</body>
</html>