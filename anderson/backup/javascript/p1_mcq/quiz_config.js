var questions = new Array();
var choices = new Array();
var answers = new Array();
var response = new Array();

// To add more questions, just follow the format below.
questions[0] = "<p>*</p><b>1) All electrical wires must be made of _______ and covered with _______ respectively.</b>";
choices[0] = new Array();
choices[0][0] = "a.	Good conductors of electricity ; Good conductors of heat";
choices[0][1] = "b.	Good conductors of electricity ; Insulators of electricity";
choices[0][2] = "c.	Magnetic materials ; Non-magnetic materials";
choices[0][3] = "d.	Poor conductors of electricity ; Good conductors of electricity";
answers[0] = choices[0][1];

questions[1] = "<p>.</p><b>2) Materials that allow current to flow through have low ________.</b>";
choices[1] = new Array();
choices[1][0] = "a.	Density";
choices[1][1] = "b.	Volume";
choices[1][2] = "c.	Resistance";
choices[1][3] = "d.	Voltage";
answers[1] = choices[1][2];

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
