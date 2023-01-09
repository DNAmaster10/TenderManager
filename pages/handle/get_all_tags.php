<?php
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";

    $return_string = "";

    $stmt = $conn->prepare("SELECT tag FROM tags");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $return_string = $return_string."#-#".$row["tag"];
    }
    if (strlen($return_string) < 1) {
        echo ("null");
    }
    else {
        echo ($return_string);
    }
