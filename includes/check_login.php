<?php
    if (!isset($_SESSION["username"])) {
        $_SESSION["generic_error"] = "Your login session has expired";
        header ("Location: /pages/error.php");
        die();
    }
?>