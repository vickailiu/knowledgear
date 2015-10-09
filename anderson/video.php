<?php
include('config.php');
include('conn.php');
session_start();
$sessionID = session_id();
$userID = $_SESSION['id'];
$subj = $_SESSION['subject'];
if($userID == ''){
	echo '<script>alert("Invalid session. Please Login again.");top.location.href="../index.html";</script>';
}
$phaseID = $_GET['phase'];
$nextPage = $phase[$phaseID]['nextPage'];
$videoID = $phase[$phaseID]['videoID'];
?>

<!DOCTYPE html>
<html lang="en" style="height:95%;width:95%">
	<head>
		<meta charset="UTF-8" />
		<title>Video Recording</title>
		<link rel="stylesheet" type="text/css" href="css/aframe.css" />
		<style>
			#start{
				margin-right:10%
			}
		</style>
		<script src="javascript/log.js"></script>
		<script>
			var log = new Array();
			var submitLog = false;
			var startTime = new Date();
			var tag = document.createElement('script');
			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);			
			var player;
			function onYouTubeIframeAPIReady() {
				player = new YT.Player('player', {
					height: '80%',
					width: '80%',
					videoId: '<?php echo $videoID;?>',
					events: {
					'onReady': onPlayerReady,
					'onStateChange': onPlayerStateChange,
					}
				});
			}
			// 4. The API will call this function when the video player is ready.
			function onPlayerReady(event) {
				event.target.playVideo();
			}
			// 5. The API calls this function when the player's state changes.
			//    The function indicates that when playing a video (state=1),
			//    the player should play for six seconds and then stop.
			var prevState;
			function onPlayerStateChange(event) {
				if(player.getPlayerState()== YT.PlayerState.PLAYING && (prevState == YT.PlayerState.PAUSED||prevState==YT.PlayerState.UNSTARTED)){
					//log start video
					log.push([<?php echo $userID?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick','null','video_start','null','null','null','<?php echo $sessionID;?>']);
				}
				if(player.getPlayerState()== YT.PlayerState.PAUSED && prevState == YT.PlayerState.PLAYING){
					//log pause video
					log.push([<?php echo $userID?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick','null','video_pause','null','null','null','<?php echo $sessionID;?>']);
				}
				prevState = player.getPlayerState();
			}
			function stopVideo() {
				//log stop video
				log.push([<?php echo $userID?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick','null','video_stop','null','null','null','<?php echo $sessionID;?>']);
				player.stopVideo();
			}
			function logStartActivity(){
				log.push([<?php echo $userID?>,<?php echo $phaseID?>,getSQLTimeString(startTime),'start','null','null','null','null','null','<?php echo $sessionID;?>']);
			}
			function logEndActivity(){
				//if page close premature instead of next activity
				if(!submitLog){
					var cur = new Date();
					var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
					log.push([<?php echo $userID?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null','<?php echo $sessionID;?>']);
					logIntoServer(log);
					log = [];
				}
			}
			function nextActivity(){
				submitLog = true;
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				log.push([<?php echo $userID?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null','<?php echo $sessionID;?>']);
				logIntoServer(log);
				logProgress(<?php echo $subj;?>,<?php echo $userID;?>,<?php echo $phaseID;?>);
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
	<body style="height:100%;width:100%" onload="logStartActivity()" onunload="logEndActivity()">
		<div id="player" style="margin-left:10%;margin-right:10%"></div><br><br>
		<button id="start" onclick="nextActivity();">Next</button>
	</body>
</html>