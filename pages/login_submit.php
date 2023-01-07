<?php
    session_start();
    function error($error) {
        $_SESSION["login_error"] = $error;
        header ("Location: /pages/login.php");
        die();
    }

    if (!isset($_POST["username"])) {
        error("Please enter a valid username");
    }
    if (!isset($_POST["password"])) {
        error("Please enter a valid password");
    }

    $hashed_password = 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Error</title>
    </head>
    <body>
        <p>If you are seeing this page, a serious error has occured</p>
    </body>
</html>