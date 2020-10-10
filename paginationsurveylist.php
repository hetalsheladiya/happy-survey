<?php
header('Content-Type: application/json');
 
require_once './dbconfig.php';
require_once './classes/survey.php';
require_once './config.php';

$page =  @$_REQUEST['page'];
$userId = @$_REQUEST['userId'];
$storeId = @$_REQUEST['storeId'];
$createdAt = @$_REQUEST['createdAt'];
$record_per_page  = @$_REQUEST['per_page_record'];

$responseArray = array();   

if(@$_REQUEST['page'])
{
	$page = @$_REQUEST['page'];
}else{
	$page = 1;
}

$start_from = ($page - 1) * $record_per_page;


if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');	
}
else { 
       
        $survey = new Survey();
    
        $list = array();

        $count = ($storeId) ? $survey->getCount($userId, $storeId) : $survey->getsurveyCount($userId);

        $pagelimit = ceil($count/$record_per_page);

        
        if ($page != "") {
            $list = $survey->getAllWithLimit($userId, $start_from, $record_per_page, $storeId, $createdAt);       
        }
        else {
            $list = $survey->getAllWithLimit($userId, $start_from, $record_per_page, $storeId, $createdAt);
        }
            
        $responseArray = array('status' => 'success', "data" => $list, "page" => $page, "pagelimit" => $pagelimit , "fetched" => count($list), "totalrecord" => $count);  
    }
      
//}
echo json_encode($responseArray);
?>



