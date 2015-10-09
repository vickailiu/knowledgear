var questions = new Array();
var choices = new Array();
var answers = new Array();
var response = new Array();

// To add more questions, just follow the format below.

questions[0] = "<p>*</p><b>1) What is the term for a current that flows in one direction continuously?</b>";
choices[0] = new Array();
choices[0][0] = "a.	Alternating Current";
choices[0][1] = "b.	Electron Current";
choices[0][2] = "c.	Conventional Current";
choices[0][3] = "d.	Direct Current";
answers[0] = choices[0][3];

questions[1] = "<p>.</p><b>2) Which device makes a noise when connected to a battery and are often used as warning devices?</b>";
choices[1] = new Array();
choices[1][0] = "a.	Electromagnet";
choices[1][1] = "b.	Buzzer";
choices[1][2] = "c.	Motor";
choices[1][3] = "d.	Solenoid";
answers[1] = choices[1][1];

// response for getting 100%
response[0] = "Excellent, top marks!";
// response for getting 75% or more
response[1] = "Well done, try again to get 100%!"
// response for getting over 50%
response[2] = "Nice one, you got more than half of the questions right, can you do better?";
// response for getting 25% or more
response[3] = "You got some questions right, you can do better!";
// response for getting 9% or less
response[4] = "Let's watch the Lecture Video one more time and try again!";
