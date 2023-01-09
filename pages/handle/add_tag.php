<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error($error) {
        echo ("error:".$error);
        die();
    }

    if (!isset($_POST["tag_name"]) || strlen($_POST["tag_name"]) < 1) {
        error("Enter a tag name");
    }

    //Check tag name doesn't already exist
    $stmt = $conn->prepare("SELECT tag FROM tags WHERE tag=?");
    $stmt->bind_param("s", $_POST["tag_name"]);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    if ($result && mysqli_num_rows($result) > 0) {
        error("A tag with that name already exists");
    }
    
    //Add tag to database
    $stmt = $conn->prepare("INSERT INTO tags(tag) VALUES (?)");
    $stmt->bind_param("s", $_POST["tag_name"]);
    $stmt->execute();
    $stmt->close();

    echo ("success");