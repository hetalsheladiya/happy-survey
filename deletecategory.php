<?php

header('Content-Type: application/json');
 
include_once './dbconfig.php';
require_once './classes/category.php';

$userId = @$_REQUEST['userId'];
$categoryId = @$_REQUEST['categoryId'];
$storeId = @$_REQUEST['storeId'];

list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));

$responseArray = array();

if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
	echo json_encode($responseArray);
}
else if($categoryId == NULL || $categoryId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide categoryId');
	echo json_encode($responseArray);
}
else {
    $category = new Category();

    if($storeId == NULL){

    	$result = $category->delete($categoryId, $userId);
    }else    {
    	
        $result = $category->deleteWithStore($categoryId, $userId, $storeId);
    }   
        
    if (gettype($result) == "boolean") {
    	if($result) {
	        $responseArray = array('status' => 'success', 'message' => 'Category removed successfully.');
		}
		else {
			$responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
	    }
    }
    else {
    	$responseArray = array('status' => 'fail', 'message' => $result);
    }
    
    echo json_encode($responseArray);
}
?>