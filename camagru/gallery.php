<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './config/database.php';

try{
  // Create database connection
  $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Initialize message variable
  $msg = "";

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
  	// Get text
  $image_text = $_POST['image_text'];

  	// image file directory
  	$target = "images/".basename($image);

  	$sql = "INSERT INTO images (image, text) 
		VALUES ('$image', '$image_text')";
		$stmt = $con->prepare($sql);
		$stmt->bindParam(':image', $image);
		$stmt->bindParam(':image_text', $image_text);
		$stmt->execute();
  	// execute query

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $con->prepare("SELECT * FROM images");
    $stmt->bindParam(':images', $images);
    $stmt->execute();
    $result = $stmt->fetch();
  //$result = mysqli_query($con, "SELECT * FROM images");
}
catch(PDOException $e)
{
	echo "connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Image Upload</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	<header>
    <div class="logo-signup">
        <img src="pictures/logo.png">
        </div>
        <ul class="signup-nav">
			<li><a href="index.php">HOME</a></li>
			<li><a href="gallery.php">CAMERA</a></li>
			<li><a href="logout.php">LOGOUT</a></li>
        </ul>
    </header>
	<div id="content">
<?php
	$con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $con->prepare("SELECT * FROM images");
	$stmt->bindParam(':images', $images);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$row = $result;
	//print_r($row);
	
	foreach ($result as $img) {
		echo "<div id='img_div'>";
      	echo "<img src='images/".$img['image']."' >";
      	echo "<p>".$img['text']."</p>";
      	echo "</div>";
	}
  ?>
  <form method="POST" action="gallery.php" enctype="multipart/form-data">
  	<input type="hidden" name="size" value="1000000">
  	<div>
  	  <input type="file" name="image">
  	</div>
  	<div>
      <textarea 
      	id="text" 
      	cols="40" 
      	rows="4"
      	name="image_text" 
      	placeholder="Say something about this image..."></textarea>
  	</div>
  	<div>
  		<button type="submit" name="upload">POST</button>
  	</div>
  </form>
	</div>
	</body>
</html>