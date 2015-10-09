<?php
session_start();
$id = $_SESSION['id'];
$phaseID = 2;
include('conn.php');
include('config.php');
try{
	$pstmt = $dbConn->prepare(
	'SELECT qns,ans,opt1,opt2,opt3,opt4,qID FROM QUESTIONDB WHERE phaseID = ? ORDER BY RAND() LIMIT '.$mcqBankSize.';');
	$pstmt->execute(array(1));
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
<html onload="logStartActivity()" onunload="logEndActivity()">
	<head>
		<style>
			body {
				background: url("images/phase01/p1_mcq/PG_1.jpg");
				background-size: 100% 100%;
				background-repeat: no-repeat;
				background-attachment: fixed;
				padding-top: 40px;
			}
			button {
				border:0px solid;
				width:100px;
				height:50px;
				border-radius:3px;
				background-color:#819FF7;
				float:right;
				margin-right:5%
			}
		</style>
		<script type="text/javascript" src="javascript/p1_mcq/quiz_functions.js"></script>
		<script type="text/javascript" src="javascript/p1_mcq/quiz_config.js"></script>
		<script src="javascript/log.js"></script>
		<script>
			var log = new Array();
			var submitLog = false;
			var startTime = new Date();
			function showScore() {
				var radios=document.getElementsByTagName('input');
				var nchecked=0;
				var ncorrect=0;
				for(var i=0;i<<?php echo $mcqBankSize ?>;i++){
					var question = document.getElementById('question'+i);
					var choices = question.getElementsByTagName('input');
					//count correct,checked,set src img
					for(var j=2;j<choices.length;j++){
						if(choices[j].checked){
							nchecked++;
							var img = question.getElementsByTagName('img');
							if(choices[j].value===choices[0].value){
								ncorrect++;
								img[0].src="images/phase01/p1_mcq/correct.png";
							}
							else{
								img[0].src="images/phase01/p1_mcq/incorrect.gif";
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
					for(var i=0;i<<?php echo $mcqBankSize ?>;i++){
						var question = document.getElementById('question'+i);
						var img = question.getElementsByTagName('img');
						//reveal tick and cross
						img[0].style.display='inline';
						//disable radios
						var radios = document.getElementsByTagName('input');
						for(var j = 0; j<radios.length ; j++){
							if(radios[j].type === 'radio'){
								radios[j].disabled=true;
							}
						}
					}
					alert('You got '+ncorrect/nchecked*100+'% correct');
					document.getElementById('bt_next').style.display='inline';
					document.getElementById('bt_submit').style.display='none';
				}
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
				for(var i=0;i<<?php echo $mcqBankSize ?>;i++){
					var question = document.getElementById('question'+i);
					var img = question.getElementsByTagName('img');
					img[0].style.display='none';
				}
			}
			function logMCQ(event){
				//`studentID`,`phaseID`,`time`,`actionType`,`correct`,`action`,`duration`,`target1`,`target2`
				var target = event.currentTarget.id;
				var questionID = target.substring(1,target.length-2);
				var choice = target.substring(target.length-1,target.length);
				var correct = document.getElementById('a'+questionID).value == event.currentTarget.value? 1:0;
				log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick',correct,'mcq_select','null',questionID,choice]);
			}
			function logStartActivity(){
				log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(startTime),'start','null','null','null','null','null']);
			}
			function logEndActivity(){
				//if page close premature instead of next activity
				if(!submitLog){
					//log activity score
					var cur = new Date();
					var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
					log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null']);
					logIntoServer(log);
				}
			}			
			function nextActivity(){
				//log activity score
				submitLog = true;
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null']);
				logIntoServer(log);
				location='p2_video.php';
			}
			function submitHalfLog(){
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null']);
				logIntoServer(log);
				log = new Array();
			}
		</script>
	</head>
	<body>
		<div style="margin:3% 0% 3% 22%;padding-right:25%;height:80%;overflow-y:scroll;">
			<?php
				for($i=0;$i<$rc;$i++){
					$pstmt->fetch(PDO::FETCH_ASSOC);
					echo '<div class="questions" id="question'.$i.'"><p><b>'.$q.'</b><span><img class="tickcross" style="display:none"></span></p>';
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
					echo '</div>';
				}
			?>
			<br><p><button onclick="reset()" id="bt_reset">Reset</button><button onclick="nextActivity()" id="bt_next" style="display:none">Next</button><button id="bt_submit" onclick="showScore();submitHalfLog()">Submit</button></p>
		</div>
	</body>
</html>