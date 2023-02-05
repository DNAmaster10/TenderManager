<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
        $_SESSION["generic_error"] = "Invalid ID";
        header("Location: /pages/error.php");
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Remove</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/remove.css">
    </head>
    <body>
        <div id="main_container">
            <h1>Are you sure you want to remove this entry?</h1>
            <form action="/pages/remove_confirm.php" method="POST">
                <input type="hidden" name="id" value="<?php echo($_POST["id"]); ?>">
                <input type="submit" value="Delete Entry">
            </form>
        </div>
    </body>
</html>