<?php
session_start();
include('config.php');
include('conn.php');
$sessionID = session_id();
$phaseID = $_GET['phase'];
$userID = $_SESSION['id'];
$subj = $_SESSION['subject'];
if($userID == ''){
	echo '<script>alert("Invalid session. Please Login again.");top.location.href="../index.html";</script>';
}
$nextPage = $phase[$phaseID]['nextPage'];
$difficulty = $_GET['level'];
switch($difficulty){
	case 'easy':
		$bandNo = 4;
		break;
	case 'hard':
		$bandNo = 5;
		break;
}
$bandWidth = 100/$bandNo;
try{
	$pstmt = $dbConn->prepare(
	'SELECT qns,ans,qID FROM QUESTIONDB WHERE phaseID = '.$phaseID.' AND opt1 = "'.$difficulty.'" ORDER BY RAND() LIMIT '.$phase[$phaseID]['repeats'].';');
	$pstmt->execute();
	$pstmt->bindColumn(1,$q);
	$pstmt->bindColumn(2,$a);
	$pstmt->bindColumn(3,$qID);
	$pstmt->fetch(PDO::FETCH_ASSOC);
	$pstmt = $dbConn->prepare(
	'SELECT COUNT(*) FROM LOG WHERE phaseID = '.$phaseID.' and correct = 1 and actionType = "submit" and studentID = '.$userID);
	$pstmt->execute();
	$pstmt->bindColumn(1,$repeats);
	$pstmt->fetch(PDO::FETCH_ASSOC);
} 
catch (Exception $e) 
{
	echo '<p>error</p>';
	$fileName = basename($e->getFile(), ".php"); // Filename that trigger the exception
	$lineNumber = $e->getLine();         // Line number that triggers the exception
	die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Resistor</title>
		<script src="javascript/log.js"></script>
		<script>
			var correctAns = <?php echo $a;?>;
			var log = new Array();
			var startTime = new Date();
			var answer =[];
			var attempts = 3;
			var submitLog = false;
			function logStartPage(){
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(startTime),'start','null','null','null','null','null','<?php echo $sessionID;?>']);
			}
			function logEndActivity(){
				//if page close premature instead of next activity
				if(!submitLog){
					//log activity score
					var cur = new Date();
					var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
					log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null','<?php echo $sessionID;?>']);
					logIntoServer(log);
					log = [];
				}
			}
			function startActivity(){
				document.getElementById('exercise').style.display='inline';
				document.getElementById('start').disabled = true;
				document.getElementById('undo').style.display='inline';
				document.getElementById('submit').style.display='inline';
				document.getElementById('question').style.display="block";
				document.getElementsByTagName('Body')[0].scrollTop=document.getElementById('instruct').offsetHeight;
				timerStart();	
			}
			function timerStart() {
				document.getElementById("timer").textContent = document.getElementById("timer").textContent-1;
				if(document.getElementById("timer").textContent<=0){
					endSession();
				} else {
					t = setTimeout(function(){timerStart()}, 1000);
				}
			}
			function addAnswer(color){
				if(answer.length < <?php echo $bandNo;?>){
					answer.push(color);
					color == correctAns[answer.length-1]? correct = 1: correct=0;
					log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick',correct,'res_band_select','null',color,'null','<?php echo $sessionID;?>'])
				}
				updateImage();
			}
			function removeAnswer(){
				color = answer.pop();
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick',correct,'res_band_remove','null',color,'null','<?php echo $sessionID;?>'])
				updateImage();
			}
			function updateImage(){
				for(var i =0;i< <?php echo $bandNo; ?>;i++){
					if(typeof answer[i] != 'undefined'){
						document.getElementById('colorInput'+i).src = 'images/resistors/'+answer[i]+'_line.jpg';
						document.getElementById('colorInput'+i).style.display = 'block';
					} else {
						document.getElementById('colorInput'+i).src = '';
						document.getElementById('colorInput'+i).style.display = 'none';
					}
				}
			}
			function submitAnswer(){
				var allmatch = answer.length==<?php echo $bandNo; ?>?true:false;
				for(var i=0;i<answer.length;i++){
					if(answer[i]!=correctAns[i]){
						allmatch = false;
					}
				}
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				allmatch?correct=1:correct=0;
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'submit',correct,'null',duration,'null','null','<?php echo $sessionID;?>']);
				if(allmatch){
					clearTimeout(t);
					if(<?php echo $repeats?> < <?php echo $phase[$phaseID]['repeats']-1?>){
						document.getElementById('start').style.display = 'none';
						document.getElementById('undo').style.display = 'none';
						document.getElementById('submit').style.display = 'none';
						document.getElementById('PopupMessage').style.display = 'block';
						document.getElementById('PopupMessageMsg').textContent = "Let's try again to make sure\n you really understood!";
						document.getElementById('endbutton').style.display = 'none';
					} else {
						showNextActivity();
					}
				} else {
					if(attempts>0){
						alert("There is a mistake in the submission. Please check your answer again. "+attempts+" more tries left!");
						answer = [];
						updateImage();
					} else {
						alert("No attempts left. Please select another difficulty and attempt again.");
						//show answer and go back after 5 seconds
						window.history.back(); 
					}
					attempts--;
				}
			}
			function showNextActivity(){
				document.getElementById('start').style.display = 'none';
				document.getElementById('undo').style.display = 'none';
				document.getElementById('submit').style.display = 'none';
				document.getElementById('PopupMessage').style.display = 'block';
			}
			function nextActivity(){
				//log activity score
				submitLog = true;
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null','<?php echo $sessionID;?>']);
				logProgress(<?php echo $subj;?>,<?php echo $userID;?>,<?php echo $phaseID;?>);
				logIntoServer(log);
				log = [];
				location='<?php echo $nextPage;?>';
			}
			function retryActivity(){
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'end','null','reset','null','null','null','<?php echo $sessionID;?>']);
				location.href='<?php echo $phase[$phaseID-1]['nextPage'];?>';
			}
			function getHiddenProp(){
				var prefixes = ['webkit','moz','ms','o'];
				if ('hidden' in document) return 'hidden';
				for (var i = 0; i < prefixes.length; i++){
					if ((prefixes[i] + 'Hidden') in document) 
						return prefixes[i] + 'Hidden';
				}
				return null;
			}
			function isHidden() {
				var prop = getHiddenProp();
				if (!prop) return false;
					return document[prop];
			}
			var visProp = getHiddenProp();
			if (visProp) {
				var evtname = visProp.replace(/[H|h]idden/,'') + 'visibilitychange';
				document.addEventListener(evtname, visChange);
			}
			function visChange() {
				if (isHidden()){
					log.push([<?php echo $userID;?>,<?php echo $phaseID;?>,getSQLTimeString(new Date()),'inactive','null','null','null','null','null','<?php echo $sessionID;?>']);
				}
				else{
					log.push([<?php echo $userID;?>,<?php echo $phaseID;?>,getSQLTimeString(new Date()),'active','null','null','null','null','null','<?php echo $sessionID;?>']);
				}   
			}

		</script>
		<style>
			.bands {
				width:50px; 
				height:100px;
			}
			button {
				border: 0px solid;
				margin:10px;
				width:15%;
				height:50px;
				background-color:#BCA9F5;
				margin:3px 25px;
			}
			#PopupMessage {
				position: fixed;
				left: 18%;
				top: 33%;
				width: auto;
				height: 100px;
				z-index: 100;
				background: #dfd;
				border: 2px solid #333;
				border-radius: 10px;
				box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
				padding: 20px 40px;
				-moz-border-radius: 10px;
				-webkit-border-radius: 10px;
				-moz-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
				-webkit-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
			}	

		</style>
	<head/>
	<body style="min-width:830px;" onload="logStartPage()" onunload="logEndActivity()">
		<div>
			<div id='instruct'>
				<p style="font-size:120%;">In this exercise, you will learn about <b><?php echo $bandNo;?>-band resistor.</b> and how to read their values. </br>
				You have <b>5 minutes</b> and a total of <b>3 tries</b>.</br>
				The list on the right will serves as a guide.</br>
				Color bands can be added and removed by clicking on the color band or Undo button.</br>
				The required value will be given once you start the timer.</p>
				<button id="start" onclick="startActivity()">Start</button>
				<button id="undo" onclick="removeAnswer()" style="display:none;">Undo</button>
				<button id="submit" onclick="submitAnswer()" style="display:none;">Submit</button>
			</div>
			<div>
				<div style="float:right;width:40%;min-width:400px;margin:10px;">
					<img id="list" src="images/resistors/resistor_list.png" style="width:95%;height:auto;">
				</div>
				<p id="question" style="font-size:120%;display:none"> The required value of the resistor is <b><?php echo $q;?> </b>.</p>
				<p style="font-size:120%;">Timer: <label id="timer">300</label> seconds</p>
				<div id="exercise" style="display:none;width:60%">
					<table id="displayInput" style="background:url('images/resistors/resistor.png');background-size:100%;height:230px;width:409px;padding:74px 110px 100px 110px;">
						<tr>
							<?php
							for($i = 0;$i<$bandNo;$i++){
								echo '<td width="'.$bandWidth.'" ><img id= "colorInput'.$i.'" width="'.$bandWidth.'" height="53" style="display:none;" onclick="removeAnswer();"></td>';
							}
							?>
						</tr>
					</table>
					<table id="resistorBands">
						<tr>
							<td><img id= "black" class="bands" src="images/resistors/black_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "blue" class="bands" src="images/resistors/blue_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "brown" class="bands" src="images/resistors/brown_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "green" class="bands" src="images/resistors/green_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "silver" class="bands" src="images/resistors/silver_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "orange" class="bands" src="images/resistors/orange_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "red" class="bands" src="images/resistors/red_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "violet" class="bands" src="images/resistors/violet_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "white" class="bands" src="images/resistors/white_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "yellow" class="bands" src="images/resistors/yellow_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "gold" class="bands" src="images/resistors/gold_line.jpg" onclick="addAnswer(this.id)"></td>
							<td><img id= "grey" class="bands" src="images/resistors/grey_line.jpg" onclick="addAnswer(this.id)"></td>
						</tr>
					</table>
					<br><br>
				</div>
				<div id="PopupMessage" style="display:none;">
					<h2 style="margin-bottom:5px;text-align:center;" id="PopupMessageMsg">You did it!</h2>
					<button id="endbutton" onclick="nextActivity()" style="width:auto;background-color:#00CC66"><b>Next Activity</b></button>
					<button id="retrybutton" onclick="retryActivity()" style="width:auto;background-color:#00CC66"><b>Try a different difficulty?</b></button>
				</div>
			</div>
		</div>
	</body>
</html>


