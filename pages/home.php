<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
    include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/home.css">
    </head>
    <body>
        <div id="main_container">
			<div id="sidebar">
				<button type="button" id="home_button" onclick="goHome()">Home</button>
				<button type="button" id="search_button" onclick="goSearch()">Search</button>
				<button type="button" id="add_entry_button" onclick="goEntry()">Add Entry</button>
				<button type="button" id="tags_button" onclick="goTags()">Tags</button>
				<button type="button" id="index_button" onclick="goIndex()">Index</button>
			</div>
			<div id="page_container">
				<iframe src="/pages/welcome.php" id="main_frame"></iframe>
			</div>
		</div>
    </body>
	<script src="/pages/js/home.js"></script>
</html>