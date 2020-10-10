<?php
header('Content-Type: application/json');
require_once './dbconfig.php';
require_once './classes/store.php';

$resonseArray = array();

$userId = @$_REQUEST['userId'];

$store = new Store();
$list = $store->getList($userId);
if($list){
	$resonseArray = array('status' => 'success', 'data' => $list);
}
else{
	$resonseArray = array('status' => 'fail', 'data' => []);
}
echo json_encode($resonseArray);
?>