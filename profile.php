<?php

header('Content-Type: application/json');

include_once './config.php';
include_once './dbconfig.php';
require_once './classes/profile.php';

$userId = @$_REQUEST['userId'];
$responseArray = array();

if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');	
}
else {
    $profile = new Profile();
    $result = $profile->getForUserId($userId);
    if($result) {
        $responseArray = array('status' => 'success', 'profile' => $profile);
	}
	else {
		$responseArray = array('status' => 'fail', 'message' => 'Profile not exist for user.');
    }    
}
echo json_encode($responseArray);
?>