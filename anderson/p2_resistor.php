<?php
session_start();
$phaseID = $_GET['phase'];
$userID = $_SESSION['id'];
if($userID == ''){
	echo '<script>alert("Invalid session. Please Login again.");top.location.href="../index.html";</script>';
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/ex_resistors.css">
		<link rel="stylesheet" type="text/css" href="css/aframe.css" />
		<style>
		button{
			float:left;
			background-color:#00CC66;
			margin:3px 25px;
		}
		</style>
		<meta charset="utf-8">
		<title>Resistor Level Selection</title>
	<head/>
	<body>
		<div id="container" style="width:60%;height:100%;margin:10% 20% auto 20%;">
			<h2 style="color:#0B0B61;align:middle;">Select the level of difficulty for this activity.</br>Complete the task within the assigned time duration. The harder the level and shorter the time.</h2>
			<div style="margin-left:auto;margin-right:auto;width:100%">
				<button type="button" onclick="location.href='EX_resistors.php?level=easy&phase=<?php echo $phaseID;?>'">Easy</button>
				<!--<button type="button"><a href="EX_resistors.php?level=med">Medium</a></button>-->
				<button type="button" onclick="location.href='EX_resistors.php?level=hard&phase=<?php echo $phaseID;?>'">Hard</button>
			</div>
		</div>
	</body>
</html>