<?php
header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './classes/order.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$responseArray = array();
if ($requestMethod == 'POST') {
	$userId = @$_POST['userId'];
	$customerId = @$_POST['customerId'];
	$subscriptionId = @$_POST['subscriptionId'];
	$current_period_end = @$_POST['current_period_end'];
	$orderId = @$_POST['orderId'];
	list($msec, $sec) = explode(' ', microtime());
	$timestamp = (int) ($sec.substr($msec, 2, 3));
	// if($orderId){
		$order = new Order();		
		$result = $order->updateOrderCurrentPeriodTime($userId, $customerId, $subscriptionId, $current_period_end, $orderId, $timestamp);
		if($result){
			$responseArray = array('status' => 'success', 'message' => 'Plan end time has been updated.', 'data' => $result);
		}
		else{
			$responseArray = array('status' => 'fail', 'message' => 'Error occured while getting user order data.', 'data' => $result);
		}
	// }
	// else{	
	// 	if($userId == NULL || $userId == ""){
	// 		$responseArray = array('status' => 'fail', 'message' => 'Please provide user id.');
	// 	}
	// 	else{
	// 		$order = new Order();
	// 		$status = 'active';
	// 		$result = $order->getOrderData($userId, $status);
	// 		if($result){
	// 			$responseArray = array('status' => 'success', 'message' => '', 'data' => $result);
	// 		}
	// 		else{
	// 			$responseArray = array('status' => 'fail', 'message' => 'Error occured while getting user order data.', 'data' => $result);
	// 		}
	// 	}
	// }
}
else if($requestMethod == 'GET'){
	$userId = @$_REQUEST['userId'];
	if($userId == "" || $userId == NULL){
		$responseArray = array();
	}
	else{
		$order = new Order();
		$result = $order->getSubscriberData($userId);
		if($result){
			$responseArray = array('status' => 'success', 'message' => '', 'data' => $result);
		}
		else{
			$responseArray = array('status' => 'fail', 'message' => 'Error occured while getting user order data.', 'data' => $result);
		}
	}
}
else if($requestMethod == 'DELETE'){
	list($msec, $sec) = explode(' ', microtime());
	$timestamp = (int) ($sec.substr($msec, 2, 3));
	$userId = @$_REQUEST['userId'];
	$subscriptionId = @$_REQUEST['subscriptionId'];	
	$orderId = @$_REQUEST['orderId'];
	$status = @$_REQUEST['status'];
	$order = new Order();
	$result = $order->cancelOrder($userId, $subscriptionId, $orderId, $status, $timestamp);
	if($result){
		$responseArray = array('status' => 'success', 'message' => 'Your subscription has been canceled successfully.');
	}
	else{
		$responseArray = array('status' => 'fail', 'message' => 'Error occured while canceled subscription.');
	}
}
else{
	$responseArray = array('status' => 'fail', 'message' => 'Page not found.');
}
echo json_encode($responseArray);

?>