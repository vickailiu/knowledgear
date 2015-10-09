<?php
// Database connection here

// data here
$parseTxt = $_GET['parseTxt'];
$activity = $_GET['activity'];

$new_var = json_decode($parseTxt, true);

include 'conn.php';
	
switch($activity){
	case 1:
		// Store to database table 1
		break;
	case 2:
		// Store to database table 2
		break;
	case 3:
		// Store to database table 3
		break;		
	case 4:
		// Store to database table 3
		foreach($new_var['activity4'] as $item){
			$studentId = $item['studentId'];
			$phase = $item['phase'];
			$activity = $item['activity'];
			$timestamp = $item['timestamp'];
			$actionType = $item['actionType'];
			$action = $item['action'];
			$target_1 = $item['target_1'];
			$target_2 = $item['target_2'];
			$duration = $item['duration'];
			$correct = $item['correct'];
			$logID = NULL;
			
			$pstmt = $dbConn->prepare('INSERT INTO `Log` (`LogID`, `Timestamp`, `Duration`, `ActionType`, `Action`, `Target_1`, `Target_2`, `Phase`, `Activity`, `Correct`, `StudentID`) VALUES (:LogID, :Timestamp, :Duration, :ActionType, :Action, :Target_1, :Target_2, :Phase, :Activity, :Correct, :StudentID)');
   
       	   	$pstmt->bindParam(':LogID', $logID, PDO::PARAM_INT);
         	$pstmt->bindParam(':Timestamp', $timestamp, PDO::PARAM_STR);
         	$pstmt->bindParam(':Duration', $duration, PDO::PARAM_INT);
       	   	$pstmt->bindParam(':ActionType', $actionType, PDO::PARAM_STR);
         	$pstmt->bindParam(':Action', $action, PDO::PARAM_STR);
        	$pstmt->bindParam(':Target_1', $target_1, PDO::PARAM_STR);
        	$pstmt->bindParam(':Target_2', $target_2, PDO::PARAM_STR);
        	$pstmt->bindParam(':Phase', $phase, PDO::PARAM_INT);
         	$pstmt->bindParam(':Activity', $activity, PDO::PARAM_STR);
        	$pstmt->bindParam(':Correct', $correct, PDO::PARAM_STR);
        	$pstmt->bindParam(':StudentID', $studentId, PDO::PARAM_INT);
		
	    	$pstmt->execute();
		}
		
		
		break;
}
echo  "<script>";
echo "window.close();";
echo "</script>";
?>