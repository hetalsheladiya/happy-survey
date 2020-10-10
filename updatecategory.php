<?php

header('Content-Type: application/json');

include_once './config.php';
include_once './dbconfig.php';
require_once './classes/category.php';

$name = @$_REQUEST['name'];
$userId = @$_REQUEST['userId'];
$categoryId = @$_REQUEST['categoryId'];
$storeId = @$_REQUEST['storeId'];

$name = trim($name);

list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));

$responseArray = array();

if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');	
}
else if($categoryId == NULL || $categoryId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide categoryId');	
}
else if ($name == "" || $name == NULL) {
    $responseArray = array('status' => 'fail' , 'message' => 'Please provide name');
}
else if($storeId == 0){
     $responseArray = array('status' => 'fail' , 'message' => 'Please select store');
}
else {
    $category = new Category();
    $category->id = $categoryId;
    $category->name = $name;    
    $category->updatedAt = $timestamp;
    $category->userId = $userId;
    $category->storeId = $storeId;   
    
    $checkNameCount = $category->checkCategoryNameWithId($storeId, $userId, $name, $categoryId);
    if($checkNameCount > 0){
        $responseArray = array('status' => 'fail', 'message' => 'Category name already exists.');
    }
    else {      
        
        $result = $category->__update();
        if($result) {
        $responseArray = array('status' => 'success', 'message' => 'Category saved successfully.', 'category' => $category);
        }
        else {
            $responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
        }               
    }     
}
echo json_encode($responseArray);
?>