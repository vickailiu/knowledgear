<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/phase05/p5_npn/Application.css">
		<title>NPN transistor sensing circuit industry</title>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
			google.load("visualization", "1", {packages:["corechart"]});
			google.setOnLoadCallback(drawChart);
			var total=100;
			// var fq=parseInt(document.getElementById('factoryqty').value);
			// var sq=parseInt(document.getElementById('schoolqty').value);
			// var tq=parseInt(document.getElementById('trafficqty').value);
			// var hq=parseInt(document.getElementById('hdbqty').value);
			// var nq=parseInt(document.getElementById('naturaldisasterMgtqty').value);
			// var aq=parseInt(document.getElementById('agricultureqty').value);
			// var mq=parseInt(document.getElementById('manufacturerqty').value);
			document.getElementById('endbutton').style.visibility = "hidden";
			document.getElementById('returnbutton').style.visibility = "hidden";
			document.getElementById('factoryform').style.visibility = "hidden";
			document.getElementById('manufacturerform').style.visibility = "hidden";
			document.getElementById('schoolform').style.visibility = "hidden";
			document.getElementById('hdbform').style.visibility = "hidden";
			document.getElementById('naturaldisasterMgtform').style.visibility = "hidden";
			document.getElementById('trafficform').style.visibility = "hidden";
			document.getElementById('agricultureform').style.visibility = "hidden";

			//Function To Display Popup
			function div_show(industry)
			{
				document.getElementById(industry+'form').style.visibility = "visible";
			}
			//Function to Hide Popup
			function div_hide(industry)
			{
				document.getElementById(industry+'form').style.visibility = "hidden";
			}

		function submitqty()
		{
			var fq=parseInt(document.getElementById('factoryqty').value);
			var sq=parseInt(document.getElementById('schoolqty').value);
			var tq=parseInt(document.getElementById('trafficqty').value);
			var hq=parseInt(document.getElementById('hdbqty').value);
			var nq=parseInt(document.getElementById('naturaldisasterMgtqty').value);
			var aq=parseInt(document.getElementById('agricultureqty').value);
			var mq=parseInt(document.getElementById('manufacturerqty').value);
			var selection = fq+sq+tq+hq+nq+aq+mq;
			if (selection != 100)
			{
				alert("You have to sell all 100 unit. Please edit your selection.");
			}
			else
			{

				document.getElementById('submitbutton').style.visibility = "hidden";
				document.getElementById('returnbutton').style.visibility = "visible";
				document.getElementById('endbutton').style.visibility = "visible";
				drawChart();
				document.getElementById('information').innerHTML = "Scroll down to view result.</br>To Resell your product to improve your revenue, click on Return.</br> Click on End to continue.";
			}
		}

		function drawChart() {
				var fq=parseInt(document.getElementById('factoryqty').value);
				var sq=parseInt(document.getElementById('schoolqty').value);
				var tq=parseInt(document.getElementById('trafficqty').value);
				var hq=parseInt(document.getElementById('hdbqty').value);
				var nq=parseInt(document.getElementById('naturaldisasterMgtqty').value);
				var aq=parseInt(document.getElementById('agricultureqty').value);
				var mq=parseInt(document.getElementById('manufacturerqty').value);
					var a= 40*aq;
					var f= 100*fq;
					var s= 80*sq;
					var m= 120*mq;
					var n= 20*nq;
					var t= 150*tq;
					var h= 60*hq;

				var data = google.visualization.arrayToDataTable([
				  ['Year', 'Revenue($)',{ role: 'annotation' }],
				  ['Factory', f, f],
				  ['School',  s, s],
				  ['Manufacturer',  m,m],
				  ['Natural Disaster', n,n],
				  ['Traffic Instrument Manufacture', t,t],
				  ['Housing Estate', h,h],
				  ['Agriculture', a,a]
				]);

				var options = {
				  title: 'Revenue Distribution for NPN transistor light sensing circuit.',
				  vAxis: {title: 'Industry',  titleTextStyle: {color: 'black'}}
				};

				var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

				chart.draw(data, options);

		}



		function resell(){
			document.getElementById('returnbutton').style.visibility = "hidden";
			document.getElementById('endbutton').style.visibility = "hidden";
			document.getElementById('submitbutton').style.visibility = "visible";
			document.getElementById('information').innerHTML = "You have 100 units of Light Sensing Circuit. Mouse over to each industry on the map to indicate the quantity of this circuit you would like to sell. You must sell all 100 units to proceed.</h2></br>";
		}
		</script>

	</head>
	<body bgcolor="#CCCC99" id="main">
		<div id="text">
			<h2 id= "information" style="float:left;">You are now a Light Sensing Circuit Manufacturer. You have 100 units of Light Sensing Circuit in your inventory to sell to the different industries. Each industry is willing to pay a different unit price based on the importance of the Light Sensing Circuit in their production. On the other hand, you want to provide for the different industries while maximizing profit. Indicate the quantity of this component that you would like to sell to each industry.</h2></br>
			<button id="endbutton" onclick="location='p6_video.html'">End</button>
			<button id="submitbutton" type="button" onclick="submitqty()">Submit</button>
			<button id="returnbutton" onclick="resell()">Return</button>
		</div>
		<div id="map">
			<div id="factory" onmouseover="div_show('factory')" onmouseout="div_hide('factory')">
				<form id="factoryform">
					<label>Quantity to sell: </label><input type="number" id="factoryqty" value="0"/><br>
				</form>
			</div>
			<div id="school" onmouseover="div_show('school')" onmouseout="div_hide('school')">
				<form id="schoolform">
					<label>Quantity to sell: </label><input type="number" id="schoolqty" value="0"/><br>
				</form>
			</div>
			<div id="traffic" onmouseover="div_show('traffic')" onmouseout="div_hide('traffic')">
				<form id="trafficform">
					<label>Quantity to sell: </label><input type="number" id="trafficqty" value="0"/><br>
				</form>
			</div>
			<div id="manufacturer" onmouseover="div_show('manufacturer')" onmouseout="div_hide('manufacturer')">
				<form id="manufacturerform">
					<label>Quantity to sell: </label><input type="number" id="manufacturerqty" value="0"/><br>
				</form>
			</div>
			<div id="naturaldisasterMgt" onmouseover="div_show('naturaldisasterMgt')" onmouseout="div_hide('naturaldisasterMgt')">
				<form id="naturaldisasterMgtform">
				<label>Quantity to sell: </label><input type="number" id="naturaldisasterMgtqty" value="0"/><br>
				</form>
			</div>
			<div id="hdb" onmouseover="div_show('hdb')" onmouseout="div_hide('hdb')">
				<form id="hdbform">
					<label>Quantity to sell: </label><input type="number" id="hdbqty" value="0"/><br>
				</form>
			</div>
			<div id="agriculture" onmouseover="div_show('agriculture')" onmouseout="div_hide('agriculture')">
				<form id="agricultureform">
					<label>Quantity to sell: </label><input type="number" id="agricultureqty" value="0"/><br>
				</form>
			</div>
		</div>
		<div id="chart_div" style="width: 700px; height: 500px;"></div>
	</body>
</html>