<?php
header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './config.php';
require_once './classes/store.php';

$name = @$_REQUEST['name'];
$storeId = @$_REQUEST['storeId'];
$userId = @$_REQUEST['userId'];
$googleLink = @$_REQUEST['googleLink'];
$welcomeMsg = @$_REQUEST['welcomeMsg'];
$customMsg = @$_REQUEST['customMsg'];

$customerName = @$_REQUEST['customerName'];
$customerPhone = @$_REQUEST['customerPhone'];
$customerEmail = @$_REQUEST['customerEmail'];
$customerComment = @$_REQUEST['customerComment'];
$yelp = @$_REQUEST['yelp'];
$yelpUrl = @$_REQUEST['yelpUrl'];

$name = trim($name);
$googleLink = trim($googleLink);
$welcomeMsg = trim($welcomeMsg);
$customMsg = trim($customMsg);

list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));


$responseArray = array();
if($name == NULL || $name == '') {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide name.' );
}	
else if($storeId == NULL || $storeId == '') {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide storeId.' );
}
else if($userId == NULL || $userId == '') {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId.' );
}
else if(($googleLink != NULL || $googleLink != "") && (!preg_match_all('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $googleLink))){	
 	$responseArray = array('status' => 'fail', 'message' => 'Please provide valid google URL link.');
}
else if($yelp == 1 && ($yelpUrl == "" || $yelpUrl == NULL)){	
	$responseArray = array('status' => 'fail', 'message' => 'Please provide yelp url.');	
}
else if($yelp == 1 && !preg_match_all('#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si', $yelpUrl)){
	$responseArray = array('status' => 'fail', 'message' => 'Please provide valid yelp url link.');
}
else{
	($customerName == NULL) ? $customerName = 0 : $customerName;
	($customerPhone == NULL) ? $customerPhone = 0 : $customerPhone;
	($customerEmail == NULL) ? $customerEmail = 0 : $customerEmail;
	($customerComment == NULL) ? $customerComment = 0 : $customerComment;

	$store = new Store();
	$store->storeId = $storeId;
	$store->name = $name;
	$store->userId = $userId;	
	$store->createdAt = $timestamp;
	$store->updatedAt = $timestamp;
	$store->welcomeMsg = $welcomeMsg;
	$store->customMsg = $customMsg;
	$store->customerName = $customerName;	
	$store->customerPhone = $customerPhone;
	$store->customerEmail = $customerEmail;
	$store->customerComment = $customerComment;

	if($googleLink){
		$gl = explode("://", $googleLink);
		($gl[0] != 'http' && $gl[0] != 'https') ? $googleLink = "http://".$googleLink : $googleLink;
	}
	if($yelpUrl){
		$yl = explode("://", $yelpUrl);
		($yl[0] != 'http' && $yl[0] != 'https') ? $yelpUrl = "http://".$yelpUrl : $yelpUrl;		
	}

	$store->yelpUrl = $yelpUrl;

	if($store->getCountStoreNameWithId($name, $userId, $storeId) > 0){				
		$responseArray = array('status' => 'fail' , 'message' => 'Store already exists.');
	}
	else{
		$result = $store->update($name, $storeId, $userId, $timestamp, $googleLink, $welcomeMsg, $customMsg);
		if($result)	{	
			$store->id = $result;	
			$responseArray = array('status' => 'success' , 'message'=> 'Store created successfully.');
		}	
		else {
			$responseArray = array('status' => 'fail' , 'message' => 'Something went wrong please try again later.');
		}
	}
}
echo json_encode($responseArray);