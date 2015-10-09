<?php
session_start();
include('conn.php');
include('config.php');
$sessionID = session_id();
$phaseID = $_GET['phase'];
$userID = $_SESSION['id'];
$subj = $_SESSION['subject'];
if($userID == ''){
	echo '<script>alert("Invalid session. Please Login again.");top.location.href="../index.html";</script>';
}
$nextPage = $phase[$phaseID]['nextPage'];
$bg = $bg_png[rand(1,4)];
try{
	$pstmt = $dbConn->prepare(
	'SELECT qns,ans,opt1,opt2,opt3,opt4,qID FROM QUESTIONDB WHERE phaseID = ? ORDER BY RAND() LIMIT '.$mcqBankSize.';');
	$pstmt->execute(array($phaseID));
	$pstmt->bindColumn(1,$q);
	$pstmt->bindColumn(2,$a);
	$pstmt->bindColumn(3,$opt1);
	$pstmt->bindColumn(4,$opt2);
	$pstmt->bindColumn(5,$opt3);
	$pstmt->bindColumn(6,$opt4);
	$pstmt->bindColumn(7,$id);
	$rc = $pstmt->rowCount();
} 
catch (Exception $e) 
{
	echo '<p>error</p>';
	$fileName = basename($e->getFile(), ".php"); // Filename that trigger the exception
	$lineNumber = $e->getLine();         // Line number that triggers the exception
	die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/aframe.css" />
		<style>
			body {
				background: url("<?php echo $bg;?>");
				background-size: 100% 100%;
				background-repeat: no-repeat;
				background-attachment: fixed;
				padding-top: 40px;
			}
			.questionTable {
				border: 1px solid black;
				border-collapse:collapse;
				width:60%;
			}
			.questionTable th,td{
				border: 1px solid black;
				text-align:center;
				height:35px;
			}
			.questions {
				font-family: Arial,sans-serif;
				font-size: 18px;
			}
		</style>
<!--		<script type="text/javascript" src="javascript/p1_mcq/quiz_functions.js"></script>
		<script type="text/javascript" src="javascript/p1_mcq/quiz_config.js"></script> -->
		<script src="javascript/log.js"></script>
		<script src="javascript/jsPDF/dist/jspdf.debug.js"></script>
		<script>
			var log = new Array();
			var submitLog = false;
			var startTime = new Date();
			var completed = 'incomplete';
			function showScore() {
				var radios=document.getElementsByTagName('input');
				var nchecked=0;
				var ncorrect=<?php echo $rc ?>;
				for(var i=0;i<<?php echo $rc ?>;i++){
					var question = document.getElementById('question'+i);
					if(question != null){
						var choices = question.getElementsByTagName('input');
						//count correct,checked,set src img
						for(var j=2;j<choices.length;j++){
							if(choices[j].checked){
								nchecked++;
							}
						}
					}
				}
				//incomplete answer
				if(nchecked < <?php echo $rc?>) {
					alert("You have not answered all of the questions yet!");
					return false;
				}
				else{
					completed = 'complete';
					for(var i=0;i<<?php echo $rc ?>;i++){
						//reveal tick and cross
						var question = document.getElementById('question'+i);
						if(question != null){
							var choices = question.getElementsByTagName('input');
							//count correct,checked,set src img
							for(var j=2;j<choices.length;j++){
/* 								if(choices[j].checked){
									var img = question.getElementsByTagName('img');
									if(choices[j].value===choices[0].value){
										ncorrect++;
										img[j-2].src="images/mcq/correct.png";
									}
									else{
										img[j-2].src="images/mcq/incorrect.gif";
									}
									img[j-2].style.display='inline';
								} */	
								var img = question.getElementsByTagName('img');
								if(choices[j].value===choices[0].value){
									img[j-2].src="images/mcq/correct.png";
								} else {
									if(choices[j].checked){
										img[j-2].src="images/mcq/incorrect.gif";
										ncorrect--;
									}
								}
								img[j-2].style.display='inline';	
							}
						}
						//disable radios
						var radios = document.getElementsByTagName('input');
						for(var j = 0; j<radios.length ; j++){
							if(radios[j].type === 'radio'){
								radios[j].disabled=true;
							}
						}
					}
					document.getElementById('PopupMessageMsg').textContent = 'You got '+(ncorrect/nchecked*100).toFixed(2)+'% correct';
					document.getElementById('PopupMessage').style.display = 'block';
					document.getElementById('bt_next').style.display='inline';
					document.getElementById('bt_submit').style.display='none';
				}
				document.getElementById('container_mcq').scrollTop=0;
			}
			function closeWindow(){
				document.getElementById('PopupMessage').style.display = 'none';
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'end','null','review','null','null','null','<?php echo $sessionID;?>']);
			}
			function refreshWindow(){
				location='<?php echo $phase[$phaseID-1]['nextPage'];?>';
			}
			function reset(){
				var radios = document.getElementsByTagName('input');
				for(var i = 0; i<radios.length ; i++){
					if(radios[i].type === 'radio'){
						radios[i].checked=false;
						radios[i].disabled=false;
					}
				}
				document.getElementById('bt_next').style.display='none';
				document.getElementById('bt_submit').style.display='inline';
				for(var i=0;i<<?php echo $rc ?>;i++){
					var question = document.getElementById('question'+i);
					var img = question.getElementsByTagName('img');
					for(var j=0;j<img.length;j++){
						img[j].style.display='none';
					}
				}
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'end','null','reset','null','null','null','<?php echo $sessionID;?>']);
			}
			function logMCQ(event){
				//`studentID`,`phaseID`,`time`,`actionType`,`correct`,`action`,`duration`,`target1`,`target2`
				var target = event.currentTarget.id;
				var questionID = target.substring(1,target.length-2);
				var choice = target.substring(target.length-1,target.length);
				var correct = document.getElementById('a'+questionID).value == event.currentTarget.value? 1:0;
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick',correct,'mcq_select','null',questionID,choice,'<?php echo $sessionID;?>']);
			}
			function logStartActivity(){
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
			function submitHalfLog(){
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'submit','null',completed,duration,'null','null','<?php echo $sessionID;?>']);
				logIntoServer(log);
				log = [];
				log = new Array();
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
			function savetopdf() {
				var pdf = new jsPDF('p', 'pt', 'a4');
				pdf.setFontSize(18);
				pdf.setTextColor(0,0,0);
				var y = 40;
				var maxChar = 80;
				var maxLength = 700;
				pdf.text(<?php echo "'".$subphases[$phase[$phaseID]['phaseRef']]['title']."'"?>,30,y);
				y+=20;
				for(var i=0;i<<?php echo $mcqBankSize?>;i++){
					var question = document.getElementById('question'+i);
					pdf.setFontSize(14);
					pdf.setTextColor(0,0,0);
					y+=20;
					var text = question.getElementsByTagName('p')[0].textContent;
					for(var k=0;k<=Math.ceil(text.length/80);k++){
						pdf.text(text.substring(1,80),30,y);
						y+=20;
						text = text.substring(81,text.length);
					}					
					var opts = question.getElementsByTagName('ol');
					for(var j=0;j<opts.length;j++){
						pdf.setFontSize(12);
						if(opts[j].getElementsByTagName('img')[0].src.indexOf("correct.png")>-1){
							pdf.setTextColor(0,204,0);
						} else if(opts[j].getElementsByTagName('img')[0].src.indexOf("incorrect.gif")>-1){
							pdf.setTextColor(204,0,0);
						} else {
							pdf.setTextColor(0,0,0);
						}
						y+=20;
						pdf.text(opts[j].textContent,40,y);
					}
					y+=20;
					if(y>maxLength){
						pdf.addPage();
						y=40;
					}
				}
				pdf.save(<?php echo "'".$subphases[$phase[$phaseID]['phaseRef']]['title'].".pdf'"?>);
			}
		</script>
	</head>
	<body onload="logStartActivity()" onunload="logEndActivity()">
		<div style="margin:5% 0% 3% 22%;padding-right:25%;height:80%;overflow-y:scroll;" id="container_mcq">
			<?php
				for($i=0;$i<$rc;$i++){
					$pstmt->fetch(PDO::FETCH_ASSOC);
					echo '<div class="questions" id="question'.$i.'"><p><b>Q'.($i+1).' '.$q.'</b></p>';
					echo '<input type="hidden" id="a'.$id.'" value="'.$a.'"></input>';
					echo '<input type="hidden" value="'.$id.'"></input>';
					for($j=1;$j<5;$j++){
						if(strlen(${'opt'.$j})>0){
							echo '<ol><input type="radio" name="q'.$id.'" id="q'.$id.'_'.$j.'" onclick="logMCQ(event)" value="'.${'opt'.$j}.'">'.${'opt'.$j}.'</input><span><img class="tickcross" style="display:none"></span></ol>';
						}
					}
					echo '</div><br>';
				}
			?>
			<br><p><button onclick="reset()" id="bt_reset">Reset</button><button onclick="nextActivity()" id="bt_next" style="display:none">Next</button><button id="bt_submit" onclick="showScore();submitHalfLog()">Submit</button></p>
			<br><br>
			<div id="editor"></div>
		</div>
		<div id="PopupMessage" style="display:none;">
			<h2 style="margin:0px;text-align:center;" id="PopupMessageMsg"></h2>
			<button id="refreshbutton" onclick="refreshWindow()" style="width:auto;background-color:#00CC66"><b>More Questions</b></button>
			<button id="endbutton" onclick="nextActivity()" style="width:auto;background-color:#00CC66"><b>Next Activity</b></button>
			<button id="reviewbutton" onclick="closeWindow()" style="width:auto;background-color:#00CC66"><b>Review Answers</b></button>
			<button id="savebutton" onclick="savetopdf()" style="width:auto;background-color:#00CC66"><b>Save as PDF</b></button>
		</div>
	</body>
</html>