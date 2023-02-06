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
        <div id="main_container">
            <h1>Welcome back, <?php echo $_SESSION["username"]; ?>.</h1>
            <div id="action_button_container">
                <div id="search_form_container" class="action_form_container" onclick="document.forms['search'].submit();">
                    <form id="search" action="/pages/search.php" class="action_form">
                        <p class="action_p">Search Database</p>
                    </form>
                </div>
                <div id="add_form_container" class="action_form_container" onclick="document.forms['add'].submit();">
                    <form id="add" action="/pages/add.php" class="action_form">
                        <p class="action_p">Add Entry</p>
                    </form>
                </div>
                <div id="tags_form_container" class="action_form_container" onclick="document.forms['add'].submit();">
                    <form id="tags" action="/pages/tags.php" class="action_form">
                        <p class="action_p">Tags</p>>
                    </form>
                </div>
                <div id="list_form_container" class="action_form_container" onclick="document.forms['list'].submit();">
                    <form id="list" action="/pages/list.php" class="list_form">
                        <p class="action_p">List Entries</p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>