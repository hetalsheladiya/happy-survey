<?php
header('Content-Type: application/json');
 
include_once './dbconfig.php';
require_once './classes/store.php';

$userId = @$_REQUEST['userId'];
$storeId = @$_REQUEST['storeId'];
$responseArray = array();
if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');	
}
elseif($storeId == NULL || $storeId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide storeId');
}
else {    
    $store = new Store();          
    $result = $store->getForId($storeId, $userId);
    if($result){
    	$responseArray = array('status' => "success", "data" => $result);    
    }
    else{
    	$responseArray = array('status' => 'fail', 'data' => []);
    }    
    
}
echo json_encode($responseArray);
?>
