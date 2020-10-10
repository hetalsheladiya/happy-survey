<?php

header('Content-Type: application/json');
 
include_once './dbconfig.php';
include_once './config.php';
require_once './classes/survey.php';

$responseArray = array();
global $mysqli;

$isHappy = @$_REQUEST['isHappy'];

$userId = @$_REQUEST['userId'];
$storeId = @$_REQUEST['storeId'];
// $deviceToken = @$_REQUEST['deviceToken'];
$createdAt = @$_REQUEST['createdAt'];
$rating = @$_REQUEST['rating'];

// $deviceType = @$_REQUEST['deviceType'];
// $deviceName = @$_REQUEST['devicename'];
// $deviceModal = @$_REQUEST['deviceModal'];
// $deviceOs = @$_REQUEST['deviceOs'];
// $appVersion = @$_REQUEST['appVersion'];
// $appBuild = @$_REQUEST['appBuild'];


list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));

($createdAt == "") ? $createdAt = $timestamp : "" ;

($rating != "") ? $rating = json_decode($_REQUEST['rating'],true) : $rating = array();

if($isHappy == NULL) {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide isHappy');
}
else if($storeId == NULL || $storeId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide storeId');
}
else if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
}
else {        
    
    ($isHappy == 2) ? $comment = "" : "";    

    $survey = new Survey();
    $survey->isHappy = (int) $isHappy;    
    // $survey->category = trim($categories);
    // $survey->name = $name;
    // $survey->email = $email;
    // $survey->phone = $phonenumber;
    $survey->userId = (int) $userId;
    // $survey->comment = $comment;
    $survey->createdAt = $createdAt;
    $survey->updatedAt = $timestamp;
    $survey->rating = $rating;
    $survey->storeId = $storeId;  

    // $survey->deviceType = $deviceType;
    // $survey->devicename = $deviceName;
    // $survey->deviceModal = $deviceModal;
    // $survey->deviceOs = $deviceOs;
    // $survey->appVersion = $appVersion;
    // $survey->appBuild = $appBuild;
    //$rating = array();
    //echo $rating["id"];echo $rating["rating"];
    
    // if ($deviceToken == NULL) {
    //     $deviceToken = "";
    // }

    $result = $survey->save(/*$deviceToken,*/ $rating, $storeId);
    
    if($result) {
        $survey->id = $result;
        $responseArray = array('status' => 'success', 'message' => 'Survey saved successfully.', 'data' => $survey);
	}
	else {        
		$responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
    }
}
echo json_encode($responseArray);

?>