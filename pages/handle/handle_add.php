<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error($error) {
        echo "error,".$error;
        die();
    }

    if (!isset($_POST["question"])) {
        error("Please enter a question");
    }
    if (!isset($_POST["answer"])) {
        error("Please enter an answer");
    }
    if (!isset($_POST["tags"])) {
        error("Please attach at least one tag");
    }

    //Add tag check later

    //Add basics
    $stmt = $conn->prepare("INSERT INTO tendors(uploader, question, answer, tags) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $_SESSION["username"], $_POST["question"], $_POST["answer"], $_POST["tags"]);
    $stmt->execute();
    $stmt->close();

    //Add additional
    if (isset($_POST["client"]) && strlen($_POST["client"] > 0)) {
        $stmt = $conn->prepare("INSERT INTO tendors(client) VALUES (?)");
        $stmt->bind_param("s", $_POST["client"]);
        $stmt->execute();
        $stmt->close();
    }
    