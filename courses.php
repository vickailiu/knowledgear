<?php
session_start();
$sessionID = session_id();
$userID = $_SESSION['id'];
include('anderson/conn.php');
try{
	$pstmt = $dbConn->prepare('SELECT SUBJECT.subjName,progress,home,SUBJECT.subjID FROM ENROL LEFT JOIN SUBJECT ON ENROL.subjID = SUBJECT.subjID WHERE studentID =?');
	$pstmt->execute(array($userID));
	$pstmt->bindColumn(1,$subj);
	$pstmt->bindColumn(2,$prog);
	$pstmt->bindColumn(3,$homelink);
	$pstmt->bindColumn(4,$subjID);
	$rc = $pstmt->rowCount();
}
catch (Exception $e) 
{
	$fileName = basename($e->getFile(), ".php");	// Filename that trigger the exception
	$lineNumber = $e->getLine();	// Line number that triggers the exception
	die("[$fileName][$lineNumber] Database error: " . $e->getMessage() . '<br />');
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<style>
			* {
				margin: 0;
				padding: 0;
				-moz-box-sizing: border-box;
				-o-box-sizing: border-box;
				-webkit-box-sizing: border-box;
				box-sizing: border-box;
			}
			ul {
				margin: 30px auto;
				text-align: center;
			}
			li {
				list-style: none;
				position: relative;
				display: inline-block;
				width: 100px;
				height: 100px;
				margin:auto 15px;
			}
			@-moz-keyframes rotate {
				0% {transform: rotate(0deg);}
				100% {transform: rotate(-360deg);}
			}
			@-webkit-keyframes rotate {
				0% {transform: rotate(0deg);}
				100% {transform: rotate(-360deg);}
			}
			@-o-keyframes rotate {
				0% {transform: rotate(0deg);}
				100% {transform: rotate(-360deg);}
			}
			@keyframes rotate {
				0% {transform: rotate(0deg);}
				100% {transform: rotate(-360deg);}
			}
			.round {
				display: block;
				position: absolute;
				left: 0;
				top: 0;
				width: 100%;
				height: 100%;
				padding-top: 30px;		
				text-decoration: none;		
				text-align: center;
				font-size: 100%;		
				text-shadow: 0 1px 0 rgba(255,255,255,.7);
				letter-spacing: -.065em;
				font-family: "Hammersmith One", sans-serif;		
				-webkit-transition: all .25s ease-in-out;
				-o-transition: all .25s ease-in-out;
				-moz-transition: all .25s ease-in-out;
				transition: all .25s ease-in-out;
				box-shadow: 2px 2px 7px rgba(0,0,0,.2);
				border-radius: 300px;
				z-index: 1;
				border-width: 4px;
				border-style: solid;
			}
			.round:hover {
				width: 130%;
				height: 130%;
				left: -15%;
				top: -15%;
				font-size: 33px;
				padding-top: 38px;
				-webkit-box-shadow: 5px 5px 10px rgba(0,0,0,.3);
				-o-box-shadow: 5px 5px 10px rgba(0,0,0,.3);
				-moz-box-shadow: 5px 5px 10px rgba(0,0,0,.3);
				box-shadow: 5px 5px 10px rgba(0,0,0,.3);
				z-index: 2;
				border-size: 10px;
				-webkit-transform: rotate(-360deg);
				-moz-transform: rotate(-360deg);
				-o-transform: rotate(-360deg);
				transform: rotate(-360deg);
			}
			a.red {
				background-color: rgba(239,57,50,1);
				color: rgba(133,32,28,1);
				border-color: rgba(133,32,28,.2);
			}
			a.red:hover {
				color: rgba(239,57,50,1);
			}
			a.green {
				background-color: rgba(1,151,171,1);
				color: rgba(0,63,71,1);
				border-color: rgba(0,63,71,.2);
			}
			a.green:hover {
				color: rgba(1,151,171,1);
			}
			.round span.round {
				display: block;
				opacity: 0;
				-webkit-transition: all .5s ease-in-out;
				-moz-transition: all .5s ease-in-out;
				-o-transition: all .5s ease-in-out;
				transition: all .5s ease-in-out;
				font-size: 1px;
				border: none;
				padding: 40% 20% 0 20%;
				color: #fff;
			}
			.round span:hover {
				opacity: .85;
				font-size: 16px;
				-webkit-text-shadow: 0 1px 1px rgba(0,0,0,.5);
				-moz-text-shadow: 0 1px 1px rgba(0,0,0,.5);
				-o-text-shadow: 0 1px 1px rgba(0,0,0,.5);
				text-shadow: 0 1px 1px rgba(0,0,0,.5);	
			}
			.green span {
				background: rgba(0,63,71,.7);		
			}
			.red span {
				background: rgba(133,32,28,.7);		
			}
		</style>
		<title>Knowledgear</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />		
		<link rel="stylesheet" type="text/css" href="anderson/css/frames.css"/>
		<script src="anderson/javascript/framepage/modernizr.custom.js"></script>
		<!--Start of Zopim Live Chat Script-->
		<script type="text/javascript">
		window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
		d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
		_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
		$.src="//v2.zopim.com/?33FXi5lhMrCnJQsuyteubUWrInOP7nra";z.t=+new Date;$.
		type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
		</script>
		<!--End of Zopim Live Chat Script-->
	</head>
	<body>
		<div class="container">
			<header>
				<h1>Learn Play Achieve<span style="font-size:50%;bold">Copyright &copy; DIP 2014</span></h1>
			</header>
			<div id="loginForm" style="padding:5%;">
				<?php
					for($i=0;$i<$rc;$i++){
						$pstmt->fetch(PDO::FETCH_ASSOC);
						echo '<li><a class="round green">'.$subj.'<span class="round" onclick="location.href=\''.$homelink.'?subject='.$subjID.'\'">Let\'s go!</span></a></li>';
					}
				?>
			</div>
		</div>
	</body>
</html>