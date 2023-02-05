<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error($error) {
        echo "error:".$error;
        die();
    }

    if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
        error("Invalid ID");
    }
    
    //Check ID in database
    $id = intval($_POST["id"]);
    $stmt = $conn->prepare("SELECT * FROM tendors WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if (mysqli_num_rows($stmt) < 1) {
        error("Invalid ID");
    }
    $stmt->close();

    if (!isset($_POST["question"]) || strlen($_POST["question"]) < 1) {
        error("Please enter a question");
    }

    if (!isset($_POST["answer"]) || strlen($_POST["answer"]) < 1) {
        error("Please enter an answer");
    }

    if (!isset($_POST["tags"]) || strlen($_POST["tags"]) < 1) {
        error("Please attach at least one tag");
    }

    //Add tag check later
    $tag_array = explode("#-#", $_POST["tags"]);
    for ($i = 0; $i < count($tag_array); $i++) {
        $stmt = $conn->prepare("SELECT tag FROM tags WHERE tag=?");
        $stmt->bind_param("s", $tag_array[$i]);
        $stmt->execute();
        if ($stmt->num_rows() < 1) {
            error("Invalid tag: ".$tag_array[$i]);
        }
        $stmt->close();
    }

    //Add basics
    $stmt = $conn->prepare("UPDATE tendors SET uploader=?, question=?, answer=?, tags=? WHERE id=?");
    $stmt->bind_param("ssssi", $_SESSION["username"], $_POST["question"], $_POST["answer"], $_POST["tags"], $id);
    $stmt->execute();
    $stmt->close();

    //Add additional
    if (isset($_POST["client"]) && strlen($_POST["client"]) > 0) {
        $stmt = $conn->prepare("UPDATE tendors SET client=? WHERE id=?");
        $stmt->bind_param("si", $_POST["client"], $id);
        $stmt->execute();
        $stmt->close();
    }
    if (isset($_POST["year"]) && strlen($_POST["year"]) > 0) {
        if (is_numeric($_POST["year"])) {
            $year = intval($_POST["year"]);
            $stmt = $conn->prepare("UPDATE tendors SET year=? WHERE id=?");
            $stmt->bind_param("ii", $year, $id);
            $stmt->execute();
            $stmt->close();
        }
    }
    else {
        $year = 0;
        $stmt = $conn->prepare("UPDATE tendors SET year=? WHERE id=?");
        $stmt->bind_param("ii", $year, $id);
        $stmt->execute();
        $stmt->close();
    }
    if (isset($_POST["notes"]) && strlen($_POST["notes"]) > 0) {
        $stmt = $conn->prepare("UPDATE tendors SET notes=? WHERE id=?");
        $stmt->bind_param("si", $_POST["notes"], $id);
        $stmt->execute();
        $stmt->close();
    }
    if (isset($_POST["rating"]) && is_numeric($_POST["rating"])) {
        $rating = intval($_POST["rating"]);
        $stmt = $conn->prepare("UPDATE tendors SET rating=? WHERE id=?");
        $stmt->bind_param("si", $_POST["rating"], $id);
        $stmt->execute();
        $stmt->close();
    }
    echo ("success:Successfully submitted to database");
?>