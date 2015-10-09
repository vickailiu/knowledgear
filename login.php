<?php
$user = $_POST['username'];
// $pw = md5($_POST['password']);
$pw = $_POST['password'];
include('anderson/conn.php');
try{
	$pstmt = $dbConn->prepare(
	'(SELECT StudentID as ID, StudentName as Name, "student" as Type, schoolID FROM STUDENT 
	WHERE StudentName = ? AND StudentPW = ?)
	UNION ALL 
	(SELECT TeacherID as ID,TeacherName as Name, "teacher" as Type, schoolID FROM TEACHER 
	WHERE TeacherName = ? AND TeacherPW = ?)');
	$pstmt->execute(array($user,$pw,$user,$pw));
	$pstmt->bindColumn(1,$id);
	$pstmt->bindColumn(2,$name);
	$pstmt->bindColumn(3,$type);
	$pstmt->bindColumn(4,$school);
	$pstmt->fetch(PDO::FETCH_ASSOC);
	$rc = $pstmt->rowCount();
}
catch (Exception $e) 
{
	$fileName = basename($e->getFile(), ".php"); // Filename that trigger the exception
	$lineNumber = $e->getLine();         // Line number that triggers the exception
	die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
}
session_start();
$_SESSION['id']=$id;
$_SESSION['type']=$type;
$_SESSION['name']=$name;
$_SESSION['schoolID']=$school;

if($rc>0) {
	/* switch($school){
		case 1:
			echo "<script type='text/javascript'>location.href='anderson/home.php'</script>";
			break;
		case 2:
			echo "<script type='text/javascript'>location.href='palmview/dashboard.php'</script>";
			break;
		default:
			echo "<script type='text/javascript'>alert('User not tagged to any school.');location.href='index.html'</script>";
			break;
	} */
	switch($type){
		case 'student':
			echo "<script type='text/javascript'>location='courses.php'</script>";
			break;
		case 'teacher':
			switch($school){
				case 1:
					echo "<script type='text/javascript'>location.href='anderson/home.php'</script>";
					break;
				case 2:
					echo "<script type='text/javascript'>location.href='palmview/dashboard.php'</script>";
					break;
			}
			break;
	}
} else {
	echo "<script type='text/javascript'>alert('User not found.');location.href='index.html'</script>";
}
?>