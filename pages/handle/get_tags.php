<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";

    if (!isset($_GET["tag"]) || $_GET["tag"] == "") {
        echo ("none");
    }
    else {
        $like_operator = "%".$_GET["tag"]."%";
        $final_string = "";
        $input_tag = $_GET["tag"];
        $stmt = $conn->prepare("SELECT tag FROM tags WHERE tag LIKE ?");
        $stmt->bind_param("s", $like_operator);
        $stmt->execute();
        $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $final_string = $final_string.$row["tag"]."#-#";
        }
        if (strlen($final_string < 1)) {
            echo ("null");
        }
        else {
            echo ($final_string);
        }
    }