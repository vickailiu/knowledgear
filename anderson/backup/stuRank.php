<?php

include 'conn.php';

$pstmt = $dbConn->prepare('SELECT * FROM `student`');
$pstmt->execute();
$pstmt->bindColumn(1, $studentID);
$pstmt->bindColumn(2, $studentName);

echo "<!DOCTYPE html>\n"; 
echo "<html lang=\"en\" class=\"no-js\">\n"; 
echo "	<head>\n"; 
echo "		<meta charset=\"UTF-8\" />\n"; 
echo "		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\"> \n"; 
echo "		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"> \n"; 
echo "		<title>Anderson D&T \"Focus Group\"</title>\n"; 
echo "		<meta name=\"description\" content=\"A sidebar menu as seen on the Google Nexus 7 website\" />\n"; 
echo "		<meta name=\"keywords\" content=\"google nexus 7 menu, css transitions, sidebar, side menu, slide out menu\" />\n"; 
echo "		<meta name=\"author\" content=\"Codrops\" />\n"; 
echo "		<link rel=\"shortcut icon\" href=\"../favicon.ico\">\n"; 
echo "		<link rel=\"stylesheet\" type=\"text/css\" href=\"css/framepage/normalize.css\" />\n"; 
echo "\n"; 
echo "      	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/framepage/menu.css\" />\n"; 
echo "		<script src=\"javascript/framepage/modernizr.custom.js\"></script>\n"; 
echo "        <style>\n"; 
echo "			#workstation {\n"; 
echo "				padding: 5px;\n"; 
echo "				margin-left: 5px;\n"; 
echo "				width: 225%;\n"; 
echo "				height: 500px;\n"; 
echo "				background-color: #7c96b1;\n"; 
echo "				float: left;\n"; 
echo "						   \n"; 
echo "				border-radius: 5px;\n"; 
echo "				-moz-border-radius:5px;\n"; 
echo "				-webkit-border-radius:5px;\n"; 
echo "			}\n"; 
echo "			#notes { \n"; 
echo "					 padding-left: 10px;\n"; 
echo "					 margin-left: 20px;\n"; 
echo "					 margin-bottom: 10px;\n"; 
echo "					 background-color: #7c96b1;\n"; 
echo "					 width: 260px;\n"; 
echo "					 float:left;\n"; 
echo "					 					 \n"; 
echo "					 border: 1px solid #c6d0da;\n"; 
echo "					 border-radius:5px;\n"; 
echo "				     -moz-border-radius:5px;\n"; 
echo "				     -webkit-border-radius:5px;\n"; 
echo "			}\n"; 
echo "			#dropdown {\n"; 
echo "			    height:450px;\n"; 
echo "			    position:relative;\n"; 
echo "			    width:200%;\n"; 
echo "\n"; 
echo "			    border-radius:5px;\n"; 
echo "	    		-moz-border-radius:5px;\n"; 
echo "			    -webkit-border-radius:5px;\n"; 
echo "			}\n"; 
echo "		</style>\n"; 
echo "        <script type=\"text/javascript\">  <!-- dropdown -->\n"; 
echo "			function displaySubMenu(li) { \n"; 
echo "			var subMenu = li.getElementsByTagName(\"ul\")[0]; \n"; 
echo "			subMenu.style.display = \"block\"; \n"; 
echo "			} \n"; 
echo "			function hideSubMenu(li) { \n"; 
echo "			var subMenu = li.getElementsByTagName(\"ul\")[0]; \n"; 
echo "			subMenu.style.display = \"none\"; \n"; 
echo "			} \n"; 
echo "		</script>\n"; 
echo "	</head>\n"; 
echo "	<body>\n"; 
echo "    	<div>\n"; 
echo "        	<div style=\"float: left; padding-left: 30px; width: 600px;\">\n"; 
echo "                	<div>\n"; 
echo "					<p><a href=\"adminview.html\">admin</a> &gt; <a href=\"stuRank.html\">By Student Ranking</a>\n"; 
echo "					</div>\n"; 
echo "            	<p style=\"font-family: 'Lato', Arial, sans-serif; color: white;\"> \"Focus Group\" </p>\n"; 
echo "            	<div id=\"dropdown\">\n"; 
echo "                	<ul id=\"nav\">\n"; 

while ($pstmt->fetch()) {
	$pstmt1 = $dbConn->prepare('SELECT SUM(correct) FROM `log` WHERE `StudentID` = ?');
	$pstmt1->bindParam(1, $studentID, PDO::PARAM_INT);
	$pstmt1->execute();
	$pstmt1->bindColumn(1, $sum);
	$pstmt1->fetch();
	$pstmt1 = $dbConn->prepare('SELECT * FROM `log` WHERE `StudentID` = ?');
	$pstmt1->bindParam(1, $studentID, PDO::PARAM_INT);
	$pstmt1->execute();
	$tries = $pstmt1->rowCount();
	
	if ($sum*100/$tries<120) {
echo "                    	<li onmouseover=\"displaySubMenu(this)\" onmouseout=\"hideSubMenu(this)\" >",$studentName,"\n"; 
echo "                            <ul>\n"; 
echo "                            <li>score: ", $sum*100/$tries,"</li>\n"; 
echo "                        	</ul>\n"; 
echo "                        </li>\n"; }
}

echo "                    </ul>\n"; 
echo "               	</div>\n"; 
echo "            </div>\n"; 
echo "        </div>\n"; 
echo "	</body>\n"; 
echo "</html>\n";
?>