<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    $_SESSION["last_page"] = "/pages/list.php";

    $stmt = $conn->prepare("SELECT * FROM tendors");
    $stmt->execute();
    $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Index</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/list.css">
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php"; ?>
        <div id="main_container">
            <?php
                while ($row = $result->fetch_assoc()) {
                    $id = strval($row["id"]);
                    $question = $row["question"];
                    $rating = intval($row["rating"]);
                    $rating_text = "";
                    for ($i = 0; $i < $rating; $i++) {
                        $rating_text .= "★";
                    }
                    for ($i = 0; $i < 5 - $rating; $i++) {
                        $rating_text .= "☆";
                    }
                    echo ("<div class='link_container' onclick='window.location.href = `/pages/info.php?id=`$id`'>");
                    echo ("<p class='link_text'>$question</p><p class='rating_text'>$rating_text</p>");
                    echo ("</div>");
                }
            ?>
        </div>
    </body>
</html>