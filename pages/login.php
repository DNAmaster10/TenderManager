<?php
    session_start();
    if (isset($_SESSION["login_error"])) {
        $error = $_SESSION["login_error"];
        unset($_SESSION["login_error"]);
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
            <input type="text" name="username" placeholder="Username" id="username_input">
            <input type="text" name="password" placeholder="Password" id="password_input">
            <input type="checkbox" id="remember_checkbox" name="remember" value="true">
            <input type="submit" value="Login">
        </form>
        <p id="error_p"><?php if (isset($error)) { echo $error; } ?></p>
    </body>
</html>