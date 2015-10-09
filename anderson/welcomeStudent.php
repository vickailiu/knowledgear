<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Welcome!</title>
		<style>
		#start{
			float:right;
			margin:5%;
			border : 0px solid;
			width:100px;
			height:50px;
			border-radius:3px;
			background-color:#819FF7;
		}
		</style>
		<script>
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
	<head/>
	<body style="min-width:800px">
		<h1>Welcome Students to </h1></br>
		<img src="images/welcomepage/LPA.png" style="margin-left:10%;width:90%"></img>
		<div style="margin-left:10%;width:90%">
			<p> &nbsp;By the end of the online learning session, students should be able to: </p>
			<li> &nbsp;Give examples of conductors and insulators</li>
			<li> &nbsp;Define electric current and state its sources (dry cells, batteries)</li>
			<li> &nbsp;Understand and apply the units used to measure current, voltage, resistance and capacitance including multiple and sub-multiple units</li>
			<li> &nbsp;State the relationship between current, voltage and resistance (Ohms law)</li>
			<li> &nbsp;Recognise that the resistance of a circuit can be varied by arranging resistors in series or in parallel</li>
			<li> &nbsp;Understand the use of common components in electronics: filament bulbs, switches, resistors, 
				variable resistors, light-dependent resistors, light-emitting diode, capacitor, transistors, 
				thyristor, relays and solenoids, electric motors, stepper motors, integrated circuits (e.g.  555IC timer)</li>
			<li> &nbsp;Read simple electronic circuit diagrams and assemble simple electronic circuits</li>
			<li> &nbsp;use and modify timer circuits; sensing circuits for light, moisture and temperature for different applications</li>
			<button type="button" id="start" onclick="window.parent.document.getElementById('workstation').src='video.php?phase=1'">Proceed</button>
		</div>
	</body>
</html>