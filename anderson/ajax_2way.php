<?php
//async sql query to db

$query = $_GET['query'];
include('conn.php');
//echo '<script>alert("'.$query.'")</script>';

try{
	$pstmt = $dbConn->prepare($query);
	$pstmt->execute();
	// $rc = $pstmt->rowCount();
	$pstmt->bindColumn(1,$p);
	$pstmt->fetch(PDO::FETCH_ASSOC);
	echo $p;
}
catch (Exception $e) 
{
	$fileName = basename($e->getFile(), ".php"); // Filename that trigger the exception
	$lineNumber = $e->getLine();         // Line number that triggers the exception
	die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
}
?>