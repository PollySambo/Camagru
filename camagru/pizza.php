<?php

// session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './config/database.php';
$con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  

$stmt = $con->prepare("SELECT
                    images.image_id,
                    images.image,
                    COUNT(likes.image_id) AS likes
                    
                    FROM images

                    LEFT JOIN likes
                    ON images.image_id = likes.image

                    LEFT JOIN users
                    on likes.user = users.user_id

                    GROUP BY images.image_id
                    ");
$stmt->execute();
    
while($result = $stmt->fetch(PDO::FETCH_ASSOC))
{
    $img[] = $result;
}

echo '<pre>'; print_r($img);echo '</pre>';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
	<?php foreach ($img as $pic):?>
		  <div class="pic">
                <img src='images/<?=$pic['image'];?>' >
                <a href="like.php?type=image&image_id=<?php echo $pic['image_id']; ?>">LIKE</a>
                <p>likes</p>
                <ul>
                    <li></li>
                </ul>
		</div>
	<?php endforeach;?>
</body>
</html>