<?php
header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './classes/user.php';

$userId = @$_REQUEST['ud'];
$confirmation = @$_REQUEST['cm'];

if($userId == ""){
	$responseArray = array('status' => 'fail', 'message' => "Please provide userId");
}
elseif ($confirmation == "") {
	$responseArray = array('status' => 'fail', 'message' => "Please provide verificationcode");
}
else{
	$responseArray = array();
	$user = new User();
	$result = $user->confirmationEmail($userId, $confirmation);
	if($result){
		$user->userActivation($userId);
		$responseArray = array('status' => 'success', 'message' => 'Your account has been activated');
	}
	else{
		$responseArray = array('status' => 'fail', 'message' => "Somthing went wrong please try again later");
	}
}
echo json_encode($responseArray);
?>