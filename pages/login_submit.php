<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        $_SESSION["login_error"] = "Please enter a valid username and password";
        header ("Location: /pages/login.php");
        die();
    }

    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $_POST["username"]);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    if (!$result) {
        $_SESSION["login_error"] = "Please enter a valid username and password";
        header ("Location: /pages/login.php");
        die();
    }
    
    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    if (!password_verify($hash, $result)) {
        $_SESSION["login_error"] = "Please enter a valid username and password";
        header ("Location: /pages/login.php");
        die();
    }
    $_SESSION["username"] = $_POST["username"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Error</title>
    </head>
    <body>
        <p>If you are seeing this page, redirect has failed.</p>
        <form id="home_form" action="/pages/home.php">
            <input type="submit" value="Home">
        </form>
    </body>
</html>