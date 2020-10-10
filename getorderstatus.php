<?php

header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './classes/order.php';
require_once './config.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$responseArray = array();
if ($requestMethod == 'POST') {
	$userId = @$_POST['userId'];	
	$subscriptionId = @$_POST['subscriptionId'];

	$order = new Order();

	$result = $order->getOrderData($userId, $subscriptionId);
	if($result){
		$responseArray = array('status' => 'success', 'message' => 'Your payment has been received!', 'data' => $result);
	}
	else{
		$responseArray = array('status' => 'fail', 'message' => 'Error occured while getting user order data.', 'data' => $result);
	}
	echo json_encode($responseArray);

}
else{
	$responseArray = array('status' => 'fail', 'message' => 'Page not found.');
	echo json_encode($responseArray);
}

?>