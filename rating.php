<?php
header('Content-Type: application/json');
require_once './dbconfig.php';
require_once './classes/rating.php';
require_once './classes/store.php';
require_once './classes/order.php';

$surveyId = @$_REQUEST['surveyId'];
$comment = @$_REQUEST['comment'];
$name = @$_REQUEST['name'];
$phonenumber = @$_REQUEST['phonenumber'];
$email = @$_REQUEST['email'];
$userId = @$_REQUEST['userId'];
$storeId = @$_REQUEST['storeId'];

$comment = trim($comment);
$name = trim($name);
$phonenumber = trim($phonenumber);
$email = trim($email);

$store = new Store();
$fieldData = $store->getCustomFieldValue($userId, $storeId);

$order = new Order();
$orderData = $order->getSubscriberData($userId);
$current_period_end = $orderData->current_period_end;

list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));

$responseArray = array();

if($surveyId == '' || $surveyId == NULL){
	$responseArray = array('status' => 'fail', 'message' => 'Please provide survey id.');
}
// elseif($userId == '' || $userId == NULL){
// 	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
// }
// elseif ($storeId == '' || $storeId == NULL) {
// 	$responseArray = array('status' => 'fail', 'message' => 'Please provide storeId');
// }
// $mobileregex = "/^[0-9]{10}$/";
else if(($fieldData->commentfield == 1) && ($comment == NULL || $comment == "")){
    $responseArray = array('status' => 'fail', 'message' => 'Please provide comment.');
}
else if(($fieldData->namefield == 1) && ($name == NULL || $name == "")){
    $responseArray = array('status' => 'fail', 'message' => 'Please provide name.');
}
else if(($fieldData->phonefield == 1) && ($phonenumber == NULL || $phonenumber == "")){
    $responseArray = array('status' => 'fail', 'message' => 'Please provide Phonenumber.');
}
else if(($fieldData->emailfield == 1) && ($email == NULL || $email == "")){
    $responseArray = array('status' => 'fail', 'message' => 'Please provide email.');
}
else{	
	$rat = new Rating();	
	$getEmail = $rat->getUserEmail($userId);
	if(($fieldData->phonefield == 1) && !preg_match("/^\(?(\d{3})\)?[-\. ]?(\d{3})[-\. ]?(\d{4})$/", $phonenumber)){
		$responseArray = array('status' => 'fail', 'message' => 'Invalid phone number.');
	}
	// else if(strlen($phonenumber) < 10){
	//     $responseArray = array('status' => 'fail', 'message' => 'Your Phonenumber must contain At least 10 digits.');
	// }
	else{
		$result = $rat->update($surveyId, $comment, $name, $phonenumber, $email, $timestamp);

		if($result){
			if($orderData && $orderData->payment_status == 'active' && $current_period_end*1000 > $timestamp){
	    		($getEmail || $getEmail != NULL) ? $res = $rat->sendEmailNotification($getEmail, $userId, $surveyId) : "";
	    		$responseArray = array('status' => 'success', 'message' => 'Thanks for your feedback.', 'email' => $getEmail, 'notification' => $res, 'order' => $orderData);
	    	}
	    	else{
	    		$responseArray = array('status' => 'success', 'message' => 'Thanks for your feedback.', 'email' => $getEmail);
	    	}
			
		}
		else{
			$responseArray = array('status' => 'fail', 'message' => 'Something went wrong Plese try again later.');
		}
	}
	// if($getPhone == 1){		
	// 	if($phonenumber == NULL || $phonenumber == ""){
	// 	    $responseArray = array('status' => 'fail', 'message' => 'Please provide your phone number.');
	// 	}
	// 	else if(!preg_match("/^[0-9]{10}+$/", $phonenumber)){
	// 	    $responseArray = array('status' => 'fail', 'message' => 'Please provide valid phone number.');
	// 	}
	// 	else if(strlen($phonenumber) < 10){
	// 	    $responseArray = array('status' => 'fail', 'message' => 'Your Phonenumber must contain At least 10 digits.');
	// 	}
	// 	else{
			
	// 		$result = $rat->update($surveyId, $comment, $name, $phonenumber, $email, $timestamp);
	// 		if($result){
	// 			($getEmail != NULL) ? $res = $rat->sendEmailNotification($getEmail, $userId, $surveyId) : "";
	// 			$responseArray = array('status' => 'success', 'message' => 'Thanks for your feedback.');
	// 		}
	// 		else{
	// 			$responseArray = array('status' => 'fail', 'message' => 'Something went wrong Plese try again later.');
	// 		}
	// 	}	
	// }
	// else{	
	// 	$result = $rat->update($surveyId, $comment, $name, $phonenumber, $email, $timestamp);
	// 	if($result){			
 //        	($getEmail != NULL) ? $res = $rat->sendEmailNotification($getEmail, $userId, $surveyId) : "";
	// 		$responseArray = array('status' => 'success', 'message' => 'Thanks for your feedback.', 'email' => $getEmail, 'notification' => $res);
	// 	}
	// 	else{
	// 		$responseArray = array('status' => 'fail', 'message' => 'Something went wrong Plese try again later.');
	// 	}
	// }		
}
echo json_encode($responseArray);

?>