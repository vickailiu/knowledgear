<?php
session_start();
include('conn.php');
include('config.php');
$sessionID = 1;
$phaseID = 1;
$userID = 1;
$subj = 1;
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
try{
	$pstmt = $dbConn->prepare('SELECT filename,file FROM UPLOAD;');
	$pstmt->execute();
	$pstmt->bindColumn(1,$filename);
	$pstmt->bindColumn(2,$file);
	//echo '<script>alert('.$filename.')</script>';
	//echo '<script>alert('.$file.')</script>';
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
				document.getElementById("timer").style.visibility="hidden";
				document.getElementById("question").style.visibility="hidden";
				document.getElementById('message').innerHTML ="Well Done! You have come to the end of the course. Hope you enjoy the online lesson.<br> Your duration is "+assessmentTime[assessmentTime.length-1]+" seconds.";
				clearTimeout(t);
				submitLog = true;
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null','<?php echo $sessionID;?>']);
				logIntoServer(log);
				//added
				for(i=9;i<=10;i++){
					var file = document.getElementById(i+'b').files[0];
				}
				log = [];
				logProgress(<?php echo $subj;?>,<?php echo $userID;?>,<?php echo $phaseID;?>);
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
				var questionID = target.substring(2,target.length-1);
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
				file = event.target.files[0];
				if (file) {
					var fileReader = new FileReader();
					tar = event.target.id;
					fileReader.onload = function(){
						//removed
						//var blob = fileReader.result.replace(/^data:image\/(png|jpeg);base64,/, "");
						/* var output = document.getElementById('t');
						output.src = dataURL; */
						//edited
						log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'picture','null','upload','null',tar,"null",'<?php echo $sessionID;?>']);
						tar = '';
					};
					fileReader.readAsDataURL(file);
				}
			}
			function loadPic(){
				var blob = '<?php echo $file?>';
				var img = new Image();
				var canvas = document.getElementById('pic_');
				img.onload = function () {
					canvas.getContext('2d').drawImage(img,0,0,800,800);
					canvas.title=img.alt;
				};
				img.src=blob;
				img.alt='<?php echo $filename?>';
				canvas.width=800;
				canvas.height=800;
			}
		</script>
	<head/>
	<body background="images/finalassessment/FAbg.jpg" onload="logStartActivity()" onunload="logEndActivity()"><a id="top"></a>
		<img src="images/finalassessment/fa.png" width="450" height="150"></img>
		<div id="question">
			<h3>Draw the circuit requested in the following question using the web applet and upload a picture of the circuit upon completion.</br>Then upload the image here.</br></h3>
			<p id="q9">Q9. The circuit diagram symbol shown in Figure below represents a single cell having an e.m.f. of 1.5V.</br>Draw the circuit diagram of a battery consisting of a number of these cells which will produce an e.m.f of 6V</br></p>
			<img id="pic9a" src="images/finalassessment/battery_symbol.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;
			<canvas id="9bcanvas" width="250px" height="200px"></canvas></br>
			<input type="button" onclick="loadCircuitApplet();" value="Draw Circuit">
			<input type="file" id="9b" name="file9" value="Upload Answer" onchange="logFileUpload(event);">
			<br>
			<p id="q10">Q10. Complete the circuit such that if switch B or both switch A and C are closed, the bulb is lighted.</br></p>
			<img id="pic10a" src="images/finalassessment/circuit_joining.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;
			<img id="10bcanvas" width="250px" height="200px"></img></br>
			<input type="button" onclick="loadCircuitApplet();" value="Draw Circuit">
			<input type="file" id="10b" name="file10" value="Upload Answer" onchange="logFileUpload(event);">
			<br>
			<button type="button" onclick="submit()"><a href="#top">Submit</a></button>
			
			<img id='t' width="250px" height="200px"/>
			
			<canvas height="800px" width="800px" id="pic_" onload="loadPic()"></canvas>
		</div>
	</body>
</html>