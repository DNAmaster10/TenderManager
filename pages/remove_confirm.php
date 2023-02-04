<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error($error) {
        $_SESSION["generic_error"] = $error;
        header ("Location: /pages/error.php");
        die();
    }
    if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
        error("Invalid ID");
    }

    $id = intval($_POST["id"]);

    //Check ID is valid
    $stmt = $conn->prepare("SELECT * FROM tendors WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    if (!$result) {
        error("Invalid ID");
    }
    $stmt->close();
    unset($result);

    $stmt = $conn->prepare("DELETE FROM tendors WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: /pages/search.php");
?>
