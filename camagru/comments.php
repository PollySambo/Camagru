<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config/database.php';

print_r($_SESSION['Username']);

	try
	{
		$Username		= $_SESSION['Username'];
		$image_user		= trim(htmlspecialchars($_POST['image_user']));
		$image_id 		= trim(htmlspecialchars($_POST['image_id']));
		$comment 		= htmlspecialchars($_POST['commet_txt']);
	



		
		if (!isset($Username) || empty($Username))
		{
			echo "! Username is invalid <br>";
		}
		else if (!isset($comment) || empty($comment))
		{
			echo "! Comment is invalid <br>";
		}
		else if ((isset($Username) && !empty($User_name)) 
			&& (isset($image_user) && !empty($image_user))
			&& (isset($image_id) && !empty($image_id)) 
			&& (isset($comment) && !empty($comment)))
		{
			$con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				// $sql = "USE ".$DB_NAME;
				$sql = "INSERT INTO comments (Username, comment, image_id)
				VALUES (:Username, :comment, :image_id)";
				$stmt = $con->prepare($sql);
				$stmt->bindParam(':Username', $Username);
				$stmt->bindParam(':comment', $comment);
				$stmt->bindParam(':image_id', $image_id);
				$stmt->execute();

				$message ="
				
someone commented on your picture..

click below to see the comment.
http://127.0.0.1:8080/camagru/signin.php?email=$email

Kind regards
camagru Team";

		$subject = "Comments";
                if (mail($email,$subject,$message))
                {
                    $msg = "Mail sent OK";
                }
                else
					die('email failed to send');
			}
            else
				die('Username/Email Already Exists');
	
	}
		catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }
        $conn = null;
?>
