<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error($error) {
        echo ("error");
        die();
    }
    if (!isset($_GET["search_types"]) || strlen($_GET["search_types"] < 1)) {
        error("no search types set");
    }
    if (isset($_GET["tag_list"]) && strlen($_GET["tag_list"]) > 0 && $_GET["tag_list"] != "false") {
        $contains_tags = true;
        $tag_array = explode("#-#", $_GET["tag_list"]);
        for ($i = 0; $i < count($tag_array); $i++) {
            $tag_array[$i] = "%".$tag_array[$i]."%";
        }
    }
    else {
        $contains_tags = false;
    }
    if (isset($_GET["search_term"]) && strlen($_GET["search_term"]) > 0) {
        $contains_term = true;
    }
    else {
        $container_term = false;
    }
    if (!$container_term && !$contains_tags) {
        error("No search term or tag set");
    }
    //Format: #-#type@-@id-#-question#-#type@-@id-#-question#-#
    $return_string = "";
    $search_types = explode("#-#", $_GET["search_types"]);
    if ($contains_term) {
        if (in_array("questions", $search_types)) {
            if (!$contains_tags) {
                $param = strtoupper("%".$_GET["search_term"]."%");
                $stmt = $conn->prepare("SELECT id,question,client,year,rating FROM tendors WHERE question LIKE ?");
                $stmt->bind_param("s", $param);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $return_string .= "#-#question@-@".$row["id"]."-#-".$row["question"]."-#-".$row["client"]."-#-".$row["year"]."-#-".$row["rating"];
                }
                unset($result);
                $stmt->close();
            }
            else {
                $statement = "SELECT id,question,client,year,rating FROM tendors WHERE question LIKE ?";
                $types = "s";
                for ($i = 0; $i < count($tag_array); $i++) {
                    $statement .= " AND tags LIKE ?";
                    $types .= "s";
                }
                $search_array = $tag_array;
                array_unshift($search_array, "%".$_GET["search_term"]."%");
                $stmt = $conn->prepare($statement);
                $stmt->bind_param($types, ...$search_array);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $return_string .= "#-#question@-@".$row["id"]."-#-".$row["question"]."-#-".$row["client"]."-#-".$row["year"]."-#-".$row["rating"];
                }
                unset($result);
                $stmt->close();
            }
        }
        if (in_array("clients", $search_types)) {
            if (!$contains_tags) {
                $param = "%".$_GET["search_term"]."%";
                $stmt = $conn->prepare("SELECT id,question,client,year,rating FROM tendors WHERE client LIKE ?");
                $stmt->bind_param("s", $param);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $return_string .= "#-#clientn@-@".$row["id"]."-#-".$row["question"]."-#-".$row["client"]."-#-".$row["year"]."-#-".$row["rating"];
                }
                unset ($result);
                $stmt->close();
            }
            else {
                $statement = "SELECT id,question,client,year,rating FROM tendors WHERE client LIKE ?";
                $types = "s";
                $search_array = $tag_array;
                for ($i = 0; $i < count($tag_array); $i++) {
                    $statement .= " AND tags LIKE ?";
                    $types .= "s";
                }
                array_unshift($search_array, "%".$_GET["search_term"]."%");
                $stmt = $conn->prepare($statement);
                $stmt->bind_param($types, ...$search_array);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $return_string .= "#-#client@-@".$row["id"]."-#-".$row["question"]."-#-".$row["client"]."-#-".$row["year"]."-#-".$row["rating"];
                }
                unset ($result);
                $stmt->close();
            }
        }
        echo ($return_string);
    }
    else if ($contains_tags && !$contains_term) {
        $statement = "SELECT id,question,client,year,rating FROM tendors WHERE tags LIKE ?";
        $types = "";
        for ($i = 1; $i < count($tag_array); $i++) {
            $statement .= " AND tags LIKE ?";
            $types .= "s";
        }
        $search_array = $tag_array;
        $stmt = $conn->prepare($statement);
        $stmt->bind_param($types, ...$search_array);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $return_string .= "#-#question@-@".$row["id"]."-#-".$row["question"]."-#-".$row["client"]."-#-".$row["year"]."-#-".$row["rating"];
        }
        unset($result);
        $stmt->close();
        echo ($return_string);
    }
    else {
        error("No tags or search terms set");
    }
?>