<?php

//async sql query to db

include('conn.php');
//echo '<script>alert("'.$query.'")</script>';
if (isset($GLOBALS["HTTP_RAW_POST_DATA"]))
{
    // Get the data
    $query=$GLOBALS['HTTP_RAW_POST_DATA'];
	try{
		$pstmt = $dbConn->prepare($query);
		$pstmt->execute();
		// $rc = $pstmt->rowCount();
	}
	catch (Exception $e) 
	{
		$fileName = basename($e->getFile(), ".php"); // Filename that trigger the exception
		$lineNumber = $e->getLine();         // Line number that triggers the exception
		die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
	}
}
?>