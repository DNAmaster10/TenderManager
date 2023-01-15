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
        <div id="main_container">
            <div id="search_box">
                <input type="text" id="search_input" onkeyup="submitSearch()">
                <label for="search_questions">Search Questions</label>
                <input type="checkbox" id="search_questions">
                <label for="search_tag">Search Tags</label>
                <input type="checkbox" id="search_tags">
                <label for="search_clients">Search Clients</label>
                <input type="checkbox" id="search_results">
                <div id="tags">
                    <input type="text" id="tag_input" placeholder="Add Tag">
                    <div id="tag_container"></div>
                    <div id="added_tag_container"></div>
                    <input type="hidded" id="tag_list">
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
</html>