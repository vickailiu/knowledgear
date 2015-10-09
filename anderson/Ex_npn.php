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
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>NPN transistor sensing circuit industry</title>
		<link rel="stylesheet" type="text/css" href="css/ex_npn.css">
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script src="javascript/log.js"></script>
		<script type="text/javascript">
			var industries = ["Factory","Manufacturer","School","Housing Estate","Natural Disaster","Traffic","Agriculture"];
			var indCodes = ['fac','manu','sch','hdb','ndMgt','traf','agri'];
			var costWeights = <?php echo $phase[$phaseID]['costWeights'];?>;
			var log = new Array();
			var submitLog = false;
			var startTime = new Date();
			google.load("visualization", "1", {packages:["corechart"]});
			google.setOnLoadCallback(drawChart);
			var max=100;
			function div_show(form)
			{
				var industry = form.id;
				document.getElementById(industry+'form').style.display = "block";
			}
			function div_hide(form)
			{
				var industry = form.id;
				document.getElementById(industry+'form').style.display = "none";
			}
			function submit()
			{
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'submit','null','null',duration,'null','null','<?php echo $sessionID;?>']);
				var qty =[];
				var total = 0;
				for(var i=0;i<indCodes.length;i++){
					if(parseInt(document.getElementById(indCodes[i]+'qty').value)<0||parseInt(document.getElementById(indCodes[i]+'qty').value)>max){
						document.getElementById(indCodes[i]+'qty').value =0;
					}
					qty[i]=parseInt(document.getElementById(indCodes[i]+'qty').value);
					total += qty[i];
				}
				if (total != max)
				{
					alert("You have to sell all 100 unit. Please edit your selection.");
				}
				else
				{
					document.getElementById('submitbutton').style.display = "none";
					document.getElementById('PopupMessage').style.display = "block";
					drawChart();
					document.getElementById('chart_div').style.display = "block";
					location.href="#chart_div";
					document.getElementById('information').innerHTML = "Scroll down to view result.</br>To Resell your product to improve your revenue, click on Return.</br> Click on End to continue.";
				}
			}
			function drawChart() {
				var revenue = [];
				var sum = 0;
				for(var i=0;i<indCodes.length;i++){
					revenue[i] = parseInt(document.getElementById(indCodes[i]+'qty').value)*costWeights[i];
					sum += revenue[i];
				}
				document.getElementById('PopupMessageMsg').textContent = "Your total revenue is $"+sum;
				var tablefields = [['Industry', 'Revenue($)']];
				for(var i=0;i<indCodes.length;i++){
					tablefields.push([industries[i],revenue[i]]);
				}
				var data = google.visualization.arrayToDataTable(tablefields);
				var options = {
					title: 'Revenue Distribution for NPN transistor light sensing circuit.',
					legend: { position: 'none' },
					width:800,
					height:625,
				};
				var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			}
			function retry(){
				for(var i=0;i<indCodes.length;i++){
					document.getElementById(indCodes[i]+'qty').value = 0;
				}
				document.getElementById('PopupMessage').style.display = "none";
				document.getElementById('submitbutton').style.display = "inline";
				document.getElementById('chart_div').style.display = "none";
				document.getElementById('information').innerHTML = "You are now a <?php echo $phase[$phaseID]['elect']?> manufacturer. You have "+max+" units of <?php echo $phase[$phaseID]['elect']?> in your inventory to sell to the different industries. Each industry is willing to pay a different unit price based on the importance of the <?php echo $phase[$phaseID]['elect']?> in their production. On the other hand, you want to provide for the different industries while maximizing profit. <br><br>Indicate the quantity of this component that you would like to sell to each industry.</h2></br>";
			}
			function logStartActivity(){
				document.getElementById('information').innerHTML = "You are now a <?php echo $phase[$phaseID]['elect']?> manufacturer. You have "+max+" units of <?php echo $phase[$phaseID]['elect']?> in your inventory to sell to the different industries. Each industry is willing to pay a different unit price based on the importance of the <?php echo $phase[$phaseID]['elect']?> in their production. On the other hand, you want to provide for the different industries while maximizing profit. <br><br>Indicate the quantity of this component that you would like to sell to each industry.</h2></br>";
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
			function valueChanged(textbox){
				log.push([<?php echo $userID;?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'keyPress','null','purchase_amt','null',textbox.id.substring(0,textbox.id.length-3),textbox.value,'<?php echo $sessionID;?>']);
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
			#PopupMessage {
				position: fixed;
				left: 30%;
				top: 5%;
				width: auto;
				height: 100px;
				z-index: 100;
				background: #dfd;
				border: 2px solid #333;
				border-radius: 10px;
				box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
				padding: 20px;
				-moz-border-radius: 10px;
				-webkit-border-radius: 10px;
				-moz-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
				-webkit-box-shadow: .3em .3em .5em rgba(0, 0, 0, .8);
			}	
		</style>
	</head>
	<body bgcolor="#CCCC99" id="main" onload="logStartActivity()" onunload="logEndActivity()">
		<div id="text">
			<p id= "information"></p>
			<button id="submitbutton" type="button" onclick="submit()">Submit</button>
		</div>
		<div id="map">
			<script>
				for(var i=0;i<indCodes.length;i++){
					document.write("<div id='"+indCodes[i]+"'onmouseover='div_show(this)' onmouseout='div_hide(this)'><form id='"+indCodes[i]+"form' style='display:none;'>Quantity to sell:<input type='number' id='"+indCodes[i]+"qty' value='0' style='width:80%' onchange='valueChanged(this)' onfocus='this.value = \"\"'/><br></form></div>");
				}
			</script>
		</div>
		<div id="chart_div" style="display:none;margin-top:20px;"></div>
		<div id="PopupMessage" style="display:none;">
			<h2 style="margin-bottom:5px;" id="PopupMessageMsg"></h2>
			<button id="endbutton" onclick="nextActivity()"><b>Next Activity</b></button>
			<button id="returnbutton" onclick="retry()"><b>Play Again</b></button>
		</div>
	</body>
</html>