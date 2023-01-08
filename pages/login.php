<?php
    session_start();
    if (isset($_SESSION["login_error"])) {
        $error = $_SESSION["login_error"];
        unset($_SESSION["login_error"]);
    }

    if (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
        $username = $_COOKIE["username"];
        $password = $_COOKIE["password"];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="/css/login.css">
    </head>
    <body>
        <form action="/pages/login_submit.php" method="POST">
            <input type="text" name="username" placeholder="Username" <?php if (isset($username)) { echo "value='$username'"; } ?>>
            <input type="text" name="password" placeholder="Password" <?php if (isset($password)) { echo "value='$password'"; } ?>>
            <input type="checkbox" id="remember_checkbox" name="remember" value="true">
            <input type="submit" value="Login">
        </form>
        <p id="error_p"><?php if (isset($error)) { echo $error; } ?></p>
    </body>
</html>