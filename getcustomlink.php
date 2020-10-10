<?php
header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './classes/rating.php';
require_once './classes/store.php';

$userId = @$_REQUEST['userId'];
$storeId = @$_REQUEST['storeId'];

$responseArray = array();

if($userId == "" || $userId == NULL){
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
}
else if ($storeId == "" || $storeId == NULL) {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide storeId');
}
else{
	$rating = new Rating();	
	$result = $rating->getCustomUrlAfterRating($userId, $storeId);

	$store = new Store();
	$fieldData = $store->getCustomFieldValue($userId, $storeId);
	if($result){
		$responseArray = array('status' => 'success', 'data' => $result, 'fieldData' => $fieldData);
	}
	else{
		$responseArray = array('status' => 'fail', 'message' => "Something went wrong please try again later");
	}
}
echo json_encode($responseArray);
?>