<?php
header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './config.php';
require_once './classes/store.php';
$responseArray = array();
$storeId = @$_REQUEST['storeId'];
$userId = @$_REQUEST['userId'];

if($storeId == NULL || $storeId == ''){
	$responseArray = array('status' => 'fail', 'message' => 'Please provide storeId.' );
}
else if($userId == NULL || $userId == ''){
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId.' );
}
else{
	$store = new Store();
	$username = $store->getUserName($userId);

	// echo $username; die();

	$result = $store->updateStore($storeId, $userId, $username);			
	if($result)	{
		$responseArray = array('status' => 'success', 'message' => 'Storename updated successfully.', 'store' => $result);
	}
	else {
		$responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
	}
}
echo json_encode($responseArray);
?>