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
            <li><a href="index.php"> HOME </a></li>
            <li><a href="logout.php"> LOGOUT </a></li>
            <li class="active"><a href=""> GALLERY </a></li>
        </ul>
    </header>
    <h1 style="margin-top:70px;">SAY CHEESE :)</h1>
    <div class="top-container" style="positio: relative;">
        <video id="video">Stream not available...</video>
        <img src="" alt="" id="overlay" style="position:absolute;left: 380px;width: 500px;height: 375px;">
        <button id="photo-button" class="btn btn-dark">
            Take Photo
        </button>
        <select id="photo-filter">
            <option value="none">Normal</option>
            <option value="./pictures/whale.png">whale</option>
            <option value="./pictures/wanted.png">sepia</option>
            <option value="./pictures/emerg_sign.png">invert</option>
            <option value="hue-rotate(90deg)">hue</option>
            <option value="blur(10px)">blur</option>
            <option value="contrast(200%)">contrast</option>
        </select>
        <button id="clear-button">Clear</button>
        <canvas id="canvas" style="display:none;"></canvas>
    </div>
    <div class="bottom-container">
        <div id="photos"></div>
    </div>
    <script src="gallery.js" ></script>
</body>
</html>