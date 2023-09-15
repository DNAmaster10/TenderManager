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
				
			</div>
			<div id="page_container">
				<iframe src="/pages/welcome.php"></iframe>
			</div>
		</div>
    </body>
</html>