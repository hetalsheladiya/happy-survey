<?php
header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './classes/category.php';

$userId = $_REQUEST['userId'];
$storeId = $_REQUEST['storeId'];

$responseArray = array();

if($userId == "" || $userId == NULL){
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
}
elseif ($storeId == "" || $storeId == NULL) {
	$responseArray = array('status' => 'fail' , 'message' => 'Please Provide storeId');
}
else{
	$category = new Category();
	$list = $category->getCategoryWithStore($userId, $storeId);
	if($list){
		$responseArray = array('status' => 'success', 'data' => $list);
	}
	else{
		$responseArray = array('status' => 'fail', 'message' => 'Something went wrong please try again later');
	}
}
echo json_encode($responseArray);
?>