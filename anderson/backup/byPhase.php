<?php
include 'conn.php';
$pstmt = $dbConn->prepare('SELECT * FROM `student`');
$pstmt->execute();
$total = $pstmt->rowCount();

$pstmt = $dbConn->prepare('SELECT DISTINCT `StudentID` FROM `log` WHERE `Phase` = ?');
$pstmt->bindParam(1, $phase, PDO::PARAM_INT);

$pstmt1 = $dbConn->prepare('SELECT DISTINCT `StudentID` FROM `log` WHERE `Phase` = ? AND `Activity` = ?');
$pstmt1->bindParam(1, $phase, PDO::PARAM_INT);
$pstmt1->bindParam(2, $activity, PDO::PARAM_STR);

$phase = 1;
$activity = 'MCQ_Q1';
$pstmt->execute();
$pstmt1->execute();
$completed = $pstmt->rowCount();
$finished = $pstmt1->rowCount();
echo "<!DOCTYPE html>\n";
echo "<html lang=\"en\" class=\"no-js\">\n"; 
echo "	<head>\n"; 
echo "		<meta charset=\"UTF-8\" />\n"; 
echo "		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\"> \n"; 
echo "		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"> \n"; 
echo "		<title>Anderson D&T </title>\n"; 
echo "		<meta name=\"description\" content=\"A sidebar menu as seen on the Google Nexus 7 website\" />\n"; 
echo "		<meta name=\"keywords\" content=\"google nexus 7 menu, css transitions, sidebar, side menu, slide out menu\" />\n"; 
echo "		<meta name=\"author\" content=\"Codrops\" />\n"; 
echo "		<link rel=\"shortcut icon\" href=\"../favicon.ico\">\n"; 
echo "		<link rel=\"stylesheet\" type=\"text/css\" href=\"css/framepage/normalize.css\" />\n"; 
echo "\n"; 
echo "      	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/framepage/menu.css\" />\n"; 
echo "		<script src=\"javascript/framepage/modernizr.custom.js\"></script>\n"; 
echo "		<script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>\n"; 
echo "  		<script type=\"text/javascript\">\n"; 
echo "	    	google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n"; 
echo "	    	google.setOnLoadCallback(drawChart);\n"; 
echo "			\n"; 
echo "		    function drawChart() {\n"; 
echo "	        	var data = google.visualization.arrayToDataTable([\n"; 
echo "    		      ['Task', 'Hours per Day'],\n"; 
echo "		          ['In Progress',     ",$completed-$finished,"],\n"; 
echo "        		  ['Completed',      ", $finished,"],\n"; 
echo "		          ['Yet to Start', ", $total-$completed, "]\n"; 
echo "        		]);\n"; 
echo "\n"; 
echo "	      		var options = {\n"; 
echo "		        title: 'Phase 1',\n"; 
echo "		        is3D: true,\n"; 
echo "				backgroundColor: 'transparent',\n"; 
echo "				colors: ['red', 'blue', 'yellow']\n"; 
echo "	        };\n"; 
echo "			\n"; 
echo "				\n"; 
echo "    	    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));\n"; 
echo "        	chart.draw(data, options);\n"; 
echo "			// Add our selection handler.\n"; 
echo "			google.visualization.events.addListener(chart, 'select', selectHandler);\n"; 
echo "\n"; 
echo "			// The selection handler.\n"; 
echo "			// Loop through all items in the selection and concatenate\n"; 
echo "			// a single message from all of them.\n"; 
echo "			function selectHandler() {\n"; 
echo "			    var selection = chart.getSelection();\n"; 
echo "				\n"; 
echo "			    for (var i = 0; i < selection.length; i++) {\n"; 
echo "			      var item = selection[i];\n"; 
echo "				  \n"; 
echo "				  switch(item.row) {\n"; 
echo "					  case 0:\n"; 
echo "	  				  window.location.href='inProgress.php?phase=1';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 1:\n"; 
echo "					  window.location.href='completed.php?phase=1';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 2:\n"; 
echo "					  window.location.href='yet to start.php?phase=1';\n"; 
echo "					  break;\n"; 
echo "				  }\n"; 
echo "				}\n"; 
echo "			}\n"; 
echo "		    }\n"; 
echo "	    </script> <!-- phase 1 pie chart -->\n"; 
echo "        <script type=\"text/javascript\">\n"; 
echo "	    	google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n"; 
echo "	    	google.setOnLoadCallback(drawChart);\n"; 
echo "			\n"; 
$phase = 2;
$activity = 'MCQ_Q2';
$pstmt->execute();
$pstmt1->execute();
$completed = $pstmt->rowCount();
$finished = $pstmt1->rowCount();
echo "		    function drawChart() {\n"; 
echo "	        	var data = google.visualization.arrayToDataTable([\n"; 
echo "    		      ['Task', 'Hours per Day'],\n"; 
echo "		          ['In Progress',     ", $completed-$finished,"],\n"; 
echo "        		  ['Completed',      ",$finished,"],\n"; 
echo "		          ['Yet to Start',  ",$total-$completed,"]\n"; 
echo "        		]);\n"; 
echo "\n"; 
echo "	      		var options = {\n"; 
echo "		        title: 'Phase 2',\n"; 
echo "		        is3D: true,\n"; 
echo "				backgroundColor: 'transparent',\n"; 
echo "				colors: ['red', 'blue', 'yellow']\n"; 
echo "				};\n"; 
echo "			\n"; 
echo "				\n"; 
echo "    	    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d2'));\n"; 
echo "        	chart.draw(data, options);\n"; 
echo "			// Add our selection handler.\n"; 
echo "			google.visualization.events.addListener(chart, 'select', selectHandler);\n"; 
echo "\n"; 
echo "			// The selection handler.\n"; 
echo "			// Loop through all items in the selection and concatenate\n"; 
echo "			// a single message from all of them.\n"; 
echo "			function selectHandler() {\n"; 
echo "			    var selection = chart.getSelection();\n"; 
echo "				\n"; 
echo "			    for (var i = 0; i < selection.length; i++) {\n"; 
echo "			      var item = selection[i];\n"; 
echo "				  \n"; 
echo "				  switch(item.row) {\n"; 
echo "					  case 0:\n"; 
echo "	  				  window.location.href='inProgress.php?phase=2';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 1:\n"; 
echo "					  window.location.href='completed.php?phase=2';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 2:\n"; 
echo "					  window.location.href='yet to start.php?phase=2';\n"; 
echo "					  break;\n"; 
echo "				  }\n"; 
echo "				}\n"; 
echo "			}\n"; 
echo "		    }\n"; 
echo "	    </script> <!-- phase 2 pie chart -->\n"; 
echo "        <script type=\"text/javascript\">\n"; 
echo "	    	google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n"; 
echo "	    	google.setOnLoadCallback(drawChart);\n"; 
echo "			\n"; 
$phase = 3;
$activity = 'MCQ_Q3';
$pstmt->execute();
$pstmt1->execute();
$finished = $pstmt1->rowCount();
$completed = $pstmt->rowCount();
echo "		    function drawChart() {\n"; 
echo "	        	var data = google.visualization.arrayToDataTable([\n"; 
echo "    		      ['Task', 'Hours per Day'],\n"; 
echo "		          ['In Progress',     ", $completed-$finished,"],\n"; 
echo "        		   ['Completed',      ", $finished,"],\n"; 
echo "		          ['Yet to Start',  ", $total-$completed, "]\n";
echo "        		]);\n"; 
echo "\n"; 
echo "	      		var options = {\n"; 
echo "		        title: 'Phase 3',\n"; 
echo "		        is3D: true,\n"; 
echo "				backgroundColor: 'transparent',\n"; 
echo "				colors: ['red', 'blue', 'yellow']\n"; 
echo "	        };\n"; 
echo "			\n"; 
echo "				\n"; 
echo "    	    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d3'));\n"; 
echo "        	chart.draw(data, options);\n"; 
echo "			// Add our selection handler.\n"; 
echo "			google.visualization.events.addListener(chart, 'select', selectHandler);\n"; 
echo "\n"; 
echo "			// The selection handler.\n"; 
echo "			// Loop through all items in the selection and concatenate\n"; 
echo "			// a single message from all of them.\n"; 
echo "			function selectHandler() {\n"; 
echo "			    var selection = chart.getSelection();\n"; 
echo "				\n"; 
echo "			    for (var i = 0; i < selection.length; i++) {\n"; 
echo "			      var item = selection[i];\n"; 
echo "				  \n"; 
echo "				  switch(item.row) {\n"; 
echo "					  case 0:\n"; 
echo "	  				  window.location.href='inProgress.php?phase=3';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 1:\n"; 
echo "					  window.location.href='completed.php?phase=3';\n";
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 2:\n"; 
echo "					  window.location.href='yet to start.php?phase=3';\n"; 
echo "					  break;\n"; 
echo "				  }\n"; 
echo "				}\n"; 
echo "			}\n"; 
echo "		    }\n"; 
echo "	    </script> <!-- phase 3 pie chart -->\n"; 
echo "		<script type=\"text/javascript\">\n"; 
echo "	    	google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n"; 
echo "	    	google.setOnLoadCallback(drawChart);\n"; 
echo "			\n"; 
$phase = 4;
$activity = 'MCQ_Q4';
$pstmt1->execute();
$finished = $pstmt1->rowCount();
$pstmt->execute();
$completed = $pstmt->rowCount();
echo "		    function drawChart() {\n"; 
echo "	        	var data = google.visualization.arrayToDataTable([\n"; 
echo "    		      ['Task', 'Hours per Day'],\n"; 
echo "		          ['In Progress',     ",$completed-$finished,"],\n"; 
echo "        		  ['Completed',      ",$finished,"],\n"; 
echo "		          ['Yet to Start',  ",$total-$completed,"]\n"; 
echo "        		]);\n"; 
echo "\n"; 
echo "	      		var options = {\n"; 
echo "		        title: 'Phase 4',\n"; 
echo "		        is3D: true,\n"; 
echo "				backgroundColor: 'transparent',\n"; 
echo "				colors: ['red', 'blue', 'yellow']\n"; 
echo "	        };\n"; 
echo "			\n"; 
echo "				\n"; 
echo "    	    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d4'));\n"; 
echo "        	chart.draw(data, options);\n"; 
echo "			// Add our selection handler.\n"; 
echo "			google.visualization.events.addListener(chart, 'select', selectHandler);\n"; 
echo "\n"; 
echo "			// The selection handler.\n"; 
echo "			// Loop through all items in the selection and concatenate\n"; 
echo "			// a single message from all of them.\n"; 
echo "			function selectHandler() {\n"; 
echo "			    var selection = chart.getSelection();\n"; 
echo "				\n"; 
echo "			    for (var i = 0; i < selection.length; i++) {\n"; 
echo "			      var item = selection[i];\n"; 
echo "				  \n"; 
echo "				  switch(item.row) {\n"; 
echo "					  case 0:\n"; 
echo "	  				  window.location.href='inProgress.php?phase=4';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 1:\n"; 
echo "					  window.location.href='completed.php?phase=4';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 2:\n"; 
echo "					  window.location.href='yet to start.php?phase=4';\n"; 
echo "					  break;\n"; 
echo "				  }\n"; 
echo "				}\n"; 
echo "			}\n"; 
echo "		    }\n"; 
echo "	    </script> <!-- phase 4 pie chart -->\n"; 
echo "        <script type=\"text/javascript\">\n"; 
echo "	    	google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n"; 
echo "	    	google.setOnLoadCallback(drawChart);\n"; 
echo "			\n"; 
$phase = 5;
$pstmt->execute();
$completed = $pstmt->rowCount();
echo "		    function drawChart() {\n"; 
echo "	        	var data = google.visualization.arrayToDataTable([\n"; 
echo "    		      ['Task', 'Hours per Day'],\n"; 
echo "		          ['In Progress',     11],\n"; 
echo "        		  ['Completed',      ", $finished,"],\n"; 
echo "		          ['Yet to Start',  ", $total-$completed,"]\n"; 
echo "        		]);\n"; 
echo "\n"; 
echo "	      		var options = {\n"; 
echo "		        title: 'Phase 5',\n"; 
echo "		        is3D: true,\n"; 
echo "				backgroundColor: 'transparent',\n"; 
echo "				colors: ['red', 'blue', 'yellow']\n"; 
echo "	        };\n"; 
echo "			\n"; 
echo "				\n"; 
echo "    	    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d5'));\n"; 
echo "        	chart.draw(data, options);\n"; 
echo "			// Add our selection handler.\n"; 
echo "			google.visualization.events.addListener(chart, 'select', selectHandler);\n"; 
echo "\n"; 
echo "			// The selection handler.\n"; 
echo "			// Loop through all items in the selection and concatenate\n"; 
echo "			// a single message from all of them.\n"; 
echo "			function selectHandler() {\n"; 
echo "			    var selection = chart.getSelection();\n"; 
echo "				\n"; 
echo "			    for (var i = 0; i < selection.length; i++) {\n"; 
echo "			      var item = selection[i];\n"; 
echo "				  \n"; 
echo "				  switch(item.row) {\n"; 
echo "					  case 0:\n"; 
echo "	  				  window.location.href='inProgress.php?phase=5';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 1:\n"; 
echo "					  window.location.href='completed.php?phase=5';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 2:\n"; 
echo "					  window.location.href='yet to start.php?phase=5';\n"; 
echo "					  break;\n"; 
echo "				  }\n"; 
echo "				}\n"; 
echo "			}\n"; 
echo "		    }\n"; 
echo "	    </script> <!-- phase 5 pie chart -->\n"; 
echo "        <script type=\"text/javascript\">\n"; 
echo "	    	google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n"; 
echo "	    	google.setOnLoadCallback(drawChart);\n"; 
echo "			\n"; 
$phase = 6;
$pstmt->execute();
$completed = $pstmt->rowCount();
echo "		    function drawChart() {\n"; 
echo "	        	var data = google.visualization.arrayToDataTable([\n"; 
echo "    		      ['Task', 'Hours per Day'],\n"; 
echo "		          ['In Progress',     11],\n"; 
echo "        		  ['Completed',      ", $finished,"],\n"; 
echo "		          ['Yet to Start',  ", $total-$completed,"]\n"; 
echo "        		]);\n"; 
echo "\n"; 
echo "	      		var options = {\n"; 
echo "		        title: 'Phase 6',\n"; 
echo "		        is3D: true,\n"; 
echo "				backgroundColor: 'transparent',\n"; 
echo "				colors: ['red', 'blue', 'yellow']\n"; 
echo "	        };\n"; 
echo "			\n"; 
echo "				\n"; 
echo "    	    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d6'));\n"; 
echo "        	chart.draw(data, options);\n"; 
echo "			// Add our selection handler.\n"; 
echo "			google.visualization.events.addListener(chart, 'select', selectHandler);\n"; 
echo "\n"; 
echo "			// The selection handler.\n"; 
echo "			// Loop through all items in the selection and concatenate\n"; 
echo "			// a single message from all of them.\n"; 
echo "			function selectHandler() {\n"; 
echo "			    var selection = chart.getSelection();\n"; 
echo "				\n"; 
echo "			    for (var i = 0; i < selection.length; i++) {\n"; 
echo "			      var item = selection[i];\n"; 
echo "				  \n"; 
echo "				  switch(item.row) {\n"; 
echo "					  case 0:\n"; 
echo "	  				  window.location.href='inProgress.php?phase=6';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 1:\n"; 
echo "					  window.location.href='completed.php?phase=6';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 2:\n"; 
echo "					  window.location.href='yet to start.php?phase=6';\n"; 
echo "					  break;\n"; 
echo "				  }\n"; 
echo "				}\n"; 
echo "			}\n"; 
echo "		    }\n"; 
echo "	    </script> <!-- phase 6 pie chart -->\n"; 
echo "        <script type=\"text/javascript\">\n"; 
echo "	    	google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});\n"; 
echo "	    	google.setOnLoadCallback(drawChart);\n"; 
echo "			\n"; 
$phase = 7;
$pstmt->execute();
$completed = $pstmt->rowCount();
echo "		    function drawChart() {\n"; 
echo "	        	var data = google.visualization.arrayToDataTable([\n"; 
echo "    		      ['Task', 'Hours per Day'],\n"; 
echo "		          ['In Progress',     11],\n"; 
echo "        		  ['Completed',      ", $finished,"],\n"; 
echo "		          ['Yet to Start',  ", $total-$completed,"]\n"; 
echo "        		]);\n"; 
echo "\n"; 
echo "	      		var options = {\n"; 
echo "		        title: 'Phase 7',\n"; 
echo "		        is3D: true,\n"; 
echo "				backgroundColor: 'transparent',\n"; 
echo "				colors: ['red', 'blue', 'yellow']\n"; 
echo "	        };\n"; 
echo "			\n"; 
echo "				\n"; 
echo "    	    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d7'));\n"; 
echo "        	chart.draw(data, options);\n"; 
echo "			// Add our selection handler.\n"; 
echo "			google.visualization.events.addListener(chart, 'select', selectHandler);\n"; 
echo "\n"; 
echo "			// The selection handler.\n"; 
echo "			// Loop through all items in the selection and concatenate\n"; 
echo "			// a single message from all of them.\n"; 
echo "			function selectHandler() {\n"; 
echo "			    var selection = chart.getSelection();\n"; 
echo "				\n"; 
echo "			    for (var i = 0; i < selection.length; i++) {\n"; 
echo "			      var item = selection[i];\n"; 
echo "				  \n"; 
echo "				  switch(item.row) {\n"; 
echo "					  case 0:\n"; 
echo "	  				  window.location.href='inProgress.php?phase=7';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 1:\n"; 
echo "					  window.location.href='completed.php?phase=7';\n"; 
echo "					  break;\n"; 
echo "					  \n"; 
echo "					  case 2:\n"; 
echo "					  window.location.href='yet to start.php?phase=7';\n"; 
echo "					  break;\n"; 
echo "				  }\n"; 
echo "				}\n"; 
echo "			}\n"; 
echo "		    }\n"; 
echo "	    </script> <!-- phase 7 pie chart -->\n"; 
echo "        <script type=\"text/javascript\">  <!-- dropdown -->
				function displaySubMenu(li) {  
					for(i=0;i<li.getElementsByTagName(\"svg\").length;i++){
						var pc = li.getElementsByTagName(\"svg\")[i];  
						var subMenu = li.getElementsByTagName(\"div\")[i];  
						pc.style.display =\"block\";
						subMenu.style.display = \"block\";  
						
					}
				}  
				function hideSubMenu(li) {  
					for(i=0;i<li.getElementsByTagName(\"svg\").length;i++){
						var pc = li.getElementsByTagName(\"svg\")[i];  
						var subMenu = li.getElementsByClassName(\"pcdiv\")[i];  
						pc.style.display =\"none\";
						subMenu.style.display = \"none\";  
					}
				}";
				
echo "		</script>\n"; 
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
echo "	    		border: 1px solid #FFFFFF;\n"; 
echo "			    height:450px;\n"; 
echo "			    position:relative;\n"; 
echo "			    width:200%;\n"; 
echo "\n"; 
echo "			    border-radius:5px;\n"; 
echo "	    		-moz-border-radius:5px;\n"; 
echo "			    -webkit-border-radius:5px;\n"; 
echo "			}\n"; 
echo "		</style>\n"; 
echo "	</head>\n"; 
echo "	<body onpageshow=\"hideSubMenu(nav)\">\n"; 
echo "            <div>\n"; 
echo "            <div style=\"float: left; padding-left: 30px; width: 600px;\">\n"; 
echo "                	<div>\n"; 
echo "					<p><a href=\"adminview.html\">admin</a> &gt; <a href=\"byPhase.html\">By Phase</a>\n"; 
echo "					</div>\n"; 
echo "                    <div class=\"dropdown\">\n"; 
echo "						<ul id=\"nav\">\n"; 
echo "                          <li onmouseover=\"displaySubMenu(this)\" onmouseout=\"hideSubMenu(this)\"  >Phase 1\n
								  <div class=\"pcdiv\" id=\"piechart_3d\" style=\"width:500px; height: 300px; padding-left: 50px;\"></div> \n
								</li>";
echo "                          <li onmouseover=\"displaySubMenu(this)\" onmouseout=\"hideSubMenu(this)\"  >Phase 2\n
								  <div class=\"pcdiv\" id=\"piechart_3d2\" style=\"width:500px; height: 300px; padding-left: 50px;\"></div> \n
								</li>";
echo "                          <li onmouseover=\"displaySubMenu(this)\" onmouseout=\"hideSubMenu(this)\"  >Phase 3\n
								  <div class=\"pcdiv\" id=\"piechart_3d3\" style=\"width:500px; height: 300px; padding-left: 50px;\"></div> \n
								</li>";
echo "                          <li onmouseover=\"displaySubMenu(this)\" onmouseout=\"hideSubMenu(this)\"  >Phase 4\n
								  <div class=\"pcdiv\" id=\"piechart_3d4\" style=\"width:500px; height: 300px; padding-left: 50px;\"></div> \n
								</li>";
echo "                          <li onmouseover=\"displaySubMenu(this)\" onmouseout=\"hideSubMenu(this)\"  >Phase 5\n
								  <div class=\"pcdiv\" id=\"piechart_3d5\" style=\"width:500px; height: 300px; padding-left: 50px;\"></div> \n
								</li>";
echo "                          <li onmouseover=\"displaySubMenu(this)\" onmouseout=\"hideSubMenu(this)\"  >Phase 6\n
								  <div class=\"pcdiv\" id=\"piechart_3d6\" style=\"width:500px; height: 300px; padding-left: 50px;\"></div> \n
								</li>";
echo "                          <li onmouseover=\"displaySubMenu(this)\" onmouseout=\"hideSubMenu(this)\"  >Phase 7\n
								  <div class=\"pcdiv\" id=\"piechart_3d7\" style=\"width:500px; height: 300px; padding-left: 50px;\"></div> \n
								</li>";
echo "                        </ul> <!-- nav -->\n"; 
echo "  				</div> <!-- dropdown -->\n"; 
echo "                </div> <!-- workstation -->\n"; 
echo "            </div>\n"; 
echo "	</body>\n"; 
echo "</html>\n";
?>