
<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//  print_r($_SESSION);

include 'config/database.php';
include_once 'functions.php';
	try
	{
        // $username   = trim(htmlspecialchars($_POST['username']));
        // $email      = trim(htmlspecialchars($_POST['email']));
        // $pwd        = trim(htmlspecialchars($_POST['pwd']));
		
		if (isset($_SESSION['loggedin']) === true)
			$usersi  = $_SESSION['Username'];
		else
            die ('no session variables have been set');
        if (!empty($_POST['username']) || !empty($_POST['email']) || !empty($_POST['pwd']))
        {
            echo 'Hello there';
            $username   = trim(htmlspecialchars($_POST['username']));
            $email      = trim(htmlspecialchars($_POST['email']));
            $pwd        = trim(htmlspecialchars($_POST['pwd']));
		
	     if (isset($username) && !empty($username))
			{
				$con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				$sql = "USE ".$DB_NAME;	
				$exist = checkExist($username, NULL, $con);
				if (!$exist)
				{
					$stmt = $con->prepare("SELECT * FROM users WHERE username=:username /*AND email=:email*/");
                    $stmt->bindValue(':username', $usersi);
                    //$stmt->bindValue(':email', $email);
					$stmt->execute();
					$user = $stmt->fetch();
					if (!$user)
						die('change failed.');
					else
					{
                        $stmt = $con->prepare("UPDATE users  SET username = :username WHERE username = :user");
                        /*SET email = :email WHERE email = :email
                        SET pwd = :pwd WHERE pwd = :pwd");*/
                        $stmt->bindValue(':user', $usersi);
						$stmt->bindValue(':username', $username);
                        //$stmt->bindValue(':email', $email);
                        //$stmt->bindValue(':pwd', $pwd);
						$stmt->execute();
						
						echo "username changed\n";
						$_SESSION['username'] = $username;
						//header('Location: ../index.php?');
						exit;
					}
				}
			}
			else if (!$exist)
				die('username taken');
			else
				die('Something went wrong...');
    }
}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}
	$conn = null;
?>


<!DOCTYPE html>
<html>
<head>
    <title>Camagru</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<img class="logo" src="pictures/logo.png">
        <header>
                <ul class="main-nav">
                    <li ><a href="signedin.php"> HOME </a></li>
                    <li><a href="logout.php"> LOGOUT </a></li>
                    <li><a href="gallery.php"> GALLERY </a></li>
                    <li><a href="cam.php"> CAMERA </a></li>
                    <li class="active"><a href=""> PREFENCES </a></li>
                </ul>
        </header>
        <form class="box2" action="modify.php" method="post">
        <h1>Modify Your Account</h1>
        <input type="text" placeholder="Username" name="username" required>
        <input type="email" placeholder="Email Address" name="email" required>
        <input type="password" placeholder="Password" name="pwd" required>
        <input type="submit" name="signup" value="submit">
    </form>
</body>
</html>