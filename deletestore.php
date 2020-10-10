<?php
header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './config.php';
require_once './classes/store.php';

$storeId = @$_REQUEST['storeId'];
$userId = @$_REQUEST['userId'];

$responseArray = array();	
if($storeId == NULL || $storeId == '')
{
	$responseArray = array('status' => 'fail', 'message' => 'Please provide storeId.' );
}
else if($userId == NULL || $userId == '')
{
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId.' );
}else{

	$store = new Store();
	$store = $store->getForId($storeId, $userId);

	if($store == NULL)
	{
		$responseArray = array('status' => 'fail', 'message' => 'store not exists.' );
	}
	else
	{
		$result = $store->delete($storeId, $userId);	 

		if($result)
		{
			$responseArray = array('status' => 'success', 'message' => 'Store removed successfully.' );
		}
		else {
			$responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
		}
	}

	
	

}
echo json_encode($responseArray);