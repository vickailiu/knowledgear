<?php
	// Define the MySQL database parameters.
	// Avoid global variables (which live longer than necessary) for sensitive data.
	$DB_HOST = 'ntuedm.c0em9fik78su.ap-southeast-1.rds.amazonaws.com'; // MySQL server hostname
	$DB_PORT = '3306';      // MySQL server port number (default 3306)
	$DB_NAME = 'ntuedm';      // MySQL database name
	$DB_USER = 'school';   // MySQL username
	$DB_PASS = 'pass';      // password

	try{
		$dbConn = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME", $DB_USER, $DB_PASS);
		$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
	}
	catch (PDOException $e) 
	{
	   $fileName = basename($e->getFile(), ".php"); // Filename that trigger the exception
	   $lineNumber = $e->getLine();         // Line number that triggers the exception
	   die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
	}
?>