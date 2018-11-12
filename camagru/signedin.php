
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/database.php';
 echo $_SESSION['Username'];
?>
<!doctype html>
<html>
    <head>
        <title>Camagru</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <center>
    <body>
        <img class="logo" src="pictures/logo.png">
        <header>
                <ul class="main-nav">
                    <li class="active"><a href=""> HOME </a></li>
                    <li><a href="logout.php"> LOGOUT </a></li>
                    <li><a href="gallery.php"> GALLERY </a></li>
                    <li><a href="cam.php"> CAMERA </a></li>
                </ul>
        </header>
        <h1 class="hero">ARE YOU READY</h1>
        <table>
            <td>
                <div class="item1">
                      <img src="pictures/bagpic.png">

                 </div>
             </td>
                <td>
                        <div class="item1">
                            <img src="pictures/cuppic.png">
    
                        </div>
                    </td>
                    <td>
                            <div class="item1">
                                <img src="pictures/phonepic.png">
        
                            </div>
                        </td>
            </table>
            <div class="share">
                    <h1>FOR SHARING?</h1>
            </div>
        <footer>
                 <ul class="foot-nav">
                        <li><a href=""> ABOUT US </a></li>
                        <li><a href=""> DETAILS </a></li>
                        <li><a href=""> CONTACT </a></li>
                </ul>
        </footer>
    </body>
    </center>
</html>