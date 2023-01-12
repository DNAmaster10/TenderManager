<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error($error) {
        echo "error:".$error;
        die();
    }

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
        $stmt->bind_result($result);
        $stmt->fetch();
        $stmt->close();
        if (!$result) {
            error("Tag ".$tag_array[$i]." invalid.");
        }
    }

    //Add basics
    $stmt = $conn->prepare("INSERT INTO tendors(uploader, question, answer, tags) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $_SESSION["username"], $_POST["question"], $_POST["answer"], $_POST["tags"]);
    $stmt->execute();
    $id = mysqli_insert_id($conn);
    $stmt->close();

    //Add additional
    if (isset($_POST["client"]) && strlen($_POST["client"] > 0)) {
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