<?php
header('Content-Type: application/json');
require_once './dbconfig.php';
require_once './config.php';
require_once './classes/subscription.php';
require_once './stripe-php/init.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestMethod == 'POST'){
	$token = @$_POST['stripeToken'];
	$userId = @$_POST['userId'];
	$name = @$_POST['name'];
	$email = @$_POST['email'];
	$card_number = preg_replace('/\s+/', '', $_POST['card_number']);
	$card_exp_month = $_POST['card_exp_month'];
	$card_exp_year = $_POST['card_exp_year'];
	$card_cvc = $_POST['card_cvc'];	

	list($msec, $sec) = explode(' ', microtime());
	$timestamp = (int) ($sec.substr($msec, 2, 3));

	$responseArray = array();
	$obj = new Subscription();
		$result = $obj->createSubscription($token, $email);
		if($result){
			if($result['status'] == 'active' && $result["quantity"] == 1){

				global $itemName, $itemNumber, $itemPrice, $currency;

				$obj->userId = $userId;
				$obj->customerId = $result['customer'];
				$obj->subscriptionId = $result['id'];
				$obj->name = $name;
				$obj->email = $email;
				$obj->card_number = $card_number;
				$obj->card_exp_month = $card_exp_month;
				$obj->card_exp_year = $card_exp_year;
				$obj->itemName = $itemName;
				$obj->itemNumber = $itemNumber;
				$obj->itemPrice = $itemPrice;
				$obj->currency = $currency;
				// $obj->paidAmount = $paidAmount;
				// $obj->paidCurrency = $paidCurrency;
				// $obj->transactionID = $transactionID;
				$obj->current_period_end = $result['current_period_end'];
				$obj->payment_status = $result['status'];
				$obj->orderId = $result['metadata']['order_id'];
				$obj->createdAt = $timestamp;
				$obj->updatedAt = $timestamp;

				$obj->saveUserSubscription();

				$responseArray = array('status' => 'success', 'message' => 'Token successfully created.', 'data' => $result);
			}
			else{
				$responseArray = array('status' => 'fail', 'message' => 'Your payment has failed!', 'data' => $result);
			}			
		}
		else{
			$responseArray = array('status' => 'fail', 'message' => 'Transaction has been failed!', 'data' => $result);
		}
	
	echo json_encode($responseArray);
}
else{
	http_response_code(404);
	$responseArray = array('status' => 'fail', 'message' => 'Page not found.');
	echo json_encode($responseArray);
}

?>