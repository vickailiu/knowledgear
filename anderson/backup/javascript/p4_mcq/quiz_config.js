var questions = new Array();
var choices = new Array();
var answers = new Array();
var response = new Array();

// To add more questions, just follow the format below.

questions[0] = "<p>*</p><b>1) The IC chips are made of up ________.</b>";
choices[0] = new Array();
choices[0][0] = "a.	Circuits";
choices[0][1] = "b.	Wires";
choices[0][2] = "c.	Processors";
choices[0][3] = "d.	Transistors";
answers[0] = choices[0][0];

questions[1] = "<p>.</p><b>2) Which of the following is not an operating mode of IC555?</b>";
choices[1] = new Array();
choices[1][0] = "a.	Astable";
choices[1][1] = "b.	Monostable";
choices[1][2] = "c.	Bistable";
choices[1][3] = "d.	Tristable";
answers[1] = choices[1][3];

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
