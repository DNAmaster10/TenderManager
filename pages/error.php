<?php
    if (isset($_SESSION["generic_error"])) {
        $error = $_SESSION["generic_error"];
    }
    else {
        $error = "An error occured";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Error</title>
    </head>
    <body>
        <p><?php echo $error; ?></p>
        <form action="/pages/home.php">
            <input type="submit">
        </form>
    </body>
</html>