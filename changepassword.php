<?php
header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './classes/user.php';

$user = new User();	

$oldpassword = @$_REQUEST['oldpassword'];
$newpassword = @$_REQUEST['newpassword'];
$confirmpassword = @$_REQUEST['confirmpassword'];
$userId = @$_REQUEST['userId'];

$oldpassword = trim($oldpassword);
$newpassword = trim($newpassword);
$confirmpassword = trim($confirmpassword);

$responseArray = array();

$existingPassword = $user->getOldPassword($oldpassword, $userId);
if($oldpassword == "" || $oldpassword == NULL){
	$responseArray = array('status' => false, 'message' => 'Please provide old password');
}
else if($existingPassword == NULL){
		$responseArray = array('status' => false, 'message' => 'Old password does not match');		
}
else if($newpassword == "" || $newpassword == NULL){
	$responseArray = array('status' => false, 'message' => 'Please provide new password');
}
else if($oldpassword == $newpassword || $oldpassword ==  $newpassword){
	$responseArray = array('status' => false, 'message' => 'old and new password should not be same Please try again');
}
elseif ($confirmpassword == "" || $confirmpassword == NULL) {
	$responseArray = array('status' => false, 'message' => 'Please provide confirm password');
}
elseif($confirmpassword != $newpassword){
	$responseArray = array('status' => false, 'message' => 'Confirm Password does not match');
}
elseif($userId == '' || $userId == NULL){
	$responseArray = array('status' => false, 'message' => 'Please provide userId');
}
else if(strlen($newpassword) < 6){
	$responseArray = array('status' => false, 'message' => 'Your Password Must Contain At Least 6 Characters!');
}
else{
	$result = $user->changedPwd($newpassword, $userId);
	if($result){
		$responseArray = array('status' => true, 'message' => 'Password succesfully changed');
	}
	else{
		$responseArray = array('status' => false, 'message' => 'Somehting went wronf please try again later');
	}
}
echo json_encode($responseArray);
?>