<?php
header('Content-Type: application/json');
require_once './dbconfig.php';
require_once './classes/user.php';
require_once './classes/utility.php';

$responseArray = array();
$name = @$_REQUEST['name'];
$email = @$_REQUEST['email'];
$message = @$_REQUEST['message'];
$userId = @$_REQUEST['userId'];
list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));

$name = trim($name);
$email = trim($email);
$message = trim($message);

// if($userId == "" || $userId == NULL){
// 	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
// }
if($name == "" || $name == NULL){
	$responseArray = array('status' => 'fail', 'message' => 'Please provide name');
}
else if($email == "" || $email == NULL){
	$responseArray = array('status' => 'fail', 'message' => 'Please provide email');
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $responseArray = array('status' => false, 'message' => 'Invalid Email format');
}
else if($message == "" || $message == NULL){
	$responseArray = array('status' => 'fail', 'message' => 'Please provide message');
}
else{
	$user = new User();
	$user->userId = $userId;
	$user->name = $name;
	$user->email = $email;
	$user->message = $message;
	$user->createdAt = $timestamp;
	$result = $user->saveEnquiry($name, $email, $message, $timestamp, $userId);
	if($result){
		$user->id = $result;
		$responseArray = array('status' => 'success', 'message' => 'Your message has been saved', 'data' => $user);

		$utility = new Utility();
		$res = $utility->sendEmail("norply@logileap.net", $name, "New Enquiry", $message, $email);
        if($res) {
            $responseArray = array('status' => 'success', 'message' => 'We will send you instruction for your query.', 'result' => $res);
        } 
    }
	else{
		$responseArray = array('status' => 'fail', 'message' => 'Something went wrong please try again later');
	}
}
echo json_encode($responseArray);
?>