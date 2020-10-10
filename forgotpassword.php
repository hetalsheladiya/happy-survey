<?php
header('Content-Type: application/json');
 
require_once './dbconfig.php';
require_once './classes/user.php';
require_once './classes/utility.php';

$email = @$_REQUEST['email'];
$email = trim($email);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

$responseArray = array();
if($email == NULL || $email == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide Email.');	
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $responseArray = array('status' => 'fail', 'message' => 'Invalid Email.');
}
else {
    $user = new User();
    $existingUser = $user->getUsername($email);
    $id = $existingUser->id;
    $username = $existingUser->username;
    if($existingUser == NULL) {
        $responseArray = array('status' => 'fail', 'message' => 'Something went wrong. Please try again after some time.');
    }
    else{
        $result = $user->resetPassword($id, $username, $email);
        if($result) {
            $responseArray = array('status' => 'success', 'message' => 'We sent you instruction for password reset on your registred email address. Please check that.', 'result' => $result, 'data' => $existingUser);
    	}
    	else {
            if($result == NULL) {
                $responseArray = array('status' => 'fail', 'message' => 'Username not exist.');
            }
            else {
                $responseArray = array('status' => 'fail', 'message' => 'Username or password incorrect.');
            }
        }
    }    
}
echo json_encode($responseArray);
?>