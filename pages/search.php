<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";
    if (isset($_SESSION["last_page"])) {
        if (strlen($_SESSION["last_page"]) < 1) {
            $last_page = "null";
            unset($_SESSION["last_page"]);
        }
        else {
            $last_page = $_SESSION["last_page"];
            unset($_SESSION["last_page"]);
        }
    }
    else {
        $last_page = "null";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Search</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/search.css">
    </head>
    <body>
        <input type="hidden" id="last_page" value="<?php echo ($last_page); ?>"> 
        <?php include $_SERVER["DOCUMENT_ROOT"]."/includes/header.php";         ?>
        <div id="main_container">
            <div id="search_box">
                <label for="search_input">Search Term: </label>
                <input type="text" id="search_input" onkeyup="submitSearch()" placeholder="Search Term">
                <div id="search_types_container">
                    <label for="search_questions">Search Questions</label>
                    <input type="checkbox" id="search_questions" onclick="submitSearch()">
                    <label for="search_clients">Search Clients</label>
                    <input type="checkbox" id="search_clients" onclick="submitSearch()">
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
                <h1 id="question_results_h" class="results_header">Questions</h1>
                <div id="question_results">

                </div>
                <h1 id="client_results_h" class="results_header">Clients</h1>
                <div id="client_results">

                </div>
            </div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/pages/js/search.js"></script>
</html>