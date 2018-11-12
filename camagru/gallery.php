<?php
session_start();
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
	  echo $username = $_SESSION['Username'];

  	$sql = "INSERT INTO images (image, user, text) 
		VALUES ('".$image."', '".$username."', '".$image_text."')";
		$stmt = $con->prepare($sql);
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

//------------------------------like button-----------------------------
		
	$con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$stmt = $con->query("SELECT images.image_id, images.image FROM images");
		
	while($result = $stmt->fetchAll(PDO::FETCH_ASSOC))
	{
		$im[] = $result;
	}

		// //   print_r($result);
		// foreach($result as $d)
		//  {
		 	//print_r($d);
		/// 	echo "|".$d['image_id'];
		//   foreach($d as $f)
		//  §	{
	//  echo $f['image_id'];
	 // 		}
	 // 	}
	//  die();
	// 	  while ($row == $result){
	// 	 	  $img[] = $row;
	// 	 }
		  
		//   echo '<pre>'; print_r($img);echo '</pre>';
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Image Upload</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	<header style="display: flex;">
    <div class="logo-signup">
        <img src="pictures/logo.png">
        </div>
        <ul class="signup-nav">
			<li><a href="index.php">HOME</a></li>
			<li><a href="cam.php">CAMERA</a></li>
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
	
	foreach ($result as $img):
		?>
		<div id='img_div'>
      	<img src='images/<?=$img['image'];?>' >
      	<p><?=$img['text'];?></p>
		  </div>
	
		  <?php
		  endforeach;?>



	<?php foreach ($im as $pic):?>
		  <div class="pic">
			  	<h3><?php echo $pic['user'];?></h3>
				<a href="like.php?type=image&image_id=<?php echo $pic['image_id']; ?>">LIKE</a>
		</div>
	<?php endforeach;?>


  <form method="POST" action="gallery.php" enctype="multipart/form-data" >
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