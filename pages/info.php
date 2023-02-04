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
    
    if (isset($_SESSION["last_page"])) {
        $last_page = $_SESSION["last_page"];
    }
    $_SESSION["last_page"] = "info";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Info</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/info.css">
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php"; ?>
        <div id="main_container">
            <div id="action_button_container">
                <?php
                    if (isset($last_page) && $last_page == "/pages/search.php") {
                        echo (`
                        <form id="back_form" class="action_button_form" action="`.$last_page.`">
                            <input type="submit" id="back_button" value="Back" class="action_button">
                        </form>
                        `);
                    }
                ?>
                <form id="edit_form" class="action_button_form" method="GET" action="/pages/edit.php">
                    <input type="hidden" id="id_hidden_input" value="<?php echo($_GET["id"]); ?>" name="id">
                    <input type="submit" id="edit_button" value="Edit" class="action_button">
                </form>
            </div>
            <div id="info_container">
                <h2 id="question"><?php echo ($question); ?></h2>
                <div id="info_box">
                    <p id="rating_label" class="info_text"><b>Rating:</b>   <?php echo($rating_text); ?></p>
                    <p id="client_label" class="info_text"><b>Client:</b>   <?php echo($client); ?></p>
                    <p id="last_edited_label" class="info_text"><b>Last Edited By:</b>   <?php echo($uploader); ?></p>
                    <p id="tags_label" class="info_text"><b>Tags:</b> </p>
                    <div id="tag_container">
                        <?php
                            $tag_array = explode("#-#", $tags);
                            for ($i = 0; $i < count($tag_array); $i++) {
                                echo ("<p id='".$tag_array[$i]."_tag' class='tag'>".$tag_array[$i]."</p>");
                            }
                        ?>
                    </div>
                    <p id="notes_label" class="info_text"><b>Additional Notes:</b> </p>
                    <p id="notes_text"><?php echo($notes); ?></p>
                </div>
                <div id="answer_container">
                    <h3 id="answer_label">Answer: </h3>
                    <p id="answer_text"><?php echo($answer); ?></p>
                </div>
            </div>
        </div>
    </body>
</html>