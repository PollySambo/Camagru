<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	require 'config/database.php';
	$email	= $_POST['email'];
	$token	= bin2hex(openssl_random_pseudo_bytes(16));
	var_dump($email);
	if (isset($email) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$conn = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
		$stmt->bindValue(':email', $email);
		$stmt->execute();
		$result = $stmt->fetch();
		if (!$result)
			echo('email does not exist');
		else
		{
			var_dump($token);
			
			$conn = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$sql = "USE ".$DB_NAME;
			$stmt = $conn->prepare("UPDATE users SET token = :token");
			$stmt->bindParam(':token', $token);
			$stmt->execute();
			echo "added token\n";
			echo "$email";
			
			$to			= $email; 
			$subject	= 'Password Reset';
			$message	= 
			"
cant believe you forgot your password, but anyway lets reset it OK:):
http://127.0.0.1:8080/camagru/forgot_password.php?email='$email'&token='$token'
			";
			if (mail($to, $subject, $message))
			{
				echo "email sent\n";
				//header('Location: index.php');
				exit;
			}
			else
				echo "email failed to send\n";
		}			
	}
	$conn = null;
?>

<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../config/database.php';
	$token 			= $_SESSION['token'];
	$email 			= $_SESSION['email'];
	$passw_new		= htmlspecialchars($_POST['psw_new']);
	$passw_repeat	= htmlspecialchars($_POST['psw_repeat']);
	try
	{
		if (!isset($passw_new) || empty($passw_new) || !(strlen($passw_new) > 6) || (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw_new)) 
			|| (!isset($passw_repeat) || empty($passw_repeat) && !($passw_new === $passw_repeat)))
			{
				echo "! Password input is invalid<br>";
				if (!(strlen($passw_new) > 6))
				{
					echo "! Password length is too short, must be atleast 6 characters long<br>";
				}
				if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw_new))
				{
					echo "! Passowrd must contain letters and digits<br>";
				}
			}
		else if ((isset($passw_new) && !empty($passw_new) && (strlen($passw_new) > 6) && (preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $passw_new))) 
			&& (isset($passw_repeat) && !empty($passw_repeat) && ($passw_new === $passw_repeat)))
		{
			$conn = new PDO("$DB_DNS;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$sql = "USE ".$DB_NAME;		
			$conn->exec($sql);
			$stmt = $conn->prepare("SELECT email = :email AND token = :token FROM users");
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':token', $token);
			$stmt->execute();
			$user = $stmt->fetch();
			if (!$user)
				die('Could not access credentials through database!');
			else
			{
			
				$stmt = $conn->prepare("UPDATE users SET password = :password_new");
				$passw_new = password_hash($passw_new, PASSWORD_BCRYPT);
				$stmt->bindParam(':password_new', $passw_new);
				$stmt->execute();
				
				session_unset($_SESSION['token']);
				session_unset($_SESSION['email']);
				header('Location: ../index.php?');
				exit;		
			}
		 }
		else 
			die('Something went wrong...');
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
	$conn = null;
?>