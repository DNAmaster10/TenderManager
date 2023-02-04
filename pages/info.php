<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error($error) {
        $_SESSION["generic_error"] = $error;
        header("Location: /pages/error.php");
        die();
    }

    if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        error("No ID was set");
    }

    $stmt = $conn->prepare("SELECT uploader,client,year,answer,tags,notes,rating,question FROM tendors WHERE id=?");
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $uploader = $row["uploader"];
        $client = $row["client"];
        $year = $row["year"];
        $answer = $row["answer"];
        $tags = $row["tags"];
        $notes = $row["notes"];
        $rating = $row["rating"];
        $question = $row["question"];
    }
    unset($result);
    $stmt->close();

    $rating = intval($rating);
    $rating_text = "";
    for ($i = 0; $i < $rating; $i++) {
        $rating_text .= "★";
    }
    for ($i = 0; $i < 5 - $rating; $i++) {
        $rating_text .= "☆";
    }

    $_SESSION["last_page"] = "info";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CHANGE LATER</title>
        <link rel="stylesheet" href="/css/main.css">
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php"; ?>
        <div id="main_container">
            <div id="action_button_container">
                <form id="back_form" class="action_button_form">
                    <input type="submit" id="back_button" value="Back" class="action_button">
                </form>
                <form id="edit_form" class="action_button_form">
                    <input type="submit" id="edit_button" value="Edit" class="action_button">
                </form>
            </div>
            <div id="info_container">
                <h2 id="question"><?php echo ($question); ?></h2>
                <div id="info_box">
                    <p id="rating_lavel" class="info_text">Rating: </p><p id="rating_text" class="info_text"><?php echo($rating_text); ?></p>
                    <p id="client_label" class="info_text">Client: </p><p id="client_text" class="info_text"><?php echo ($client); ?></p>
                    <p id="last_edited_label" class="info_text">Last Edited By: </p><p id="last_edited_text" class="info_text"><?php echo($uploader); ?></p>
                    <p id="tags_label" class="info_text">Tags: </p>
                    <div id="tag_container">
                        <?php
                            $tag_array = explode("#-#", $tags);
                            for ($i = 0; $i < count($tag_array); $i++) {
                                echo ("<p id='".$tag_array[$i]."_tag' class='tag'>".$tag_array[$i]."</p>");
                            }
                        ?>
                    </div>
                    <p id="notes_label" class="info_text">Additional Notes: </p>
                    <p id="notes_text"><?php echo($notes); ?></p>
                </div>
                <h3 id="answer_label">Answer: </h3>
                <p id="answer_text"><?php echo($answer); ?></p>
            </div>
        </div>
    </body>
</html>