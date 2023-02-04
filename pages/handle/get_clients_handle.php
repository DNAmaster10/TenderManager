<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error() {
        echo ("error");
        die();
    }

    if (!isset($_GET["client_ammount"]) || strlen($_GET["client_ammount"]) < 1 || !is_numeric($_GET["client_ammount"])) {
        error();
    }
    else {
        $client_ammount = intval($_GET["client_ammount"]);
    }
    $contains_term = (isset($_GET["search_term"]) && strlen($_GET["search_term"]) > 0 && $_GET["search_term"] != "none-null");

    $contains_tags = (isset($_GET["tags"]) && strlen($_GET["tags"]) > 0 && $_GET["tags"] != "none-null");

    if (!$contains_term && !$contains_tags) {
        error();
    }

    $tag_array = explode("#-#", $_GET["tags"]);
    if ($contains_tags) {
        for ($i = 0; $i < count($tag_array); $i++) {
            $tag_array[$i] = "%".$tag_array[$i]."%";
        }
    }

    $return_string = "";
    if ($cotnains_term && $contains_tags) {
        $types = "s";
        $statement = "SELECT id,question,client,year,rating FROM tendors WHERE client LIKE ?";
        for ($i = 0; $i < count($tag_array); $i++) {
            $statement .= " AND tags LIKE ?";
            $types .= "s";
        }
        $statement .= " LIMIT 10 OFFSET ?";
        $types .= "i";
        array_unshift($tag_array, "%".$_GET["search_term"]."%");
        array_push($tag_array, $client_ammount);
        error_log($statement);
        error_log($types);
        error_log(implode(" ",$tag_array));
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
    else if (!$contains_term && $contains_tags) {
        $types = "s";
        $statement = "SELECT id,question,client,year,rating FROM tendors WHERE tags LIKE ?";
        for ($i = 0; $i < count($tag_array) - 1; $i++) {
            $statement .= " AND tags LIKE ?";
            $types .= "s";
        }
        $statement .= " LIMIT 10 OFFSET ?";
        $types .= "i";
        array_push($tag_array, $client_ammount);
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
    else if ($contains_term && !$contains_tags) {
        $param = "%".$_GET["search_term"]."%";
        $stmt = $conn->prepare("SELECT id,question,client,year,rating FROM tendors WHERE client LIKE ? LIMIT 10 OFFSET ?");
        $stmt->bind_param("si", $param, $client_ammount);
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