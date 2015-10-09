<?php
session_start();
$userType=$_SESSION['type'];
$userID = $_SESSION['id'];
$_SESSION['subject'] = $_GET['subject'];
if($userID == ''){
	echo '<script>alert("Invalid session. Please Login again.");location.href="../index.html";</script>';
}
include('config.php');
include('conn.php');
try{
	$pstmt = $dbConn->prepare('SELECT max(phaseID) from PHASE where subjID = 1');
	$pstmt->execute(array($userID,$_SESSION['subject']));
	$pstmt->bindColumn(1,$max);
	$pstmt->fetch(PDO::FETCH_ASSOC);
	$pstmt = $dbConn->prepare('SELECT progress from ENROL where studentID = ? and subjID = ?');
	$pstmt->execute(array($userID,$_SESSION['subject']));
	$pstmt->bindColumn(1,$p);
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
<html lang="en" class="no-js" style="height:100%">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Anderson D&amp;T</title>
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/frames.css" />
		<link rel="stylesheet" type="text/css" href="css/frames1.css" />
		<script src="javascript/framepage/modernizr.custom.js"></script>
		<script src="javascript/framepage/classie.js"></script>
		<script src="javascript/framepage/gnmenu.js"></script>
		<script>
			function updateProgress(){
				var xmlhttp;	
				var progress = 1;
				if (window.XMLHttpRequest)
				{// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else
				{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.open("GET","ajax_2way.php?query=SELECT progress FROM ENROL WHERE studentID = "+<?php echo $userID?>+" AND subjID = "+<?php echo $_SESSION['subject']?>,false);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
						progress = parseInt(xmlhttp.responseText);
					}
				}
				xmlhttp.send();
				var phase = <?php echo json_encode($phase); ?>;
				j=progress;
				do{
					j++;
				}
				while((j)<<?php echo $max;?> && phase[j]==null)
				for(var i=1; i<=<?php echo $max;?>;i++){					
					if(i<=j){
						if (document.getElementById(i) !=null && document.getElementById(i).className.match(/(?:^|\s)disableMenuClick(?!\S)/)){
							document.getElementById(i).className =
							document.getElementById(i).className.replace( /(?:^|\s)disableMenuClick(?!\S)/g , '' )
							document.getElementById(i).style.color = '#5f6f81';
						}
					} else {
						if(document.getElementById(i) !=null){
							document.getElementById(i).className += ' disableMenuClick '; 
							document.getElementById(i).style.color = '#D0D6DC';							
						}
					}
				}
			}
		</script>
		<!--<script src="javascript/Countable.js"></script>
		<script src="javascript/FileSaver.js"></script>-->
        <style>
			#workstation {
				padding: 5px;
				margin-left: 5px;
				width:95%;
				height:80%;
				background-color: #7c96b1;
				float: left;
				border-radius: 5px
				-moz-border-radius:5px;
				-webkit-border-radius:5px;
			}
			#notes { 
				padding-left: 10px;
				margin-left: 20px;
				margin-bottom: 10px;
				background-color: #7c96b1;
				width: 180px;
				float:left;
				border: 1px solid #c6d0da;
				border-radius:5px;
				-moz-border-radius:5px;
				-webkit-border-radius:5px;
			}
		</style>
	</head>
	<body class="cbp-spmenu-push" style="height:100%" >
		<div class="container">
			<header><h1>Learn Play Achieve <span style="font-size:50%;bold">Copyright &copy; DIP 2014</span></h1></header>
			<ul id="gn-menu" class="main gn-menu-main" style="min-width:714px">
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu" onmouseover='updateProgress()' ><span>Menu</span></a>
					<nav class="gn-menu-wrapper">
						<div class="gn-scroller">
							<ul class="gn-menu" id='sideMenu'>
								<?php
									$curPhase = 1;
									function iconSelector($title){
										if(strpos($title,'Video') !== false){
											return 'gn-icon gn-icon-videos';
										}
										if(strpos($title,'MCQ') !== false){
											return 'gn-icon gn-icon-article';
										} else {
											return 'gn-icon gn-icon-download';
										}
									}
									for($i=0;$i<count($subphases);$i++){
										echo '<li><a class="gn-icon gn-icon-archive disableMenuClick">'.$subphases[$i]['title'].'</a><ul class="gn-submenu">';
										for($j=0;$j<$subphases[$i]['size'];$j++){
											echo '<li style="padding-left:5%"><a class="'.iconSelector($phase[$curPhase]['title']).'" target="aFrame" href="'.$phase[$curPhase]['url'].'" id="'.$curPhase.'";)>'.$phase[$curPhase]['title'].'</a></li>';
											$curPhase++;
											if($curPhase == 16){
												$curPhase = 25;
											}
										}
										echo '</ul></li>';
									}
								?>
							</ul>
						</div>
					</nav>
				</li>
				<li> 
				<?php
					if($userType=="student"){
						echo "<a href='welcomeStudent.php' target='aFrame'>Home</a></li>";
					} else if($userType=="teacher"){
						echo "<a href='welcomeAdmin.php' target='aFrame'>Home</a></li>";
					}
				?> 
				<li><a href="../courses.php" 					>Course</a></li>
				<?php
				if($userType=="student"){
					echo "<li style='visibility:hidden;'><button id='showRight'><span>Notes</span></button></li>";
				}
				?>
				<!--<li><a class="codrops-icon codrops-icon-prev" href="contact.html" target="aFrame"><span>Contact</span></a></li> -->
                <li><a class="codrops-icon codrops-icon-drop" href="aboutUs.html" target="aFrame"><span>About Us</span></a></li>
				<?php
				if($userType=="teacher"){
					echo "<li><a class='codrops-icon codrops-icon-drop' href='adminView.php' target='aFrame'><span>Admin</span></a></li>";
				}
				?>
				<li><form action="logout.php" method="post"><input type="submit" value="Logout"></form></li>
			</ul>
        </div>   
			<div style=" padding-left:4em;height:80%">
				<iframe id="workstation" name="aFrame" style="height:90%" 
				<?php
					if($userType=="student"){
						echo "src='welcomeStudent.php'";
					} else if($userType=="teacher"){
						echo "src='welcomeAdmin.php'";
					}
				?>></iframe>
			</div> 
			<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="notes">
				<h2>Notes</h2>
				<textarea id="txt_input" rows="27" cols="27" style="height:80%;resize:none;" autofocus placeholder="Take some notes here!"></textarea><br><br>
				<input type="submit" value="Save" class="button">
			</div>
        <script>
			new gnMenu( document.getElementById( 'gn-menu' ) );
			var	menuRight = document.getElementById( 'notes' ),
				showRight = document.getElementById( 'showRight' ),
				body = document.body;
				showRight.onclick = function() {
					classie.toggle( this, 'active' );
					classie.toggle( menuRight, 'cbp-spmenu-open' );
					disableOther( 'showRight' );
				};
			var area = document.getElementById('txt_input');
			var results = new Object();
			results.paragraphs = document.getElementById('para');
			results.words = document.getElementById('word');
			results.characters = document.getElementById('char');
			results.all = document.getElementById('cws');			
			function disableOther( button ) {
				if( button !== 'showRight' ) {
					classie.toggle( showRight, 'disabled' );
				}
			}
			function notesave(){
				var content = document.getElementById("txt_input").value;
				var blob = new Blob([content], {type: "text/plain;charset=utf-8"});
				saveAs(blob, "Notes.txt");
				//document.getElementById('txt_input').innerHTML = content + content + content;
				//alert(content);
			}
		</script>
	</body>
</html>