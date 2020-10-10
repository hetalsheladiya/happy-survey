<?php

header('Content-Type: application/json');

require_once('./dbconfig.php');
require_once('./config.php');
require_once('./classes/store.php');

$name = @$_REQUEST['name'];
$userId = @$_REQUEST['userId'];
$googleLink = @$_REQUEST['googleLink'];
$customMsg = @$_REQUEST['customMsg'];
list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));

$responseArray = array();

if($name == NULL || $name == ""){
	$responseArray = array('status'=>'fail','message'=>'Please provide name.');	
}
elseif ($userId == NULL || $userId == ""){
	$responseArray = array('status' => 'fail' , 'message' => 'Please provide userId');
}
else{

	if($googleLink != NULL || $googleLink != ""){	
	
	 	if(!filter_var($googleLink, FILTER_VALIDATE_URL)){
			$responseArray = array('status'=>'fail','message'=>'Please provide valid URL link');
		}
		else{
			$store = new Store();
			$store->name = $name;
			$store->userId = $userId;	
			$store->createdAt = $timestamp;
			$store->updatedAt = $timestamp;
			$store->customMsg = $customMsg;

			$result = $store-> __save($googleLink, $customMsg, $timestamp);
			$resultType = gettype($result);
			if($resultType == 'integer')	{	
				$store->id = $result;	
				$responseArray = array('status' => 'success' , 'message'=> 'Store created successfully.', 'store' => $store);
			}	
			else if($resultType == 'string'){
				$responseArray = array('status' => 'fail' , 'message' => 'Store already exists.');
			}
			else {
				$responseArray = array('status' => 'fail' , 'message' => 'Something went wrong please try again later');
			}
		}
	}
	else{

		$store = new Store();
		$store->name = $name;
		$store->userId = $userId;	
		$store->createdAt = $timestamp;
		$store->updatedAt = $timestamp;
		$store->customMsg = $customMsg;

		$result = $store-> __save($googleLink, $customMsg, $timestamp);
		$resultType = gettype($result);
		if($resultType == 'integer')	{	
			$store->id = $result;	
			$responseArray = array('status' => 'success' , 'message'=> 'Store created successfully.', 'store' => $store);
		}	
		else if($resultType == 'string'){
			$responseArray = array('status' => 'fail' , 'message' => 'Store already exists.');
		}
		else {
			$responseArray = array('status' => 'fail' , 'message' => 'Something went wrong please try again later');
		}
	}
}
echo json_encode($responseArray);


?>