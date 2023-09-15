<?php
	session_start();
	include $_SERVER["DOCUMENT_ROOT"]."/includes/dbh.php";
	include $_SERVER["DOCUMENT_ROOT"]."/includes/check_login.php";
?>
<html>
	<head>
		<link rel="stylesheet" href="/css/welcome.css">
	</head>
	<body>
		<h1>Welcome back <?php echo $_SESSION["username"]; ?></h1>
	</body>
</html>