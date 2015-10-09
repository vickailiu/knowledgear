<html>
<head>
<style>
body {
    background: url("images/phase04/p4_mcq/PG_4.jpg");
    background-size: 1349px 667px;
    background-repeat: no-repeat;
    background-attachment: fixed;
    padding-top: 40px;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script src="javascript/p4_mcq/quiz_functions.js"></script>
<script src="javascript/p4_mcq/quiz_config.js"></script>
<script src="javascript/idle-timer.js"></script>
<script src="javascript/moment.js"></script>
<script src="javascript/JSON/json2.js"></script>
<a href="p5_video.html">
<img src="images/phase04/p4_mcq/button.png" id="yourImgId" alt="Next" align="right" width="0" height="0"/></a>

<script>
var dataToJSON = '{"phase4_mcq":[';
// ----------------- For toDB -----------------
var studentId = "stud01";
var phase = "Four";

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
	logToDB(studentId, phase, "MCQ", getFormattedTime(), 'Idle', 'null', 'null', 'null', idle_dTime, 'null');
	//document.getElementById("docStatus").innerHTML = idle_eTime;
});
// End idle functions -------------------------------------------------
// get formatted current time (day/month/year/hour/minute/seconds/milliseconds)
function getFormattedTime(){
	var timestamp = moment().format('D/MM/YYYY/HH/mm/ss/SSS');
	return timestamp;
	//document.getElementById("docStatus").innerHTML = timestamp;
}
// Log into table
function logToDB(studentId, phase, activity, timestamp, actionType, action, target_1, target_2, duration, correct){
	
	/* To do
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
<body>
  <script type="text/javascript">
  <!--
    renderQuiz();
  //-->

  </script>
</div><p>
<!-- to do
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

<textarea rows="10" cols="30" id="docStatus" class="form-control"></textarea>
-->
</body>
</html>