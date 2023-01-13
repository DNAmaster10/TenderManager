<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";

    function error($error) {
        echo ("error:$error");
        die();
    }

    if (!isset($_GET["search_term"])) {
        error("no search term was set");
    }
    if (!isset($_GET["search_types"]) || strlen($_GET["search_types"] < 1)) {
        error("no search types set");
    }
    //Format: type@-@id-#-question-#-
    $return_string = "";
    $search_types = explode($_GET["search_types"], "#-#");
    if (in_array("questions", $search_types)) {

    }
?>