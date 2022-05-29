<?php
	define("HOST", "localhost");
	define("USER", "root");
	define("PASS", "root");
	define("DATABASE", "moviedb");
	// define("PORT", 3306);

	$conn = mysqli_connect(HOST,USER,PASS,DATABASE) or 
	die("Could not connected database!");
?>