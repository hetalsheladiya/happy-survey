<?php
header('Content-Type: application/json');
require_once './dbconfig.php';
require_once './classes/user.php';

$user = new User();

$responseArray = array();

$requestMethod = $_SERVER['REQUEST_METHOD'];
if($requestMethod == 'POST'){
	$email = $_REQUEST['email'];
	$email = trim($email);
	$userId = $_REQUEST['userId'];

	if($userId == NULL || $userId == ""){
		$responseArray = array('status' => 'fail', 'message' => 'Please provide user id.');
	}	
	else{
		if($email != NULL){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $responseArray = array('status' => 'fail', 'message' => 'Invalid email format.');
            }
            else{
            	$result = $user->saveEmail($userId, $email);
            	if($result){
					$responseArray = array('status' => 'success', 'message' => 'Email updated successfully.');
				}
				else{
					http_response_code(400);
					$responseArray = array('status' => 'fail', 'message' => 'Something went wrong please try after sometime.');
				}
            }
			
		}
		else{
			$result = $user->saveEmail($userId, $email);
			if($result){
				$responseArray = array('status' => 'success', 'message' => 'Email updated successfully.');
			}
			else{
				http_response_code(400);
				$responseArray = array('status' => 'fail', 'message' => 'Something went wrong please try after sometime.');
			}
		}	
	}
}
else{
	http_response_code(404);
	$responseArray = array('status' => 'fail', 'message' => 'Page not found');
}
echo json_encode($responseArray);
?>