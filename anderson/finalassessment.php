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
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Final Assessment</title>
		<script src="javascript/log.js"></script>
		<script src="javascript/jsPDF/dist/jspdf.debug.js"></script>
		<script>
			var textarea=["txt6a", "txt6b", "txt6c",
						"txt7a", "txt7b", "txt7c",
						"txt8a", "txt8b", "txt8c"];
			var c = 0;
			var t;
			var timer_is_on = 1;
			var assessmentTime=[];
			var log = new Array();
			var submitLog = false;
			var startTime = new Date();
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
			function timedCount() {
				document.getElementById("start").style.visibility="hidden";
				document.getElementById("time").value = c;
				c = c + 1;
				t = setTimeout(function(){timedCount()}, 1000);
				if (!timer_is_on) {
					timer_is_on = 1;
					timedCount();
				}
			}
			function submit(){
				assessmentTime.push(c);
				clearTimeout(t);
				submitLog = true;
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null','<?php echo $sessionID;?>']);
				logIntoServer(log);
				for(i=9;i<=10;i++){
					var canvas = document.getElementById(i+'bcanvas');
					if(canvas.title!=""){
						blob = canvas.toDataURL("image/jpeg",.7);
						//blob = canvas.toDataURL("image/jpeg",.7).replace(/^data:image\/(png|jpeg);base64,/, "");
						uploadFile(canvas.title,blob);	
					}
				}
/* 				for(i=9;i<=10;i++){
					var file = document.getElementById(i+'b').files[0];
					var canvas = document.getElementById(i+'bcanvas');
					if (file) {
						var fileReader = new FileReader();
						fileReader.onload = function(){
							var blob = fileReader.result;
							var img = new Image();
							img.onload = function () {
								canvas.getContext('2d').drawImage(img,0,0,800,800);
								blob = canvas.toDataURL("image/jpeg",.7).replace(/^data:image\/(png|jpeg);base64,/, "");
								uploadFile(img.alt,blob);
							}
							img.alt=filename;
							img.src = blob;
							canvas.width=800;
							canvas.height=800;
						};
						fileReader.readAsDataURL(file);
					}
				}
 */				log = [];
				logProgress(<?php echo $subj;?>,<?php echo $userID;?>,<?php echo $phaseID;?>);
				document.getElementById("timer").style.visibility="hidden";
				document.getElementById("question").style.visibility="hidden";
				document.getElementById('message').innerHTML ="Well Done! You have come to the end of the course. Hope you enjoy the online lesson.<br> Your duration is "+assessmentTime[assessmentTime.length-1]+" seconds.";
			}
			function start(){
				document.getElementById("question").style.visibility="visible";
				timedCount();
			}
			function logMCQ(event){
				//`studentID`,`phaseID`,`time`,`actionType`,`correct`,`action`,`duration`,`target1`,`target2`
				var target = event.currentTarget.id;
				var questionID = target.substring(1,target.length-2);
				var choice = target.substring(target.length-1,target.length);
				var correct = document.getElementById('a'+questionID).value == event.currentTarget.value? 1:0;
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick',correct,'mcq_select','null',questionID,choice,'<?php echo $sessionID;?>']);
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
			function logOpenEnded(event){
				var target = event.currentTarget.id;
				var questionID = target.substring(2,target.length);
				var ans = document.getElementById(target).value;
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'keyPress','null','open_ended','null',questionID,ans,'<?php echo $sessionID;?>']);
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
			function loadCircuitApplet(){
				alert('Use the web applet to draw the circuit and save the file as jpeg and upload your answer with the Upload Button');
				window.open('http://webtronics.googlecode.com/svn/trunk/webtronics/schematic.html','_blank');
			}
			var tar = '';
			function logFileUpload(event){
				if(event.target.files[0]){
					file = event.target.files[0];
					filename = event.target.files[0].name;
					tar = event.target.id;
					log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'picture','null','upload','null',tar,filename,'<?php echo $sessionID;?>']);
					var fileReader = new FileReader();
					tar = event.target.id;
					fileReader.onload = function(){
						var blob = fileReader.result;
						var img = new Image();
						var canvas = document.getElementById(tar+'canvas');
						img.onload = function () {
							canvas.getContext('2d').drawImage(img,0,0,800,800);
							canvas.title=img.alt;
						};
						img.src = blob;
						img.alt=filename;
						canvas.width=800;
						canvas.height=800;
						canvas.style.display='block';
					};
					fileReader.readAsDataURL(file);
				}
 			}
		</script>
	<head/>
	<body background="images/finalassessment/FAbg.jpg" onload="logStartActivity()" onunload="logEndActivity()"><a id="top"></a>
		<img src="images/finalassessment/fa.png" width="450" height="150"></img>
		<h1>Congratulations you have come to the last phase of this program.</h1>
		<h2 id="message">Complete the questions below to complete the course.<br>This assessment will be timed.</h2>
		<p id="timer">Timer: 
			<input type="text" id="time" readonly>  
			<button type="button" id= "start" onclick="start()">Start</button>
		</p>
		<div id="question" style="visibility:hidden;">
			<?php
				try{
					$pstmt = $dbConn->prepare(
					'SELECT qns,ans,opt1,opt2,opt3,opt4,qID FROM QUESTIONDB WHERE phaseID = ? AND qnsType = "MCQ" ORDER BY RAND() LIMIT '.$final_mcqBankSize.';');
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
				for($i=0;$i<$rc;$i++){
					$pstmt->fetch(PDO::FETCH_ASSOC);
					echo '<div class="mcq" id="mcq'.$i.'"><p><b>Q'.($i+1).' '.$q.'</b></p>';
					echo '<input type="hidden" id="a'.$id.'" value="'.$a.'"></input>';
					echo '<input type="hidden" value="'.$id.'"></input>';
					if(strlen($opt1)>0){
						echo '<ol><input type="radio" name="q'.$id.'" id="q'.$id.'_1" onclick="logMCQ(event)" value="'.$opt1.'">'.$opt1.'</input></ol>';
					}
					if(strlen($opt2)>0){
						echo '<ol><input type="radio" name="q'.$id.'" id="q'.$id.'_2" onclick="logMCQ(event)" value="'.$opt2.'">'.$opt2.'</input></ol>';
					}
					if(strlen($opt3)>0){
						echo '<ol><input type="radio" name="q'.$id.'" id="q'.$id.'_3" onclick="logMCQ(event)" value="'.$opt3.'">'.$opt3.'</input></ol>';
					}
					if(strlen($opt4)>0){
						echo '<ol><input type="radio" name="q'.$id.'" id="q'.$id.'_4" onclick="logMCQ(event)" value="'.$opt4.'">'.$opt4.'</input></ol>';
					}
					echo '</div><br>';
				}
			?>
			<p id="q6a">Q6a. Table 1 shows the resistor color code table. With the aid of the color code table, </br>write down the values of each of the resistors R1, R2 and R3 shown in Figure 1. </br></p>
			<img id="pic6a1" src="images/finalassessment/resistance_parta1.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic6a2" src="images/finalassessment/resistance_parta2.jpg" width="250px" height="200px"></img><br>
			<textarea id= ="txt6a" placeholder="value of R1, R2 and R3:" rows="4" cols="50" onchange="logOpenEnded(event)"></textarea><br>
			<br>
			
			<p id="q6b">Q6b. Explain the purpose of the fourth color band on the resistor.</br></p>
			<img id="pic6b1"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic6b2"></img></br>
			<textarea id= ="txt6b" placeholder="" rows="4" cols="50" onchange="logOpenEnded(event)"></textarea><br>
			<br>
			
			<p id="q6c">Q6c. Using the values of R1, R2 and R3 in Figure 1.</br>
			Calculate the total resistance of the resistors connected as shown in Figure 2.</br></p>
			<img id="pic6c1" src="images/finalassessment/resistance_partc.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic6c2"></img></br>
			<textarea id= ="txt6c" placeholder="Total resistance:" rows="4" cols="50" onchange="logOpenEnded(event)"></textarea><br>
			<br>
			
			<p id="q7a">Q7a. Calculate the total resistance across AB in the following case.</br></p>
			<img id="pic7a1" src="images/finalassessment/calculateR_parta.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic7a2"></img></br>
			<textarea id= ="txt7a" placeholder="Total Resistance across AB:" rows="4" cols="50" onchange="logOpenEnded(event)"></textarea><br>
			<br>
			
			<p id="q7b">Q7b. Calculate the total resistance across AB in the following case.</br></p>
			<img id="pic7b1" src="images/finalassessment/calculateR_partb.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic7b2"></img></br>
			<textarea id= ="txt7b" placeholder="Total Resistance across AB:" rows="4" cols="50" onchange="logOpenEnded(event)"></textarea><br>
			<br>
			
			<p id="q7c">Q7c. Calculate the total resistance across AB in the following case.</br></p>
			<img id="pic7c1" src="images/finalassessment/calculateR_partc.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic7c2"></img></br>
			<textarea id= ="txt7c" placeholder="Total Resistance across AB:" rows="4" cols="50" onchange="logOpenEnded(event)"></textarea><br>
			<br>
			
			<p id="q8a">Q8a. Figure below shows a light-sensing circuit. When bright light is detected, the buzzer sounds.</br>Explain how the increase in the value of R affects the operation of the circuit.</br></p>
			<img id="pic8a1" src="images/finalassessment/LDRcircuit.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic8a2"></img></br>
			<textarea id= ="txt8a" placeholder="Effects of the increase in the value of R on circuit operation:" rows="4" cols="50" onchange="logOpenEnded(event)"></textarea><br>
			<br>
			
			<p id="q8b">Q8b. A potentiometer is sometimes used in a temperature sensing circuit.</br>State the purpose of the potentiometer in the circuit.</br></p>
			<img id="pic8b1"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic8b2"></img></br>
			<textarea id= ="txt8b" placeholder="Purpose of potentiometer:" rows="4" cols="50" onchange="logOpenEnded(event)"></textarea><br>
			<br>
			
			<p id="q8c">Q8c. State three situations in which the moisture detector maybe useful.</br></p>
			<img id="pic8c1"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic8c2"></img></br>
			<textarea id= ="txt8c" placeholder="Three situations are:" rows="4" cols="50" onchange="logOpenEnded(event)"></textarea><br>
			<br>
			
			<h3>Draw the circuit requested in the following question using the web applet and upload a picture of the circuit upon completion.</br>Then upload the image here.</br></h3>
			<p id="q9">Q9. The circuit diagram symbol shown in Figure below represents a single cell having an e.m.f. of 1.5V.</br>Draw the circuit diagram of a battery consisting of a number of these cells which will produce an e.m.f of 6V</br></p>
			<img id="pic9a" src="images/finalassessment/battery_symbol.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;
			<canvas id="9bcanvas" style="display:none;"></canvas></br>
			<input type="button" onclick="loadCircuitApplet();" value="Draw Circuit">
			<input type="file" id="9b" name="file9" value="Upload Answer" onchange="logFileUpload(event);">
			<br>
			<p id="q10">Q10. Complete the circuit such that if switch B or both switch A and C are closed, the bulb is lighted.</br></p>
			<img id="pic10a" src="images/finalassessment/circuit_joining.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;
			<canvas id="10bcanvas" style="display:none;"></canvas></br>
			<input type="button" onclick="loadCircuitApplet();" value="Draw Circuit">
			<input type="file" id="10b" name="file10" value="Upload Answer" onchange="logFileUpload(event);">
			<br>
			<button type="button" onclick="submit()"><a href="#top">Submit</a></button>
		</div>
	</body>
</html>