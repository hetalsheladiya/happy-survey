<?php
header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './classes/user.php';

$user = new User();	

$requestMethod = $_SERVER['REQUEST_METHOD'];

$responseArray = array();

if ($requestMethod == 'POST') {
	$newpassword = @$_REQUEST['newpassword'];
	$confirmpassword = @$_REQUEST['confirmpassword'];
	$userId = @$_REQUEST['userId'];

	$newpassword = trim($newpassword);
	$confirmpassword = trim($confirmpassword);
	
	if($newpassword == "" || $newpassword == NULL){
		$responseArray = array('status' => false, 'message' => 'Please provide new password.');
	}
	else if(strlen($newpassword) < 6){
		$responseArray = array('status' => false, 'message' => 'Your Password Must Contain At Least 6 Characters!');
	}	
	elseif ($confirmpassword == "" || $confirmpassword == NULL) {
		$responseArray = array('status' => false, 'message' => 'Please provide confirm password.');
	}
	elseif($confirmpassword != $newpassword){
		$responseArray = array('status' => false, 'message' => 'Confirm Password does not match.');
	}
	elseif($userId == '' || $userId == NULL){
		$responseArray = array('status' => false, 'message' => 'Please provide userId.');
	}	
	else{
		$result = $user->changedPwd($newpassword, $userId);
		if($result){
			$responseArray = array('status' => true, 'message' => 'Password successfully changed.', 'data' => $result);
		}
		else{
			$responseArray = array('status' => false, 'message' => 'Something went wrong please try again later.');
		}
	}
}
else{
	$responseArray = array('status' => false, 'message' => 'Page not found.');
}
echo json_encode($responseArray);
?>