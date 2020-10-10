<?php

header('Content-Type: application/json');
 
include_once './config.php';
include_once './dbconfig.php';
require_once './classes/category.php';
require_once './classes/utility.php';

$name = @$_REQUEST['name'];
$userId = @$_REQUEST['userId'];
$storeId = @$_REQUEST['storeId'];
$name = trim($name);
list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));

$responseArray = array();

if($name == NULL || $name == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide name.');	
}
else if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide user id.');	
}
else if($storeId == 0){
    $responseArray = array('status' => 'fail', 'message' => "Please create your store after that you can add category.");
}
else {
    $category = new Category();
    $category->name = $name;
    $category->userId = (int) $userId;   
    $category->createdAt = $timestamp;
    $category->updatedAt = $timestamp;
    $category->storeId = $storeId;  

    $checkExistingName = $category->checkCategoryName($storeId, $userId, $name);
    if($checkExistingName > 0){
        $responseArray = array('status' => 'fail', 'message' => 'Category name already exist. Try with another name.');
    }
    else{
        $countCategory = $category->getCountCategoryWithStore($userId,$storeId);
        if($countCategory > 8){
            $responseArray = array('status' => 'fail', 'message' => 'Can not create morethan 8 categories.');
        }
        else{
            $result = $category->saveWithStore();
            if($result){
                $category->id = $result;        
                $responseArray = array('status' => 'success', 'message' => 'Category saved successfully.', 'category' => $category);
            }
            else{
                 $responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
            }
        }
    }   
}
echo json_encode($responseArray);

?>