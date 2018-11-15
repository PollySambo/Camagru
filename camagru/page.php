<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config/database.php';

	try
	{
        //print_r($_SESSION);
        
		// $user_name = $_SESSION['Username'];
		// if (isset($_SESSION['loggedin']) === true)
		// {
		// 	$username	= $_SESSION['username'];

		// 	if (!isset($_GET['user_name']))
		// 	{
		// 		$user_name	= $username;
		// 	}
		// 	else if (isset($_GET['user_name']))
		// 		$user_name	= htmlspecialchars($_GET['user_name']);	
		// }
        if (isset($_GET['user_name']))
			$user_name	= htmlspecialchars($_GET['user_name']);	
		else if (!isset($_GET['user_name']))
			die("either log in or put in a user name");
		else
			die("Something went wrong...");

		$conn = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$sql = "USE ".$DB_NAME;		
		$stmt = $conn->prepare("SELECT * FROM images WHERE user=:user_name");
		$stmt->bindValue(':user_name', $user_name);
		$stmt->execute();
		$image = $stmt->fetchAll();

		//REF: https://www.youtube.com/watch?v=gdEpUPMh63s Create Pagination in PHP and MySQL
		$results_per_page = 5; // number of images on page
		$number_of_results = sizeof($image); // the number of images taken from the db (above)

		$number_of_pages = ceil($number_of_results / $results_per_page); // round up to make effecient amount of pages

		if (!isset($_GET['page'])) 
			$page = 1;
		else
			$page = $_GET['page'];

		$page_first_result = ($page - 1) * $results_per_page;

		$stmt = $conn->prepare("SELECT * FROM images WHERE user=:user_name LIMIT " . $page_first_result . "," .  $results_per_page); // go fetch the amount of images required for that page
		$stmt->bindValue(':user_name', $user_name);
		$stmt->execute();
		$image = $stmt->fetchAll();

		// Images per page
		for ($i = 0; $i < sizeof($image) ; $i++) 
		{ 
			$img = $image[$i]['image'];
            echo '<img src="images/' . $img . '" />';
			
		}

			// Pages Links
			for ($page = 1; $page <= $number_of_pages; $page++) 
			{
				echo '<a href="page.php?user_name=' . $user_name .'&page=' . $page . '">' . $page . '</a> ';
			}
	}
	catch(PDOException $e)
	{
		echo $stmt . "<br>" . $e->getMessage();
	}

	$conn = null;
?>
