<?php
//to support cross domain access
header("Access-Control-Allow-Origin: *");

$logs = json_decode($_POST['json']);
//$logs = json_decode(urldecode($_GET['json']));

// $logs is an array of arrays, prepare sql script
$sql = "";

foreach ($logs as $log) {
    $sql.= "INSERT INTO NEWSLOG(`studentID`,`actionType`,`action`,`time`,`duration`)VALUES('".$log[0]."','".$log[2]."','".$log[2]."','".$log[3]."','".$log[4]."');";
}

include('conn.php');
try{
	$pstmt = $dbConn->prepare($sql);
	$pstmt->execute();
	print('{}');
}
catch (Exception $e) 
{
	$fileName = basename($e->getFile(), ".php"); // Filename that trigger the exception
	$lineNumber = $e->getLine();         // Line number that triggers the exception
	die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
}
?>