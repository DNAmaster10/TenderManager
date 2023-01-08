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
            <input type="text" placeholder="Year" id="client_input">
            <textarea placeholder="answer" id="answer_input" rows="5" cols="50"></textarea>
        </div>
    </body>
</html>