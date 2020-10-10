<?php
header('Content-Type: application/json');
 
include_once './dbconfig.php';
require_once './classes/store.php';
require_once './config.php';

$userId = @$_REQUEST['userId'];
$lastId = @$_REQUEST['lastId'];
$limit = @$_REQUEST['limit'];
//$record_per_page = $_REQUEST['per_page_record'];

/*if(@$_REQUEST['page'])
{
    $page = @$_REQUEST['page'];
}else{
    $page = 1;
}*/
////$record_per_page= 3;
//$start_from = ($page - 1) * $record_per_page;

if($userId == NULL || $userId == "") {
    $responseArray = array('status' => 'fail', 'message' => 'Please provide userId');   
}
else {
    $responseArray = array();
    $store = new Store();
    $list = array();
    //$count = $store->getCountAll($userId);
   // $pagelimit = ceil($count/$record_per_page);

    //if($record_per_page == "") {
         if($lastId != NULL && $limit != NULL) {
        $list = $store->getList($userId, $lastId, $limit);
        }
        else if($limit != NULL) {
            $list = $store->getList($userId, "", $limit);
        }
        else if ($lastId != NULL) {
            $list = $store->getList($userId, $lastId, 20);
        }
        else {
            $list = $store->getList($userId, "", 20);
        }
   /* }else{
        $list = $store->getListWithPage($userId, $start_from, $record_per_page);
    }*/
   
    
    $responseArray = array('status' => "success", "data" => $list/*, "page" => $page, "pagelimit" => $pagelimit , "fetched" => count($list), "totalrecord" => $count*/);    
}
echo json_encode($responseArray);
?>
