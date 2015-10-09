<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Anderson D&T </title>
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
        <style>
			#workstation {
				padding: 5px;
				margin-left: 5px;
				width: 375%;
				height: 600px;
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
	<body class="cbp-spmenu-push">
		<div class="container">
			<header>
			<ul id="gn-menu" class="main gn-menu-main">
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
					<nav class="gn-menu-wrapper">
						<div class="gn-scroller">
							<ul class="gn-menu">
								<li>
									<a class="gn-icon gn-icon-archive">Introduction</a> <!-- phase 1 -->
									<ul class="gn-submenu">
										<li><a class="gn-icon gn-icon-videos" target="aFrame" href="p1_video.html">Video</a></li>
                                        					<li><a class="gn-icon gn-icon-article" target="aFrame" href="p1_mcq.html">MCQ</a></li>
									</ul>
								</li>
								<li>
									<a class="gn-icon gn-icon-archive">Circuit &amp; Components</a> <!-- phase 2 -->
									<ul class="gn-submenu">
										<li><a class="gn-icon gn-icon-videos" target="aFrame" href="p2_video.html">Video</a></li>
										<li><a class="gn-icon gn-icon-download" target="aFrame" href="p2_resistor.html">Activity</a></li>
										<li><a class="gn-icon gn-icon-article" target="aFrame" href="p2_mcq.html">MCQ</a></li>
									</ul>
								</li>
                                <li>
									<a class="gn-icon gn-icon-archive">Biopolar Transistors and Thyristors</a> <!-- phase 3 -->
									<ul class="gn-submenu">
										<li><a class="gn-icon gn-icon-videos" target="aFrame" href="p3_video.html">Video</a></li>
										<li><a class="gn-icon gn-icon-article" target="aFrame" href="p3_mcq.html">MCQ</a></li>
									</ul>
								</li>
                                <li>
									<a class="gn-icon gn-icon-archive">Construct Electrical Circuits</a> <!-- phase 4 -->
									<ul class="gn-submenu">
										<li><a class="gn-icon gn-icon-videos" target="aFrame">Video</a></li>
										<li><a class="gn-icon gn-icon-download" target="aFrame" href="p4_wordpic.html">Activity</a></li>
										<li><a class="gn-icon gn-icon-article" target="aFrame" href="p4_mcq.html">MCQ</a></li>
									</ul>
								</li>
                                <li>
									<a class="gn-icon gn-icon-archive">NPN Transistor</a> <!-- phase 5 -->
									<ul class="gn-submenu">
										<li><a class="gn-icon gn-icon-videos" target="aFrame" href="p5_video.html">Lab Video</a></li>
										<li><a class="gn-icon gn-icon-download" target="aFrame" href="p5_npn.html">Application Activity</a></li>
<!--										<li><a class="gn-icon gn-icon-article" target="aFrame">Circuit Building</a></li>
                                        <li><a class="gn-icon gn-icon-article" target="aFrame">Application</a></li> -->
									</ul>
								</li>
                                <li>
									<a class="gn-icon gn-icon-archive">555IC Timer Circuit</a> <!-- phase 6 -->
									<ul class="gn-submenu">
										<li><a class="gn-icon gn-icon-videos" target="aFrame" href="p6_video.html">Lab Video</a></li>
										<li><a class="gn-icon gn-icon-download" target="aFrame" href="p6_555.html">Application Activity</a></li>
<!--										<li><a class="gn-icon gn-icon-article" target="aFrame">Circuit Building</a></li>
                                        <li><a class="gn-icon gn-icon-article" target="aFrame">Application</a></li> -->
									</ul>
								</li>
                                <li>
									<a class="gn-icon gn-icon-archive">Final Assessment</a> <!-- phase 7 -->
									<ul class="gn-submenu">
										<li><a class="gn-icon gn-icon-article" target="aFrame" href="finalassessment.html">Final Assessment</a></li>
									</ul>
								</li>
							</ul>
						</div><!-- /gn-scroller -->
					</nav>
				</li>
				<li><a href="course.html" target="aFrame">Course</a></li>
				<li><a href="contact.html" target="aFrame"><span>Contact</span></a></li>
<!--		    <li><button id="showRight"><span>Notes</span></button></li> -->
				<li><form action="logOut.php" method="get">
				<input type="submit" value="Log Out"></form></li>
		        <li><a class="codrops-icon codrops-icon-drop" href="adminView.php" target="aFrame"><span>Admin</span></a></li>
				<li><a class="codrops-icon codrops-icon-drop" href="aboutUs.html" target="aFrame"><span>About Us</span></a></li>
			</ul>
				<h1>Learn Play Achieve <span>
                  Copyright &copy; <a href="#">DIP</a> 2014
				</span></h1>	
			</header>
            <div>
            <div style="float: left; padding-left: 4em;">
            	<iframe name="aFrame" id="workstation" src="welcomeEducator.html"> 
<!--                <script>
					$('#reload').click(function() {
			    	document.location.reload();
					});
				</script> -->
                </iframe>
            </div> 
         	<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="notes">
		   		<h2>Notes</h2>
<!--            		<script src="../ckeditor/ckeditor.js"></script> -->
					<textarea rows="27" cols="27">Notes here!
    		        </textarea>
	        	    <input type="submit" value="Submit" class="button">
					<input type="button" name="goback" value="Save to local">
            	<br>  &nbsp;
       		</div><!-- /note -->
            </div>
	</div><!-- /container -->
		<script src="javascript/framepage/classie.js"></script>
		<script src="javascript/framepage/gnmenu.js"></script>
		<script>
			new gnMenu( document.getElementById( 'gn-menu' ) );
		</script>
        <script>
			var	menuRight = document.getElementById( 'notes' ),
				showRight = document.getElementById( 'showRight' ),
				body = document.body;

			showRight.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( menuRight, 'cbp-spmenu-open' );
				disableOther( 'showRight' );
			};
			
			function disableOther( button ) {
				if( button !== 'showRight' ) {
					classie.toggle( showRight, 'disabled' );
				}
			}
		</script>
	</body>
</html>