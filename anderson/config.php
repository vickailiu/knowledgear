<?php
//Config File
$mcqBankSize = 10;
$final_mcqBankSize = 5;
$subphases = array(
	0=> array('size'=>2,'title'=>'Introduction'),
	1=> array('size'=>5,'title'=>'Circuit & Components'),
	2=> array('size'=>3,'title'=>'Biopolar Transistors and Thyristors'),
	3=> array('size'=>3,'title'=>'Construct Electrical Circuits'),
	4=> array('size'=>2,'title'=>'NPN Transistor'),
	5=> array('size'=>2,'title'=>'555IC Timer Circuit'),
	6=> array('size'=>1,'title'=>'Final Assessment'),
);
$phase = array(
	0  => array('url'=>'welcomeStudent.php','nextPage' => 'video.php?phase=1', 'title'=>'Home'), /*home*/
	1  => array('url'=>'video.php?phase=1','nextPage' => 'mcq.php?phase=2', 'title'=>'Video', 'videoID' => 'mKFePVGYmeE'), /*p1_video*/
	2  => array('url'=>'mcq.php?phase=2','nextPage' => 'video.php?phase=3', 'title'=>'MCQ','phaseRef'=>1), /*p1_mcq*/
	3  => array('url'=>'video.php?phase=3','nextPage' => 'video.php?phase=4', 'title'=>'Video Part 1', 'videoID' => 'YxTA59pAOgc'), /*p2.1_video*/
	4  => array('url'=>'video.php?phase=4','nextPage' => 'video.php?phase=5', 'title'=>'Video Part 2', 'videoID' => 'z3Wm5YG5EMM'), /*p2.2_video*/
	5  => array('url'=>'video.php?phase=5','nextPage' => 'p2_resistor.php?phase=6', 'title'=>'Video Part 3', 'videoID' => 'qlTq7-Ad2k8'), /*p2.3_video*/
	6  => array('url'=>'p2_resistor.php?phase=6','nextPage' => 'mcq.php?phase=7', 'title'=>'Activity','repeats'=>'3'), /*p2_resistor*/
	7  => array('url'=>'mcq.php?phase=7','nextPage' => 'video.php?phase=8', 'title'=>'MCQ','phaseRef'=>2), /*p2_mcq*/
	8  => array('url'=>'video.php?phase=8','nextPage' => 'video.php?phase=9', 'title'=>'Video Part 1', 'videoID' => 'sHve1Hg68hw'), /*p3.1_video*/
	9  => array('url'=>'video.php?phase=9','nextPage' => 'mcq.php?phase=10', 'title'=>'Video Part 2', 'videoID' => 'nAcJCGoyLnY'), /*p3.2_video*/
	10 => array('url'=>'mcq.php?phase=10','nextPage' => 'video.php?phase=11', 'title'=>'MCQ','phaseRef'=>3), /*p3_mcq*/
	11 => array('url'=>'video.php?phase=11','nextPage' => 'EX_wordmatch.php?phase=12', 'title'=>'Video', 'videoID' => 'fb8rI-2YTxo'), /*p4_video*/
	12 => array('url'=>'EX_wordmatch.php?phase=12','nextPage' => 'mcq.php?phase=13', 'title'=>'Activity'), /*p4_wordpic*/
	13 => array('url'=>'mcq.php?phase=13','nextPage' => 'video.php?phase=14', 'title'=>'MCQ','phaseRef'=>4), /*p4_mcq*/
	14 => array('url'=>'video.php?phase=14','nextPage' => 'Ex_npn.php?phase=15', 'title'=>'Lab Video', 'videoID' => 'XeelPmyQazo'), /*p5_video*/ /*to update*/
	15 => array('url'=>'Ex_npn.php?phase=15','nextPage' => 'video.php?phase=25', 'title'=>'Application Activity', 'elect'=> 'NPN transistor light sensing circuit', 'costWeights' => '[40,100,80,120,20,150,60]'), /*p5_npn*/
	25 => array('url'=>'video.php?phase=25','nextPage' => 'Ex_npn.php?phase=26', 'title'=>'Lab Video', 'videoID' => 'S4DRapABRrU'), /*p6_video*/ /*to update*/
	26 => array('url'=>'Ex_npn.php?phase=26','nextPage' => 'finalassessment.php?phase=27', 'title'=>'Application Activity', 'elect'=> '555IC Timer circuit', 'costWeights' => '[ 20,100,50,120,20,150,80]'), /*p6_555*/ /*to update*/
	27 => array('url'=>'finalassessment.php?phase=27','nextPage' => '', 'title'=>'Final Assessment 1'), /*finalassessment1*/
);
$bg_png = array(
	1 => 'images/mcq/PG_1.jpg',
	2 => 'images/mcq/PG_2.jpg',
	3 => 'images/mcq/PG_3.jpg',
	4 => 'images/mcq/PG_4.jpg',
);
?>
