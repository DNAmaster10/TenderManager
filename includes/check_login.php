<?php
    if (!isset($_SESSION["username"]) || !isset($_SESSION["password"])) {
        $_SESSION["generic_error"] = "Your login session has expired";
        header ("Location: /pages/error.php");
        die();
    }

    //Check login in database
    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $_SESSION["username"]);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    if (!$result) {
        $_SESSION["generic_error"] = "Your login is invalid";
        header ("Location: /pages/error.php");
        die();
    }
    if (!$result == $_SESSION["password"]) {
        $_SESSION["generic_error"] = "Your login is invalid";
        header ("Location: /pages/error.php");
        die();
    }
    error_log(password_hash($_SESSION["password"], PASSWORD_DEFAULT, ["cost" => 15]));
    unset ($result);
?>