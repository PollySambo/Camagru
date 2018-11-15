<?php
session_start();
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

include 'config/database.php'; 
require_once 'functions.php';
//var_dump($servername);
//var_dump($fname, $lname, $username , $email, $pwd , $re_pwd, $active, $token);
try {
        //print_r($_POST);
        if (!empty($_POST['username']) || !empty($_POST['email']) || !empty($_POST['pwd']) || !empty($_POST['re_pwd']))
{
    // $fname          = trim(htmlspecialchars($_POST['fname']));
    // $lname          = trim(htmlspecialchars($_POST['lname']));
    $username       = trim(htmlspecialchars($_POST['username']));
    $email          = trim(htmlspecialchars($_POST['email']));
    $pwd            = trim(htmlspecialchars($_POST['pwd']));
    $re_pwd         = trim(htmlspecialchars($_POST['re_pwd']));
    $active         = false;
    $notifi         = true;
    $token			= bin2hex(openssl_random_pseudo_bytes(16));
       
		if (!isset($username) || empty($username) || strlen($username) < 4)
		{
			echo "! Username input is invalid - *also check to see if username is more than 4 characters long<br>";
		}
		else if (!isset($email) || empty($email) || !(filter_var($email, FILTER_VALIDATE_EMAIL)))
		{
			echo "! Email input is invalid<br>";
		}
		else if (!isset($pwd) || empty($pwd) || !($pwd === $re_pwd) || !(strlen($pwd) > 6) || (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $pwd)))
		{
			echo "! Password input is invalid<br>";
			if (!($pwd === $re_pwd))
			{
				echo "! Password fields do not match<br>";
			}
			if (!(strlen($pwd) > 6))
			{
				echo "! Password length is too short, must be atleast 6 characters long<br>";
			}
			if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $pwd))
			{
				echo "! Password must contain letters and digits<br>";
			}
        }
        else if ((isset($username) && !empty($username) && !(strlen($username) < 4)) 
			&& (isset($email) && !empty($email) && (filter_var($email, FILTER_VALIDATE_EMAIL))) 
			&& (isset($pwd) && !empty($pwd) && ($pwd === $re_pwd) && (strlen($pwd) > 6) || (preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $pwd))))
		{
            $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $user = checkExist($username, $email, $con);
            if (!$user)
            {
                $hashpass = password_hash($pwd, PASSWORD_BCRYPT);
				$con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
				$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				$sql = "USE ".$DB_NAME;
                $sql = "INSERT INTO users ( Username, email, Passwrd, token, active, notifications)
                VALUES (:username, :email, :pwd, :token, :activated, :notifications)";
                $stmt = $con->prepare($sql);
                // $stmt->bindParam(':fname', $fname);
                // $stmt->bindParam(':lname', $lname);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pwd', $hashpass);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':activated', $active, PDO::PARAM_BOOL);
                $stmt->bindParam(':notifications', $notifi , PDO::PARAM_BOOL);
                $stmt->execute();
                
                            $message ="
Thank you for registering with camagru.
You can log in using the following credentals after verification:
-------------------
USERNAME :".$username."
-------------------
please verify your account by clicking the link below
http://127.0.0.1:8080/camagru/verify.php?email=$email&token=$token

Kind regards
camagru Team";
                
                $subject = "verify your account";
                if (mail($email,$subject,$message))
                {
                    $msg = "Mail sent OK";
                    echo "<script>alert('signed up');</script>";
                    header('location:login.php');
                }
                else
                    die('email failed to send');
            }
            else
                die('Username/Email Already Exists');
        }
        else
            die('something went wrong');
                $conn = null;
        }
    }
        catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }
        $conn = null;
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
        <!-- <input type="text" placeholder=" First Name" name="fname" required>
        <input type="text" placeholder="Last Name" name="lname" required> -->
        <input type="text" placeholder="Username" name="username" required>
        <input type="email" placeholder="Email Address" name="email" required>
        <input type="password" placeholder="Password" name="pwd" required>
        <input type="password" placeholder="ReType Password" name="re_pwd" required>
        <input type="submit" name="signup" value="signup">
    </form>
</body>
</html>