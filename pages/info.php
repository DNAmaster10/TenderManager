<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error($error) {
        $_SESSION["generic_error"] = $error;
        header("Location: /pages/error.php");
        die();
    }

    if (!isset($_GET["id"])) {
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
                
            </div>
        </div>
    </body>
</html>