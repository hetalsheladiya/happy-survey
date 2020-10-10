<?php
header('Content-Type: application/json');
 
include_once './dbconfig.php';
require_once './classes/category.php';

$userId = @$_REQUEST['userId'];
$categoryId = @$_REQUEST['categoryId'];
$responseArray = array();
if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide user Id.');	
}
elseif($categoryId == NULL || $categoryId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide category Id.');
}
else {    
    $category = new Category();          
    $result = $category->getForId($categoryId, $userId);
    if($result){
    	$responseArray = array('status' => "success", "data" => $result);    
    }
    else{
    	$responseArray = array('status' => 'fail', 'data' => []);
    }   
}
echo json_encode($responseArray);
?>
