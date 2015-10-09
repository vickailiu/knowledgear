<?php
session_start();
$id = $_SESSION['id'];
$phaseID = 1;
$num = $_GET['num'];
include('config.php');
$videoID = $video[$num];
?>

<!DOCTYPE html>
<html lang="en" style="height:95%;width:95%">
	<head>
		<meta charset="UTF-8" />
		<title>Introduction</title>
		<style>
			#start{
				border:0px solid;
				width:100px;
				height:50px;
				border-radius:3px;
				background-color:#819FF7;
				float:right;
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
					videoId: '<?php echo $videoID; ?>',
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
					log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick','null','video_start','null','null','null']);
				}
				if(player.getPlayerState()== YT.PlayerState.PAUSED && prevState == YT.PlayerState.PLAYING){
					//log pause video
					log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick','null','video_pause','null','null','null']);
				}
				prevState = player.getPlayerState();
			}
			function stopVideo() {
				//log stop video
				log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'mouseClick','null','video_stop','null','null','null']);
				player.stopVideo();
			}
			/* function checkLog(){
				alert(log);
			} */
			function logStartActivity(){
				log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(startTime),'start','null','null','null','null','null']);
			}
			function logEndActivity(){
				//if page close premature instead of next activity
				if(!submitLog){
					var cur = new Date();
					var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
					log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null']);
					logIntoServer(log);
				}
			}
			function nextActivity(){
				submitLog = true;
				var cur = new Date();
				var duration = 60*60*1000*(cur.getHours()-startTime.getHours())+60*1000*(cur.getMinutes()-startTime.getMinutes())+1000*(cur.getSeconds()-startTime.getSeconds())+(cur.getMilliseconds()-startTime.getMilliseconds());
				log.push([<?php echo $id?>,<?php echo $phaseID?>,getSQLTimeString(new Date()),'stop','null','null',duration,'null','null']);
				logIntoServer(log);
				location='p1_mcq.php';
			}
		</script>
	</head>
	<body style="height:100%;width:100%" onload="logStartActivity()" onunload="logEndActivity()">
		<div id="player" style="margin-left:10%;margin-right:10%"></div><br><br>
		<button id="start" onclick="nextActivity();">Next</button>
	</body>
</html>