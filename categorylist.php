<?php
header('Content-Type: application/json');
 
require_once './dbconfig.php';

// require_once './config.php';

$page =  @$_REQUEST['page'];
$userId = @$_REQUEST['userId'];
$record_per_page = @$_REQUEST['per_page_record'];

($record_per_page == "") ? $record_per_page = 50 : "";

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
    $responseArray = array();   
    require_once './classes/category.php';
        $category = new Category();
    
        $list = array();

        $count = $category->getCountAll($userId);

        $pagelimit = ceil($count/$record_per_page);

        
        if ($page != NULL) {
            $list = $category->getAllCategoryWithPage($userId, $start_from, $record_per_page);        
        }
        else {
            $list = $category->getAllCategoryWithPage($userId, $start_from, $record_per_page);
        }
        
    $responseArray = array('status' => 'success', "data" => $list, "page" => $page, "pagelimit" => $pagelimit , "fetched" => count($list), "totalrecord" => $count);  
    }
      
//}
echo json_encode($responseArray);
?>



