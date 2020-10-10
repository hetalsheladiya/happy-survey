<?php

header('Content-Type: application/json');

include_once './config.php'; 
include_once './dbconfig.php';
require_once './classes/user.php';
require_once './classes/profile.php';

$responseArray = array();

$requestMethod = $_SERVER['REQUEST_METHOD'];
if($requestMethod == 'POST'){
	$username = @$_REQUEST['username'];
	$password = @$_REQUEST['password'];

	$username = trim($username);
	$password = trim($password);

	$user = new User();
	$existingUser = $user->getForUsername($username);

	$validUser = $user->getStatusCode($username);

	if($username == NULL || $username == "") {
		$responseArray = array('status' => 'fail', 'message' => 'Please provide username.');	
	}
	// elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
	//     $responseArray = array('status' => false, 'message' => 'Invalid Email format');
	// }
	else if($existingUser == NULL) {
		$responseArray = array('status' => 'fail', 'message' => "User doesn't exist with username {$username}.");
	}
	else if($password == NULL || $password == "") {
		$responseArray = array('status' => 'fail', 'message' => 'Please provide password.');	
	}
	else if(strlen($password) < 6){
		$responseArray = array('status' => 'fail', 'message' => 'Your password must contain at least 6 characters!');
	}
	else if ($validUser == 0) {
		$responseArray = array('status' => 'fail', 'message' => 'Please verify your email to login.');
	}
	else {	
			$result = $user->login($username, $password);
		    if($result) {
		    	$profile = new Profile();
		        $profile->getForUserId($result->id);
		        $responseArray = array('status' => 'success', 'user' => $result, 'profile' => $profile);
			}
			else {
				$responseArray = array('status' => 'fail', 'message' => 'Username or password incorrect.');
		    }   
	}
}
else{
	http_response_code(404);
	$responseArray = array("status" => 'fail', 'message' => 'Page not found.');
}
echo json_encode($responseArray);
?>
