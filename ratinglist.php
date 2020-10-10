<?php
header('Content-Type: application/json');

require_once './dbconfig.php';
require_once './classes/rating.php';

$userId = @$_REQUEST['userId'];
$storeId = @$_REQUEST['storeId'];

$page =  @$_REQUEST['page'];
$lastId = @$_REQUEST['lastId'];
$limit = @$_REQUEST['limit'];
$record_per_page = @$_REQUEST['per_page_record'];

if(@$_REQUEST['page'])
{
    $page = @$_REQUEST['page'];
}else{
    $page = 1;
}
$start_from = ($page - 1) * $record_per_page;

$responseArray = array();

if($userId == "" || $userId == NULL){
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
}
else{
	$rating = new Rating();
	$count = $rating->getCountAll($userId);
    $pagelimit = ceil($count/$record_per_page);

	if($storeId != ""){
		$list = $rating->getRatingListWithStore($userId, $storeId, $start_from, $record_per_page);
		if($list){
			$responseArray = array('status' => 'success', 'data' => $list, "page" => $page, "pagelimit" => @$pagelimit , "fetched" => count($list), "totalrecord" => $count);
		}else{
			$responseArray = array('status' => 'fail', 'message' => 'Something went wrong Please try again later', 'data' => []);
		}
	}else{
		$list = $rating->getRatingList($userId, $start_from, $record_per_page);
		if($list){
			$responseArray = array('status' => 'success', 'data' => $list, "page" => $page, "pagelimit" => @$pagelimit , "fetched" => count($list), "totalrecord" => $count);
		}
		else{
			$responseArray = array('status' => 'fail', 'message' => 'Something went wrong Please try again later', 'data' => []);
		}
	}
}
echo json_encode($responseArray);
?>
