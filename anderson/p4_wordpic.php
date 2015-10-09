<!doctype html>
<html>
<head>
<meta charset=utf-8>
<title>Activity Four</title>

<link rel="stylesheet" type="text/css" href="css/phase04/a4_style.css">
<a href="p4_mcq.html"><img src="images/phase04/wordpic/buttons/a4_nextButton.jpg" id="yourImgId" alt="Next" align="right" width="0" height="0"/></a>
<style>
table, td {
    border: 1px solid black;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script src="javascript/idle-timer.js"></script>
<script src="javascript/FileSaver.js"></script>
<script src="javascript/moment.js"></script>
<script src="javascript/JSON/json2.js"></script>

<script>

//get cookie
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
    }
    return "";
}

var $phdata;
var correctCards;
var noOfAttempt;	// To get number of wrong attempts
var dataToJSON = '{"activity4":[';
var isDropAtTarget = false;

// ----------------- For toDB -----------------
var studentId = getCookie("user");
console.log(document.cookie+"\n");
console.log(studentId+"\n");
var phase = 4;

// variable for drag and drop time taken
var dd_sTime;	// start time
var dd_eTime;	// end time
var dd_dTime;	// difference time

// variable for user idle-ing time
var idle_sTime;	// idle start time
var idle_eTime;	// idle end time
var idle_dTime;	// idle difference time

// idle functions ----------------------------------------------------
$.idleTimer(300000);	// set to idle after 5 minute
// when idle
$(document).on("idle.idleTimer", function(){	
	idle_sTime = new Date();
	//document.getElementById("docStatus").innerHTML = idle_sTime;
});
// when activate
$(document).on("active.idleTimer", function(){
	idle_eTime = new Date();
	idle_dTime = idle_eTime - idle_sTime;
	logToDB(studentId, phase, "WordPic", getFormattedTime(), 'Idle', 'null', 'null', 'null', idle_dTime, 'null');
	//document.getElementById("docStatus").innerHTML = idle_eTime;
});
// End idle functions -------------------------------------------------

// Start!
$(init);

// get formatted current time (day/month/year/hour/minute/seconds/milliseconds)
function getFormattedTime(){
	var timestamp = moment().format('D/MM/YYYY/HH/mm/ss/SSS');
	return timestamp;
	//document.getElementById("docStatus").innerHTML = timestamp;
}

// get current html page
function getCurrentHTMLPage(){
	var path = window.location.pathname;
	// split() separate the string if '/' is detect,
	// 	then store the split strings as array
	// pop() removes the last item from the array and return
	var htmlPageName = path.split("/").pop();	
	return htmlPageName;
	//document.getElementById("docStatus").innerHTML = htmlPageName;
}

function init(){
	// Ini all value
	correctCards = 0;
	noOfAttempt = 0;
	isDropAtTarget = false;
	dd_sTime = 0;	
	dd_eTime = 0;	
	dd_dTime = 0;	
	idle_sTime = 0;	
	idle_eTime = 0;	
	idle_dTime = 0;	
	
	dataToJSON = '{"activity4":[';
	
	//$('#logArea').hide();
	// Hide the success message
	$('#successMessage').hide();
	$('#successMessage').css({
		left: '580px',
		top: '250px',
		width: 0,
		height: 0
	});

	// Reset the game
	correctCards = 0;
	$('#cardPile').html('');
	$('#cardSlots').html('');

	// Create the pile of shuffled cards
	var numbers = ['battery.jpg',
				   'switch.jpg',
				   'resistor.jpg',			
				   'capacitor.jpg',
				   'bulb.jpg',
				   'NPN transistor.jpg',
				   'buzzer.jpg',
				   'LDR.jpg', 
				   'thermistor.jpg',
				   'thyristor.jpg',
				   'potentiometer.jpg',
				   '555 IC.jpg'];
					   
	numbers.sort(function(){ 
		return Math.random() - .5 
	});

	for(var i=0; i<12; i++){
		// onmousedown to get time the moment user clicked
		$('<div>' + '<img onmousedown="startTime()" src="images/phase04/wordpic/a4_words/' + numbers[i] + '" >' + '</div>').data('number', numbers[i]).attr('id', 'card'+numbers[i]).appendTo('#cardSlots').draggable({
		containment: '#content',
		stack: '#cardSlots div',
		cursor: 'move',
		revert: revertFunction
		});
	} // End for

	// Create the card slots
	var words = ['battery.jpg',
				 'switch.jpg',
				 'resistor.jpg',
				 'capacitor.jpg',
				 'bulb.jpg',
				 'NPN transistor.jpg',
				 'buzzer.jpg',
				 'LDR.jpg',
				 'thermistor.jpg',
				 'thyristor.jpg',
				 'potentiometer.jpg',
				 '555 IC.jpg'];
						
	words.sort(function(){ 
		return Math.random() - .5 
	});

	for(var i=0; i<12; i++){
		$('<div>' + '<img src="images/phase04/wordpic/a4_symbols/' + words[i] + '" >' + '</div>').data('number', words[i]).appendTo('#cardPile').droppable({
			accept: '#cardSlots div',
      		hoverClass: 'hovered',
      		drop: handleCardDrop
    	});
  	} // End for
} // End init()

function revertFunction(event, ui){
	dd_eTime = new Date();
	dd_dTime = dd_eTime - dd_sTime;
	if(isDropAtTarget == false){
		var cardNumber = $(this).data('number');
		//logAttempts(0, 0, 0, 0, 0);
		logToDB(studentId, phase, "WordPic", getFormattedTime(), 'Mouse', 'MouseDrag', cardNumber, 'null', dd_dTime, 'null');
	}
	isDropAtTarget = false;
	return true;	
}

function startTime(){
	dd_sTime = new Date();	
	//dataToJSON +=
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
}// End loadImages
	
function handleCardDrop(event, ui) {
	isDropAtTarget = true;
	var slotNumber = $(this).data('number');
	var cardNumber = ui.draggable.data('number');
	dd_eTime = new Date();
	dd_dTime = dd_eTime - dd_sTime;
	// Create log table
	
	// If the card was dropped to the correct slot,
	// change the card colour, position it directly
	// on top of the slot, and prevent it being dragged
	// again
	if (slotNumber == cardNumber) {
		ui.draggable.addClass('correct');
		ui.draggable.draggable('disable');
		$(this).droppable('disable');
		ui.draggable.position({ 
			of:$(this), my:'left top', at:'left top' 
		});
		ui.draggable.draggable('option', 'revert', false);
		correctCards++;
		var str = noOfAttempt += 1;

		logToDB(studentId, phase, "WordPic", getFormattedTime(), 'Mouse', 'MouseDrop', cardNumber, slotNumber, dd_dTime, 1);
	}else{
		// To log!
		// Get attempts
	  	var str = noOfAttempt += 1;
		//document.getElementById("test").innerHTML = str;
		// Get the wrong selection to wrong choice 
		//document.getElementById("ws").innerHTML = slotNumber; // Match
		//document.getElementById("wc").innerHTML = cardNumber; // Select
		
		//document.getElementById("logArea").innerHTML = logs;
		logToDB(studentId, phase, "WordPic", getFormattedTime(), 'Mouse', 'MouseDrop', cardNumber, slotNumber, dd_dTime, 0);
	}

	// If all the cards have been placed correctly then display a message
	// and reset the cards for another go
	if (correctCards == 12) {
		var yourImg = document.getElementById('yourImgId');
		yourImg.style.height = '122px';
		yourImg.style.width = '122px';
		$('#successMessage').show();
		$('#successMessage').animate({
			left: '450px',
			top: '2oopx',
			width: '400px',
			height: '100px',
			opacity: 1
		});
		dataToJSON += ']}';
		
		// For debug purpose
		//document.getElementById("docStatus").innerHTML = dataToJSON;
		
		var jsonStr = dataToJSON;
		// This need to be change whenever there's change of IP address
		window.open('toDB.php?parseTxt=' + jsonStr + '&activity=4');
	}else {
		dataToJSON += ',';
	} // End else
}// End handleCardDrop

// Log into table
function logToDB(studentId, phase, activity, timestamp, actionType, action, target_1, target_2, duration, correct){
	/* For debug use
	var tables = document.getElementById('toDBTable');
	tables.border = 1;
	var row = tables.insertRow();
	var col_studentId = row.insertCell(0);	
	var col_phase = row.insertCell(1);	
	var col_activity = row.insertCell(2);
	var col_timestamp = row.insertCell(3);
	var col_actionType = row.insertCell(4);
	var col_action = row.insertCell(5);	
	var col_target_1 = row.insertCell(6);	
	var col_target_2 = row.insertCell(7);	
	var col_duration = row.insertCell(8);	
	var col_correct = row.insertCell(9);
		
	col_studentId.innerHTML = studentId;	
	col_phase.innerHTML = phase;	
	col_activity.innerHTML = activity;
	col_timestamp.innerHTML = timestamp;
	col_actionType.innerHTML = actionType;
	col_action.innerHTML = action;	
	col_target_1.innerHTML = target_1;	
	col_target_2.innerHTML = target_2;	
	col_duration.innerHTML = duration;	
	col_correct.innerHTML = correct;
	*/
	// Log in JSON format
	dataToJSON += '{"studentId":"' + studentId + '", "phase":"' + phase + '", "activity":"' + activity + '", "timestamp":"' + timestamp + '", "actionType":"' + actionType + '", "action":"' + action + '", "target_1":"' + target_1 + '", "target_2":"' + target_2 + '", "duration":"' + duration + '", "correct":"' + correct + '"}';
} // End logToDB
</script>

</head>
<body onload="init();">
<center>Drag and drop the correct component with its symbol.</center><br>
<div id="content">
	<div id="cardPile"> </div>
	<div id="cardSlots"> </div>
	<div id="successMessage">
		<h2>You did it!</h2>
		<button onclick="init()">Play Again</button>
	</div>
</div>
<!-- For debug purpose -->
<!--
<table id="toDBTable">
	<tr>
    	<td style='width:100px'>StudentID: </td>
    	<td style='width:100px'>Phase: </td>
        <td style='width:100px'>Activity: </td>
		<td style='width:250px'>Timestamp: </td>
		<td style='width:100px'>ActionType: </td>
		<td style='width:100px'>Action: </td>
		<td style='width:100px'>Target_1: </td>
        <td style='width:100px'>Target_2: </td>
		<td style='width:100px'>Duration: </td>
        <td style='width:100px'>Correct: </td>
	</tr>
</table>

<p id="outlog"></p>
<textarea rows="10" cols="30" id="docStatus" class="form-control"></textarea>

<button id="btnShowTime" onMouseDown="getCurrentHTMLPage()">Show Time!</button>
-->
</body>
</html>