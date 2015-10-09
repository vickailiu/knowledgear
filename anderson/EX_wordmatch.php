<?php
session_start();
include('config.php');
$sessionID = session_id();
$phaseID = $_GET['phase'];
$userID = $_SESSION['id'];
$subj = $_SESSION['subject'];
if($userID == ''){
	echo '<script>alert("Invalid session. Please Login again.");top.location.href="../index.html";</script>';
}
$nextPage = $phase[$phaseID]['nextPage'];
?>
<html>
	<head>
		<meta charset='utf-8'>
		<title>Activity Four</title>
		<link rel="stylesheet" type="text/css" href="css/ex_wordmatch.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
		<script src="javascript/idle-timer.js"></script>
		<script src="javascript/log.js"></script>
		<script>
			var log = [];
			var correctCards;
			var submitLog = false;
			var isDropAtTarget = false;
			var startTime = new Date();
			var dd_sTime;
			var dd_eTime;
			var dd_dTime;
			var idle_sTime;
			var idle_eTime;
			var idle_dTime;
			$.idleTimer(5*60*1000);
			$(document).on("idle.idleTimer", function(){	
				idle_sTime = new Date();
			});
			$(document).on("active.idleTimer", function(){
				idle_eTime = new Date();
				idle_dTime = idle_eTime - idle_sTime;
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'idle','null','null',idle_dTime,'null','null','<?php echo $sessionID;?>']);
			});
			function init(){
				correctCards = 0;
				isDropAtTarget = false;
				correctCards = 0;
				$('#successMessage').hide();
				$('#cardPile').html('');
				$('#cardSlots').html('');
				var numbers = ['battery.jpg','switch.jpg','resistor.jpg','capacitor.jpg','bulb.jpg','NPN transistor.jpg','buzzer.jpg','LDR.jpg','thermistor.jpg','thyristor.jpg','potentiometer.jpg','555 IC.jpg'];
				numbers.sort(function(){ 
					return Math.random() - .5 
				});
				for(var i=0; i<12; i++){
					$('<div>' + '<img onmousedown="startMouseDown()" src="images/wordmatch/a4_words/' + numbers[i] + '" >' + '</div>').data('number', numbers[i]).attr('id', 'card'+numbers[i]).appendTo('#cardSlots').draggable({
						containment: '#content',
						stack: '#cardSlots div',
						cursor: 'move',
						revert: revertFunction
					});
				}
				var words = ['battery.jpg','switch.jpg','resistor.jpg','capacitor.jpg','bulb.jpg','NPN transistor.jpg','buzzer.jpg','LDR.jpg','thermistor.jpg','thyristor.jpg','potentiometer.jpg','555 IC.jpg'];
				words.sort(function(){ 
					return Math.random() - .5 
				});
				for(var i=0; i<12; i++){
					$('<div>' + '<img src="images/wordmatch/a4_symbols/' + words[i] + '" >' + '</div>').data('number', words[i]).appendTo('#cardPile').droppable({
						accept: '#cardSlots div',
						hoverClass: 'hovered',
						drop: handleCardDrop
					});
				}
				logStartActivity();
			}
			function revertFunction(event, ui){
				dd_eTime = new Date();
				dd_dTime = dd_eTime - dd_sTime;
				if(isDropAtTarget == false){
					var cardNumber = $(this).data('number');
					correct = 1;
					log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseDrag',correct,'null',dd_dTime,cardNumber,'null','<?php echo $sessionID;?>']);
				}
				isDropAtTarget = false;
				return true;	
			}
			function startMouseDown(){
				dd_sTime = new Date();	
			}
			function loadImages(imgArr){
				var randomNum = Math.floor(Math.random()*10);
				var randomPosition = Math.floor(Math.random()*10);
				if(randomPosition == 0){
					randomPosition += 1;
				}
				var position = 'output' + randomPosition.toString();
				document.getElementById(position).style.visibility="visible";
				document.getElementById(position).src = imgArr[randomNum];
				setTimeout(function(){document.getElementById(position).style.visibility="hidden";},1000);
				setTimeout(function(){loadImages(words);},1500); // call function every 1.5 sec
				return true;
			}
			function handleCardDrop(event, ui) {
				isDropAtTarget = true;
				var slotNumber = $(this).data('number');
				var cardNumber = ui.draggable.data('number');
				dd_eTime = new Date();
				dd_dTime = dd_eTime - dd_sTime;
				if (slotNumber == cardNumber) {
					ui.draggable.addClass('correct');
					ui.draggable.draggable('disable');
					$(this).droppable('disable');
					ui.draggable.position({ 
					of:$(this), my:'left top', at:'left top' 
					});
					ui.draggable.draggable('option', 'revert', false);
					correctCards++;
					log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseDrag',1,'null',dd_dTime,cardNumber,slotNumber,'<?php echo $sessionID;?>']);
				}else{
					log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseDrag',0,'null',dd_dTime,cardNumber,slotNumber,'<?php echo $sessionID;?>']);
				}
				if (correctCards == 12) {
					$('#successMessage').show();
				}
			}
			function logStartActivity(){
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(startTime),'start','null','null','null','null','null','<?php echo $sessionID;?>']);
			}
			function logEndActivity(){
				if(!submitLog){
					var cur = new Date();
					var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
					log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null','<?php echo $sessionID;?>']);
					logIntoServer(log);
					log = [];
				}
			}			
			function nextActivity(){
				submitLog = true;
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null','<?php echo $sessionID;?>']);
				logProgress(<?php echo $subj;?>,<?php echo $userID;?>,<?php echo $phaseID;?>);
				logIntoServer(log);
				log = [];
				location='<?php echo $nextPage;?>';
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
	</head>
	<body onload="init()" onunload="logEndActivity()">
		<center>Drag and drop the correct component with its symbol.</center><br>
		<div id="content">
			<div id="cardPile"> </div>
			<div id="cardSlots"> </div>
			<div id="successMessage">
				<h2 style="margin-bottom:5px;">You did it!</h2>
				<button id="endbutton" onclick="nextActivity()"><b>Next Activity</b></button>
				<button onclick="init()"><b>Play Again</b></button>
			</div>
		</div>
	</body>
</html>