<?php
header('Content-Type: application/json');
 
include_once './dbconfig.php';
require_once './classes/store.php';
require_once './config.php';

$userId = @$_REQUEST['userId'];
$lastId = @$_REQUEST['lastId'];
$limit = @$_REQUEST['limit'];

if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');	
}
else {
    $responseArray = array();
    $store = new Store();
    $list = array();
        
        $list = $store->getList($userId, "", 20);             
    
    $responseArray = array('status' => "success", "data" => $list);    
}
echo json_encode($responseArray);
?>
