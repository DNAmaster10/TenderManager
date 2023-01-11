<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add entry</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/add.css">
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php"; ?>
        <div id="main_container">
            <h2 id="essential_header" class="sub_head">Essential details</h2>
            <br>
            <input type="text" placeholder="Question" id="question_input" class="input_text">
            <textarea placeholder="Answer" id="answer_input" rows="5" cols="50" class="input_text"></textarea>
            <h2 id="optional_header" class="sub_head">Optional details</h2>
            <label for="client_input">Client: </label>
            <input type="text" placeholder="Client" id="client_input" class="input_text">
            <label for="year_input">Year: </label>
            <input type="text" placeholder="Year" id="year_input" class="input_text">
            <textarea placeholder="Additional Notes" id="additional_notes_input" rows="5" cols="50" class="input_text"></textarea>
            <h3 id="tag_header" class="sub_head">Tags</h3>
            <input type="text" placeholder="Enter tag" id="tag_input" onkeyup="getTags()" class="input_text">
            <div id="tag_button_container"></div>
            <div id="added_tag_button_container"></div>
            <input type="hidden" id="tag_list">
            <button type="button" onclick="uploadInfo()">Submit</button>
            <p id="error"></p>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/pages/js/add.js"></script>
</html>