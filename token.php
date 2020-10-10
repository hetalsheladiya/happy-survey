<?php
header('Content-Type: application/json');
require_once './dbconfig.php';
require_once './config.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestMethod == 'POST'){	
	$userId = $_POST['userId'];	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$card_number = preg_replace('/\s+/', '', $_POST['card_number']);
	$card_exp_month = $_POST['card_exp_month'];
	$card_exp_year = $_POST['card_exp_year'];
	$card_cvc = $_POST['card_cvc'];
	list($msec, $sec) = explode(' ', microtime());
	$timestamp = (int) ($sec.substr($msec, 2, 3));
	$responseArray = array();
	
	if($userId == NULL || $userId == ""){
		$responseArray = array('status' => 'fail', 'message' => 'Please provide user id.');
	}	
	else if($name == "" || $name == NULL){
		$responseArray = array('status' => 'fail', 'message' => 'Please provide name.');
	}
	else if($email == "" || $email == NULL){
		$responseArray = array('status' => 'fail', 'message' => 'Please provide email.');
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $responseArray = array('status' => 'fail', 'message' => 'Invalid email.');
    }
	else if ($card_number == "" || $card_number == NULL) {
		$responseArray = array('status' => 'fail', 'message' => 'Please provide card_number');
	}
	else if(strlen($card_number) < 15){
		$responseArray = array('status' => 'fail', 'message' => 'Please provide valid card_number.');
	}
	else if($card_exp_month == "" || $card_exp_month == NULL){
		$responseArray = array('status' => 'fail', 'message' => 'Please provide card expiry month.');
	}
	else if($card_exp_year == "" || $card_exp_year == NULL){
		$responseArray = array('status' => 'fail', 'message' => 'Please provide card expiry year.');
	}
	else if(strlen($card_exp_year) < 4 || $card_exp_year < 2020){
		$responseArray = array('status' => 'fail', 'message' => 'Please provide valid expiry year.');
	}
	else if($card_cvc == "" || $card_cvc == NULL){
		$responseArray = array('status' => 'fail', 'message' => 'Please provide card cvc code.');
	}
	else {
		$responseArray = array('status' => 'success', 'message' => '');		
	}
	echo json_encode($responseArray);
}
else{
	http_response_code(404);
	$responseArray = array('status' => 'fail', 'message' => 'Page not found.');
	echo json_encode($responseArray);
}

?>