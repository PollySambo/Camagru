<!doctype html>
<html>
    <head>
        <title>Camagru</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
<body>
    <header style="padding-bottom: 70px;">
        <div  class="logo-signup">
            <img src="pictures/logo.png">
        </div>
        <ul class="signup-nav">
            <li><a href="signedin.php"> HOME </a></li>
            <li><a href="gallery.php"> GALLERY </a></li>
            <li class="active"><a href=""> CAMERA </a></li>
            <li><a href="logout.php"> LOGOUT </a></li>
        </ul>
    </header>
    <h1 style="margin-top:70px;">SAY CHEESE :)</h1>
    <div class="top-container" style="position: relative;">
        <video id="video">Stream not available...</video>
        <img src="" alt="" id="overlay" style="position:absolute;left: 380px;width: 500px;height: 375px;">
        <button id="photo-button" class="btn btn-dark">
            Take Photo
        </button>
        <select id="photo-filter">
            <option value="none">Normal</option>
            <option value="https://media.giphy.com/media/xT8qBjvfwOs0cwBA4w/giphy.gif">whale</option>
            <option value="https://media.giphy.com/media/26BRww0JsfXLwnjRS/giphy.gif">wanted</option>
            <option value="https://media.giphy.com/media/3oEjHHDYHs1wpp8TqE/giphy.gif">emergency</option>
            <option value="./overlay_pics/100.png">100%</option>
            <option value="./overlay_pics/love.png">love</option>
            <option value="https://media.giphy.com/media/3OBelYwJKoCaS3evc8/giphy.gif">touch</option>
        </select>
        <button id="clear-button">Clear</button>
        <canvas id="canvas" style="display:none;"></canvas>
    </div>
    <div class="bottom-container">
        <div id="photos"></div>
    </div>
    <script src="gallery.js" ></script>
    <script>
        

    </script>
</body>
</html>