<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Search</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/search.css">
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php";         ?>
        <div id="main_container">
            <div id="search_box">
                <label for="search_input">Search Term: </label>
                <input type="text" id="search_input" onkeyup="submitSearch()" placeholder="Search Term">
                <div id="search_types_container">
                    <label for="search_questions">Search Questions</label>
                    <input type="checkbox" id="search_questions">
                    <label for="search_tag">Search Tags</label>
                    <input type="checkbox" id="search_tags">
                    <label for="search_clients">Search Clients</label>
                    <input type="checkbox" id="search_clients">
                </div>
                <div id="tags">
                    <label for="tag_input">Tag(s): </label>
                    <input type="text" id="tag_input" placeholder="Add Tag" onkeyup="getTags()">
                    <div id="tag_container"></div>
                    <div id="added_tag_container"></div>
                    <input type="hidden" id="tag_list">
                </div>
            </div>
            <div id="results_container">
                <div id="question_results">

                </div>
                <div id="tag_results">

                </div>
                <div id="client_results">

                </div>
            </div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/pages/js/search.js"></script>
</html>