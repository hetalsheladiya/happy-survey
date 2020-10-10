<?php
header('Content-Type: application/json');
require_once './dbconfig.php';
require_once './classes/user.php';

list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));

$requestMethod = $_SERVER['REQUEST_METHOD'];
$responseArray = array();
if($requestMethod == 'POST'){
	$userId = @$_REQUEST['userId'];	
	if($userId == "" || $userId == NULL){
		$responseArray = array('status' => false, 'message' => 'Please provide user id.');
	}
	else{
		$user = new User();
		$start_time = $user->getCustomerTrialStartTime($userId);	
		
		$now = time();

		($start_time == '0000-00-00') ? $start_time = '' : $start_time = strtotime($start_time);
		
		$datediff = $now - $start_time;

		$dayCount = round($datediff / (60 * 60 * 24));

		$remainDay = 31 - $dayCount;

		if($start_time) {
			$responseArray = array('status' => true, 'message' => '', 'data' => $remainDay);
		}
		else{
			$responseArray = array('status' => false, 'message' => 'Error occured while getting trial time.');
		}
	}	
}
else{
	$responseArray = array('status' => false, 'message' => 'Page not found.');
}
echo json_encode($responseArray);
?>