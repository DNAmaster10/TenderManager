<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
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

    $hashed_password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s",$_POST["username"]);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    if (!$result) {
        error("Username or password invalid");
    }

    if (!$result == $hashed_password) {
        error("Username or password invalid");
    }

    $_SESSION["username"] = $_POST["username"];
    $_SESSION["password"] = $hashed_password;

    header ("Location: /pages/home.php");
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