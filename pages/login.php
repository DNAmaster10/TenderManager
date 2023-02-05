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
        <link rel="stylesheet" hreg="/css/main.css">
    </head>
    <body>
        <form action="/pages/login_submit.php" method="POST">
            <input type="text" name="username" placeholder="Username" id="username_input">
            <br>
            <input type="text" name="password" placeholder="Password" id="password_input">
            <br>

            <input type="submit" value="Login">
        </form>
        <p id="error_p"><?php if (isset($error)) { echo $error; } ?></p>
    </body>
</html>