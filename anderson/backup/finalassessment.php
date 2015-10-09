<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/finalassessment/FinalAssessment.css">
<title>Final Assessment</title>

<head/>

<body background="images/finalassessment/FAbg.jpg"><a id="top"></a>
<img src="images/finalassessment/fa.png" width="450" height="150"></img>
<h1>Congratulations you have come to the last phase of this program.</h1>
<h2 id="message">Complete the questions below to complete the course.<br>
This assessment will be timed.</h2>
<p id="timer">Timer: <input type="text" id="time" readonly>  <button type="button" id= "start" onclick="start()">Start</button></p>

<form id="question">
<!--MCQ question x5
// has 3 parts to a single MCQ template. A paragraph for qus. 2 img input and 4 radio button input.
// qus labeled as 'q'+ num (1 to 5).
//img labeled as 'pic'+qus num(1 to 5)+ a/b.
//radio button input's value labeled as 'q'+qus num(1 to 5)+ selection (a/b/c/d).-->

<p id="q1">Q1. What does the D.C. term means?</br></p>
<img id="pic1a"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic1b"></img>
<p id="a1"><br>
<input type="radio" name="q1" value="q1a">Distance Calculation<br>
<input type="radio" name="q1" value="q1b">Direct Current<br>
<input type="radio" name="q1" value="q1c">Dimension Current<br>
<input type="radio" name="q1" value="q1d">Direct Conversion<br>
<br></p>

<p id="q2">Q2. State the unit of measurement for power.</br></p>
<img id="pic2a"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic2b"></img>
<p id="a2"><br>
<input type="radio" name="q2" value="q2a">Watt<br>
<input type="radio" name="q2" value="q2b">Ohm<br>
<input type="radio" name="q2" value="q2c">Tesla<br>
<input type="radio" name="q2" value="q2d">Newton<br>
<br></p>

<p id="q3">Q3. What is the formula for finding power? </br></p>
<img id="pic3a"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic3b"></img>
<p id="a3">
<input type="radio" name="q3" value="q3a">IR<br>
<input type="radio" name="q3" value="q3b">I^3 R<br>
<input type="radio" name="q3" value="q3c">VI<br>
<input type="radio" name="q3" value="q3d">V/R<br>
<br></p>

<p id="q4">Q4. Determine the current in a 60W bulb plugged into a 120V outlet</br></p>
<img id="pic4a"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic4b"></img>
<p id="a4">
<input type="radio" name="q4" value="q4a">3.5 A<br>
<input type="radio" name="q4" value="q4b">1 kA<br>
<input type="radio" name="q4" value="q4c">0.5 A<br>
<input type="radio" name="q4" value="q4d">0.5 kA<br>
<br></p>

<p id="q5">Q5. You can measure voltage, current and resistance with?</br></p>
<img id="pic5a"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic5b"></img>
<p id="a5">
<input type="radio" name="q5" value="q5a">Potentiometer<br>
<input type="radio" name="q5" value="q5b">Micrometer<br>
<input type="radio" name="q5" value="q5c">Multimeter<br>
<input type="radio" name="q5" value="q5d">Voltmeter<br>
<br></p>

<!--open-ended questions x3
//each template has 3 parts labeled= 'q' followed by question num., then part 'a', 'b' or 'c'.
//each part has a question text paragragh, 2 img insertion and a txt area input with placeholder component.
// img is labeled as 'pic'+ qus num.+ part alphabet(a/b/c)+ num.(1/2)
// input txt area has its name labeled as 'txt'+qus num.+part (a/b/c).
// textarea's placeholder has to be set if required.-->

<p id="q6a">Q6a. Table 1 shows the resistor color code table. With the aid of the color code table, </br>
write down the values of each of the resistors R1, R2 and R3 shown in Figure 1. </br></p>
<img id="pic6a1" src="images/finalassessment/resistance_parta1.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic6a2" src="images/finalassessment/resistance_parta2.jpg" width="250px" height="200px"></img><br>
<textarea id= ="txt6a" placeholder="value of R1, R2 and R3:" rows="4" cols="50"></textarea><br>
<br>

<p id="q6b">Q6b. Explain the purpose of the fourth color band on the resistor.</br></p>
<img id="pic6b1"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic6b2"></img></br>
<textarea id= ="txt6b" placeholder="" rows="4" cols="50"></textarea><br>
<br>

<p id="q6c">Q6c. Using the values of R1, R2 and R3 in Figure 1.</br>
Calculate the total resistance of the resistors connected as shown in Figure 2.</br></p>
<img id="pic6c1" src="images/finalassessment/resistance_partc.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic6c2"></img></br>
<textarea id= ="txt6c" placeholder="Total resistance:" rows="4" cols="50"></textarea><br>
<br>

<p id="q7a">Q7a. Calculate the total resistance across AB in the following case.</br></p>
<img id="pic7a1" src="images/finalassessment/calculateR_parta.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic7a2"></img></br>
<textarea id= ="txt7a" placeholder="Total Resistance across AB:" rows="4" cols="50"></textarea><br>
<br>

<p id="q7b">Q7b. Calculate the total resistance across AB in the following case.</br></p>
<img id="pic7b1" src="images/finalassessment/calculateR_partb.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic7b2"></img></br>
<textarea id= ="txt7b" placeholder="Total Resistance across AB:" rows="4" cols="50"></textarea><br>
<br>

<p id="q7c">Q7c. Calculate the total resistance across AB in the following case.</br></p>
<img id="pic7c1" src="images/finalassessment/calculateR_partc.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic7c2"></img></br>
<textarea id= ="txt7c" placeholder="Total Resistance across AB:" rows="4" cols="50"></textarea><br>
<br>

<p id="q8a">Q8a. Figure below shows a light-sensing circuit. When bright light is detected, the buzzer sounds.</br>
Explain how the increase in the value of R affects the operation of the circuit.</br></p>
<img id="pic8a1" src="images/finalassessment/LDRcircuit.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic8a2"></img></br>
<textarea id= ="txt8a" placeholder="Effects of the increase in the value of R on circuit operation:" rows="4" cols="50"></textarea><br>
<br>

<p id="q8b">Q8b. A potentiometer is sometimes used in a temperature sensing circuit.</br>
              State the purpose of the potentiometer in the circuit.</br></p>
<img id="pic8b1"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic8b2"></img></br>
<textarea id= ="txt8b" placeholder="Purpose of potentiometer:" rows="4" cols="50"></textarea><br>
<br>

<p id="q8c">Q8c. State three situations in which the moisture detector maybe useful.</br></p>
<img id="pic8c1"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic8c2"></img></br>
<textarea id= ="txt8c" placeholder="Three situations are:" rows="4" cols="50"></textarea><br>
<br>

<!-- there are 2 upload type question.
// each qus follow the template of 1 para for qus, 2 img input and 1 file upload input.
// para labeled as 'q'+ qus num.(9/10)
//img id labeled as 'pic'+ qus num.(9/10)+ part (a/b).
//file upload name labeled as 'file'+ qus num.(9/10).-->

<h3>Draw the circuit requested in the following question in "Paint" and save as Jpeg image.</br>
Then upload the image here.</br></h3>

<p id="q9">Q9. The circuit diagram symbol shown in Figure below represents a single cell having an e.m.f. of 1.5V.</br>
Draw the circuit diagram of a battery consisting of a number of these cells which will produce an e.m.f of 6V</br></p>
<img id="pic9a" src="images/finalassessment/battery_symbol.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic9b"></img></br>
<input type="file" name="file9"><br>
<p id="q10">Q10. Complete the circuit such that if switch B or both switch A and C are closed, the bulb is lighted.</br></p>
<img id="pic10a" src="images/finalassessment/circuit_joining.jpg" width="250px" height="200px"></img>&nbsp;&nbsp;&nbsp;&nbsp;<img id="pic10b"></img></br>
<input type="file" name="file10"><br>

</br></br><button type="button" onclick="enter()"><a href="#top">Submit</a></button></p>
</form>


</body>

<script>
var textarea=["txt6a", "txt6b", "txt6c",
			"txt7a", "txt7b", "txt7c",
			"txt8a", "txt8b", "txt8c"];
var c = 0;
	var t;
	var timer_is_on = 1;
	var assessmentTime=[];
	document.getElementById("question").style.visibility="hidden";
function timedCount() {
	document.getElementById("start").style.visibility="hidden";
    document.getElementById("time").value = c;
    c = c + 1;
    t = setTimeout(function(){timedCount()}, 1000);
    if (!timer_is_on) {
			    timer_is_on = 1;
		        timedCount();
	}
}

function enter(){
	assessmentTime.push(c);
	document.getElementById("timer").style.visibility="hidden";
	document.getElementById("question").style.visibility="hidden";
	document.getElementById('message').innerHTML ="Well Done! You have come to the end of the course. Hope you enjoy the online lesson.<br> Your duration is "+assessmentTime[assessmentTime.length-1]+" seconds.";
	clearTimeout(t);
}

function start(){
	document.getElementById("question").style.visibility="visible";
	timedCount();
}


</script>

</html>