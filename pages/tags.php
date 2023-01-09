<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Tags</title>
        <link rel="stylesheet" href="/css/main.css">
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php"; ?>
        <div id="main_container">
            <h2>Hey <?php echo $_SESSION["username"]; ?>, use this page to add new tags.</h2>
            <p>Tag naming should be consistent. Once a tag has been created, it cannot be removed. If the name of a tag needs to be changed, or a tag need to be deleted, please ask an administrator to do what it is you need doing.</p>
            <input type="text" id="tag_name_input">
            <button type="button" id="tag_name_submit" onclick="addTag()">Add tag</button>
            <div id="tag_list_container"></div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/pages/js/tags.js"></script>
</html>