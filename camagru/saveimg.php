<?php

$imageurl = $_POST['key'];
// echo $imageurl;
file_put_contents('test4.png', base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$imageurl)));
echo $_POST['overlay'];
?>


