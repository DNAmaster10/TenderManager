<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/home.css">
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php"; ?>
        <div id="home_bg_img_container">
            <img id="home_bg_img" src="/media/images/home/home_image_1.jpg" stype="width: 100%">
        </div>
        <h1>Welcome back, <?php echo $_SESSION["username"]; ?>.</h1>
        <form id="search_button" action="/pages/search.php">
            <input type="submit" value="Search">
        </form>
        <form id="add" action="/pages/add.php">
            <input type="submit" value="Add Entry">
        </form>
        <form id="Tags" action="/pages/tags.php">
            <input type="submit" value="Tags">
        </form>
    </body>
    <script src="/js/header.js"></script>
</html>