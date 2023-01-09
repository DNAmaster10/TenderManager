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
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php"; ?>
        <div id="main_container">
            <input type="text" placeholder="Question" id="question_input">
            <input type="text" placeholder="Client" id="client_input">
            <input type="text" placeholder="Year" id="year_input">
            <textarea placeholder="Answer" id="answer_input" rows="5" cols="50"></textarea>
            <input type="text" placeholder="Tag" id="tag_input" onkeyup="getTags()">
            <div id="tag_button_container"></div>
            <div id="added_tag_button_container"></div>
            <input type="hidden" id="tag_list">
            <textarea placeholder="Additional Notes" id="additional_notes_input" rows="5" cols="50"></textarea>
            <button type="button" onclick="uploadInfo()">Submit</button>
            <p id="error"></p>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/pages/js/add.js"></script>
</html>