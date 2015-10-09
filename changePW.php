<?php
$user = $_POST['user'];
$old = $_POST['old'];
$new = $_POST['new'];
// $old = md5($_POST['old']);
// $new = md5($_POST['new']);

if(strlen(trim($user))<=0 || strlen(trim($_POST['old']))<=0 || strlen(trim($_POST['new']))<=0 || strlen(trim($_POST['new1']))<=0 ){
	echo "<script type='text/javascript'>alert('Missing fields.');location.href='changePW.html'</script>";
}
else if($_POST['new'] !=$_POST['new1']){
	echo "<script type='text/javascript'>alert('Password does not match. Returning to previous page.');location.href='changePW.html'</script>";
}
else{
	include('anderson/conn.php');
	$total = 0;
	try{
	$pstmt = $dbConn->prepare(
	"UPDATE TEACHER SET teacherPW='".$new."' WHERE teacherName='".$user."' AND teacherPW='".$old."';");
	$pstmt->execute();
	$total = $total + $pstmt->rowCount();
	}
	catch (Exception $e) 
	{
		$fileName = basename($e->getFile(), ".php"); // Filename that trigger the exception
		$lineNumber = $e->getLine();         // Line number that triggers the exception
		die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
	}
	try{
	$pstmt = $dbConn->prepare(
	"UPDATE STUDENT SET studentPW='".$new."' WHERE studentName='".$user."' AND studentPW='".$old."'");
	$pstmt->execute();
	$total = $total + $pstmt->rowCount();
	}
	catch (Exception $e) 
	{
		$fileName = basename($e->getFile(), ".php"); // Filename that trigger the exception
		$lineNumber = $e->getLine();         // Line number that triggers the exception
		die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
	}
}
if($total>0){
	echo "<script type='text/javascript'>alert('Password changed.');location.href='index.html'</script>";
}
else{
	echo "<script type='text/javascript'>alert('Failed. Please inform the administrator');location.href='index.html'</script>";
}
?>