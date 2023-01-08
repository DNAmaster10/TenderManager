<?php
    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
    }
    unset($_SESSION["username"]);
    unset ($_SESSION["password"]);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Goodbye!</title>
    </head>
    <body>
        <form action="/index.php">
            <input type="submit" value="Home">
        </form>
        <p>Goodbye for now<?php if (isset($username)) { echo (", ".$username); } ?>.</p>
    </body>
</html>