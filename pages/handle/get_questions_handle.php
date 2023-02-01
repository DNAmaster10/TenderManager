<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error() {
        echo ("error");
        die();
    }

    if (!isset($_GET["question_ammount"]) || strlen($_GET["question_ammount"]) < 1 || !is_numeric($_GET["question_ammount"])) {
        error();
    }
    else {
        $question_ammount = intval($_GET["question_ammount"]);
    }
    if (!isset($_GET["search_term"]) || strlen($_GET["search_term"]) < 1 || $_GET["search_term"] == "none-null") {
        $contains_term = false;
    }
    else {
        $contains_term = true;
    }
    if (!isset($_GET["tags"]) || strlen($_GET["tags"]) < 1 || $_GET["tags"] == "none-null") {
        $contains_tags = false;
    }
    else {
        $contains_tags = true;
    }
    if (!$contains_term && !$contains_tags) {
        error();
    }

    $return_string = "";
    if ($contains_term && $contains_tags) {
        $tag_array = explode("#-#", $_GET["tags"]);
        $statement = "SELECT id,question,client,year,rating FROM tendors WHERE question LIKE ?";
        for ($i = 0; $i < count($tag_array); $i++) {
            $statement .= " AND tags LIKE ?";
            $types .= "s";
        }
        $statement .= " LIMIT 10 OFFSET ?";
        $types .= "i";
        array_unshift($tag_array, "%".$_GET["search_term"]."%");
        array_push($tag_array, $question_ammount);
        $stmt = $conn->prepare($statement);
        $stmt->bind_param($types, ...$tag_array);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $return_string .= "#-#".$row["id"]."-#-".$row["question"]."-#-".$row["client"]."-#-".$row["year"]."-#-".$row["rating"];
        }
        unset($result);
        $stmt->close();
    }
    else if ($contains_term && !$contains_tags) {
        $param = "%".$_GET["search_term"]."%";
        $stmt = $conn->prepare("SELECT id,question,client,year,rating FROM tendors WHERE question LIKE ? LIMIT 10 OFFSET ?");
        $stmt->bind_param("si", $param, $question_ammount);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $return_string .= "#-#".$row["id"]."-#-".$row["question"]."-#-".$row["client"]."-#-".$row["year"]."-#-".$row["rating"];
        }
        unset($result);
        $stmt->close();
    }
    else if (!$contains_term && $contains_tags) {
        $types = "";
        $tag_array = explode("#-#", $_GET["tags"]);
        $statement = "SELECT id,question,client,year,rating FROM tendors WHERE tags LIKE ?";
        for ($i = 0; $i < count($tag_array); $i++) {
            $statement .= " AND tags LIKE ?";
            $types .= "s";
        }
        $statement .= " LIMIT 10 OFFSET ?";
        $types .= "i";
        array_push($tag_array, $question_ammount);
        $stmt = $conn->prepare($statement);
        $stmt->bind_param($types, ...$tag_array);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $return_string .= "#-#".$row["id"]."-#-".$row["question"]."-#-".$row["client"]."-#-".$row["year"]."-#-".$row["rating"];
        }
        unset($result);
        $stmt->close();
    }
    if (!isset($return_string) || strlen($return_string) < 1) {
        echo ("0");
    }
    else {
        echo ($return_string);
    }