<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" class="no-js" style="height:100%">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Anderson D&T</title>
		<meta name="description" content="A sidebar menu as seen on the Google Nexus 7 website" />
		<meta name="keywords" content="google nexus 7 menu, css transitions, sidebar, side menu, slide out menu" />
		<meta name="author" content="Codrops" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/framepage/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/framepage/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/framepage/default.css" />
		<link rel="stylesheet" type="text/css" href="css/framepage/component.css" />
		<link rel="stylesheet" type="text/css" href="css/framepage/components.css" />
		<script src="javascript/framepage/modernizr.custom.js"></script>
		<script src="javascript/framepage/classie.js"></script>
		<script src="javascript/framepage/gnmenu.js"></script>
		<script src="javascript/Countable.js"></script>
		<script src="javascript/FileSaver.js"></script>
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
				width: 260px;
				float:left;
				border: 1px solid #c6d0da;
				border-radius:5px;
				-moz-border-radius:5px;
				-webkit-border-radius:5px;
			}
		</style>
	</head>
	<body class="cbp-spmenu-push" style="height:100%">
		<div class="container">
			<header><h1>Learn Play Achieve <span style="font-size:50%;bold">Copyright &copy; DIP 2014</span></h1></header>
			<ul id="gn-menu" class="main gn-menu-main" style="min-width:714px">
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
					<nav class="gn-menu-wrapper">
						<div class="gn-scroller">
							<ul class="gn-menu">
								<li>
									<a class="gn-icon gn-icon-archive">Introduction</a> <!-- phase 1 -->
									<ul class="gn-submenu">
										<li style="padding-left:5%"><a class="gn-icon gn-icon-videos" target="aFrame" href="p1_video.php">Video</a></li>
										<li style="padding-left:5%"><a class="gn-icon gn-icon-article" target="aFrame" href="p1_mcq.php">MCQ</a></li>
									</ul>
								</li>
								<li>
									<a class="gn-icon gn-icon-archive">Circuit &amp; Components</a> <!-- phase 2 -->
									<ul class="gn-submenu">
										<li style="padding-left:5%"><a class="gn-icon gn-icon-videos" target="aFrame" href="p2_video.php">Video</a></li>
										<li style="padding-left:5%"><a class="gn-icon gn-icon-download" target="aFrame" href="p2_resistor.php">Activity</a></li>
										<li style="padding-left:5%"><a class="gn-icon gn-icon-article" target="aFrame" href="p2_mcq.php">MCQ</a></li>
									</ul>
								</li>
                                <li>
									<a class="gn-icon gn-icon-archive">Biopolar Transistors and Thyristors</a> <!-- phase 3 -->
									<ul class="gn-submenu">
										<li style="padding-left:5%"><a class="gn-icon gn-icon-videos" target="aFrame" href="p3_video.php">Video</a></li>
										<li style="padding-left:5%"><a class="gn-icon gn-icon-article" target="aFrame" href="p3_mcq.php">MCQ</a></li>
									</ul>
								</li>
                                <li>
									<a class="gn-icon gn-icon-archive">Construct Electrical Circuits</a> <!-- phase 4 -->
									<ul class="gn-submenu">
										<li style="padding-left:5%"><a class="gn-icon gn-icon-videos" target="aFrame">Video</a></li>
										<li style="padding-left:5%"><a class="gn-icon gn-icon-download" target="aFrame" href="p4_wordpic.php">Activity</a></li>
										<li style="padding-left:5%"><a class="gn-icon gn-icon-article" target="aFrame" href="p4_mcq.php">MCQ</a></li>
									</ul>
								</li>
                                <li>
									<a class="gn-icon gn-icon-archive">NPN Transistor</a> <!-- phase 5 -->
									<ul class="gn-submenu">
										<li style="padding-left:5%"><a class="gn-icon gn-icon-videos" target="aFrame" href="p5_video.php">Lab Video</a></li>
										<li style="padding-left:5%"><a class="gn-icon gn-icon-download" target="aFrame" href="p5_npn.php">Application Activity</a></li>
<!--									<li style="padding-left:5%"><a class="gn-icon gn-icon-article" target="aFrame">Circuit Building</a></li>
                                        <li style="padding-left:5%"><a class="gn-icon gn-icon-article" target="aFrame">Application</a></li> -->
									</ul>
								</li>
                                <li>
									<a class="gn-icon gn-icon-archive">555IC Timer Circuit</a> <!-- phase 6 -->
									<ul class="gn-submenu">
										<li style="padding-left:5%"><a class="gn-icon gn-icon-videos" target="aFrame" href="p6_video.php">Lab Video</a></li>
										<li style="padding-left:5%"><a class="gn-icon gn-icon-download" target="aFrame" href="p6_555.php">Application Activity</a></li>
<!--									<li style="padding-left:5%"><a class="gn-icon gn-icon-article" target="aFrame">Circuit Building</a></li>
                                        <li style="padding-left:5%"><a class="gn-icon gn-icon-article" target="aFrame">Application</a></li> -->
									</ul>
								</li>
                                <li>
									<a class="gn-icon gn-icon-archive">Final Assessment</a> <!-- phase 7 -->
									<ul class="gn-submenu">
										<li style="padding-left:5%"><a class="gn-icon gn-icon-article" target="aFrame" href="finalassessment.php">Final Assessment 1</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</nav>
				</li>
				<li><a href="course.php" target="aFrame">Course</a></li>
				<li><button id="showRight"><span>Notes</span></button></li>
				<!--<li><a class="codrops-icon codrops-icon-prev" href="contact.html" target="aFrame"><span>Contact</span></a></li> -->
                <li><a class="codrops-icon codrops-icon-drop" href="aboutUs.html" target="aFrame"><span>About Us</span></a></li>
				<li><form action="logout.php" method="get"><input type="submit" value="Logout"></form></li>
			</ul>
        </div>   
			<div style=" padding-left:4em;height:85%">
				<iframe id="workstation" name="aFrame" src="welcomeStudent.php" style="height:90%"> </iframe>
				<!--<script type="text/javascript" language="javascript">
					function iFrameHeight() {
						var ifm= document.getElementById("workstation");
						var subWeb = document.frames ? document.frames["aFrame"].document:ifm.contentDocument;
						if(ifm != null && subWeb != null) {
						ifm.height = subWeb.body.scrollHeight;
						}
					}
				</script> -->
			</div> 
			<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="notes">
				<h2>Notes</h2>
				<textarea id="txt_input" rows="27" cols="27" style="height:80%;resize:none;" autofocus placeholder="Take some notes here!"></textarea><br><br>
				<input type="submit" value="Save" class="button">
				<!-- <input type="button" name="goback" value="Save to local" onclick="notesave();"> -->
				<!--<table border="1">
					<tr>
						<td>Paragraph</td>
						<td>Words</td>
						<td>Characters</td>
						<td>Characters w Space</td>
					</tr>
					<tr>
						<td id="para">0</td>
						<td id="word">0</td>
						<td id="char">0</td>
						<td id="cws">0</td>
					</tr>
				</table> -->
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
			Countable.live(area, function (counter) {
				if ('textContent' in document.body) {
					results.paragraphs.textContent = counter.paragraphs;
					results.words.textContent = counter.words;
					results.characters.textContent = counter.characters;
					results.all.textContent = counter.all;
				} else {
					results.paragraphs.innerText = counter.paragraphs;
					results.words.innerText = counter.words;
					results.characters.innerText = counter.characters;
					results.all.textContent = counter.all;
				}
			});
			
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