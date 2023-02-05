<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error($error) {
        $_SESSION["generic_error"] = $error;
        header ("Location: /pages/error.php");
        die();
    }

    if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        error("Invalid ID");
    }

    //Check ID exists
    $id = intval($_GET["id"]);
    $stmt = $conn->prepapre("SELECT COUNT(*) FROM tendors WHERE id=?");
    $stmt->bind_param("i". $id);
    $stmt->execute();
    $stmt->bind_result($num_rows);
    $stmt->fetch();
    if ($num_rows < 1) {
        error("Invalid ID");
    }
    $stmt->close();
    unset($num_rows);

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
        <title>Add entry</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/add.css">
    </head>
    <body>
        <input type="hidden" id="id" value="<?php echo($_GET["id"]); ?>">
        <input type="hidden" id="old_rating" value="<?php echo(strval($rating)); ?>">
        <input type="hidden" id="old_tags" value="<?php echo($tags); ?>">
        <input type="hidden" id="old_answer" value="<?php echo($answer); ?>">
        <input type="hidden" id="old_notes" value="<?php echo($notes) ?>">
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php"; ?>
        <div id="main_container">
            <h2 id="essential_header" class="sub_head">Essential details</h2>
            <br>
            <input type="text" placeholder="Question" id="question_input" class="input_text" value="<?php echo($question); ?>">
            <textarea placeholder="Answer" id="answer_input" rows="5" cols="50" class="input_text"></textarea>
            <h2 id="optional_header" class="sub_head">Optional details</h2>
            <label for="client_input">Client: </label>
            <input type="text" placeholder="Client" id="client_input" class="input_text" value="<?php echo($client); ?>">
            <label for="year_input">Year: </label>
            <input type="text" placeholder="Year" id="year_input" class="input_text" value="<?php echo ($year); ?>">
            <textarea placeholder="Additional Notes" id="additional_notes_input" rows="5" cols="50" class="input_text"></textarea><br>
            <p>Rating: </p><br>
            <p id="1" class="star" value="1" onclick="updateStars(1)">★</p>
            <p id="2" class="star" value="2" onclick="updateStars(2)">☆</p>
            <p id="3" class="star" value="3" onclick="updateStars(3)">☆</p>
            <p id="4" class="star" value="4" onclick="updateStars(4)">☆</p>
            <p id="5" class="star" value="5" onclick="updateStars(5)">☆</p>
            <input type="hidden" name="rating" id="rating" value="1">
            <h3 id="tag_header" class="sub_head">Tags</h3>
            <input type="text" placeholder="Enter tag" id="tag_input" onkeyup="getTags()" class="input_text">
            <div id="tag_button_container"></div>
            <div id="added_tag_button_container"></div>
            <input type="hidden" id="tag_list" value="#-#">
            <button type="button" onclick="uploadInfo()">Submit</button>
            <p id="error"></p>
            <form action="/pages/remove.php" method="POST" id="delete_form">
                <input type="hidden" name="id" value="<?php echo($_GET["id"]); ?>">
                <input type="submit" value="Delete">
            </form>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/pages/js/edit.js"></script>
</html>