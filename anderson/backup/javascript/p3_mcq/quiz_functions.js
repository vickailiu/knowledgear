var useranswers = new Array();
var answered = 0;

function renderQuiz() {
  for(i=0;i<questions.length;i++) {
    document.writeln('<ol><ol><ol><ol><ol><ol><ol><ol><p class="question">' + questions[i] + ' <span id="result_' + i + '"></span></p></ol></ol></ol></ol></ol></ol></ol></ol>');
    for(j=0;j<choices[i].length;j++) {
      document.writeln('<ol><ol><ol><ol><ol><ol><ol><ol><input type="radio" name="answer_' + i + '" value="' + choices[i][j] + '" id="answer_' + i + '_' + j + '" class="question_' + i + '" onclick="submitAnswer(' + i + ', this, \'question_' + i + '\', \'label_' + i + '_' + j + '\')" /><label id="label_' + i + '_' + j + '" for="answer_' + i + '_' + j + '"> ' + choices[i][j] + '</label><br/></ol></ol></ol></ol></ol></ol></ol></ol>');
    }
  }
  document.writeln('<ol><ol><ol><ol><ol><ol><ol><ol><p><button onclick="showScore()">Submit</button></p></ol></ol></ol></ol></ol></ol></ol></ol>');
}
function resetQuiz(showConfirm) {
  if(showConfirm)
    if(!confirm("Are you sure you want to reset your answers and start from the beginning?"))
      return false;
  document.location = document.location;
}
function submitAnswer(questionId, obj, classId, labelId) {
  useranswers[questionId] = obj.value;
  showResult(questionId);
  answered++;
}
function showResult(questionId) {
  if(answers[questionId] == useranswers[questionId]) {
    document.getElementById('result_' + questionId).innerHTML = '<img class="myImg" src="images/phase03/p3_mcq/blank.gif" style="border:0" alt="Correct!" />';
  } else {
    document.getElementById('result_' + questionId).innerHTML = '<img class="myImg1" src="images/phase03/p3_mcq/blank.gif" style="border:0" alt="Incorrect!" />';
  }
}
function showScore() {
  if(answered < answers.length) {
    alert("You have not answered all of the questions yet!");
    return false;
  }
  questionCount = answers.length;
  correct = 0;
  incorrect = 0;
  for(i=0;i<questionCount;i++) {
	  var yourImg = document.getElementById('yourImgId');
	  yourImg.style.height = '192px';
      yourImg.style.width = '262px';
    if(useranswers[i] == answers[i])
      correct++;
    else
      incorrect++;
  }
  pc = Math.round((correct / questionCount) * 100);
  alertMsg = "You scored " + correct + " out of " + questionCount + "\n\n";
  alertMsg += "You correctly answered " + pc + "% of the questions! \n\n";
  if(pc == 100){
    alertMsg += response[0];
    var myImgC = document.getElementsByClassName('myImg');
	for(var i=0; i<myImgC.length; i++){
		myImgC[i].src = "images/phase03/p3_mcq/correct.png";
	}
  }
  else if(pc >= 75)
    alertMsg += response[1];
  else if(pc >= 50){
    alertMsg += response[2];
    var myImgC = document.getElementsByClassName('myImg');
	for(var i=0; i<myImgC.length; i++){
		myImgC[i].src = "images/phase03/p3_mcq/correct.png";
	}
	var myImgIC = document.getElementsByClassName('myImg1');
	for(var i=0; i<myImgIC.length; i++){
		myImgIC[i].src = "images/phase03/p3_mcq/incorrect.gif";
	}
  }
  else if(pc > 25)
    alertMsg += response[3];
  else{
	alertMsg += response[4];
    var myImgIC = document.getElementsByClassName('myImg1');
	for(var i=0; i<myImgIC.length; i++){
		myImgIC[i].src = "images/phase03/p3_mcq/incorrect.gif";
	}
  }
  if(pc < 100) {
    if(confirm(alertMsg))
      resetQuiz(false);
    else
      return false;
  } else {
    alert(alertMsg);
  }
}