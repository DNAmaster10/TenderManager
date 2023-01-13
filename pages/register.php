<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="/css/main.css">
        <style>
            body {
                margin: 0px;
                padding: 0px;
            }
            #main_container {
                margin: 10px;
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php"; ?>
        <form action="/pages/register_submit.php" method="POST">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="Password">
            <input type="submit" value="Register">
        </form>
    </body>
</html>