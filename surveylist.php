<?php
header('Content-Type: application/json');
 
include_once './dbconfig.php';
require_once './config.php';    
require_once './classes/survey.php';
require_once './classes/category.php';

$time = @$_REQUEST['time'];
$userId = @$_REQUEST['userId'];
$limit = @$_REQUEST['limit'];
$lastId = @$_REQUEST['lastId'];
$storeId = @$_REQUEST['storeId'];
$createdAt = @$_REQUEST['createdAt'];
$userTimestamp = @$_REQUEST['userTimestamp'];

if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
	// echo json_encode($responseArray);
}
else {
    $responseArray = array();
    $survey = new survey();
    $list = array();

    if($limit == NULL || $limit == "") {
        $limit = 20;
    }
    if($lastId == NULL || $lastId == "") {
        $lastId = "";
    }
    if($storeId == NULL || $storeId == "") {
        $storeId = "";
    }
    $category = new Category();
        // if($userTimestamp == ""){
            switch ($time) {
                case  "day":
                    $d = date('Y/m/d h:i:s', strtotime('-1 day', strtotime(date("Y/m/d h:i:s"))));
                    $dtime = DateTime::createFromFormat('Y/m/d h:i:s', $d)->getTimestamp() * 1000;
                    $list = $survey->getAllWithLimitAndTillTime($userId, $dtime, $lastId, $limit, $storeId, $createdAt);
                    $count = $survey->getSurveyCountWithTime($userId, $storeId, $dtime);
                    $pagelimit = ceil($count/$limit);
                    $categoryList = $category->getSurveyCategory($userId, $storeId);
                    break;
                case "week":
                    $d = date('Y/m/d h:i:s', strtotime('-1 week', strtotime(date("Y/m/d h:i:s"))));
                    $dtime = DateTime::createFromFormat('Y/m/d h:i:s', $d)->getTimestamp() * 1000;
                    $list = $survey->getAllWithLimitAndTillTime($userId, $dtime, $lastId, $limit, $storeId, $createdAt);
                    $count = $survey->getSurveyCountWithTime($userId, $storeId, $dtime);
                    $pagelimit = ceil($count/$limit);
                    $categoryList = $category->getSurveyCategory($userId, $storeId);
                    break;
                case "month":
                    $d = date('Y/m/d h:i:s', strtotime('-1 month', strtotime(date("Y/m/d h:i:s"))));
                    $dtime = DateTime::createFromFormat('Y/m/d h:i:s', $d)->getTimestamp() * 1000;
                    $list = $survey->getAllWithLimitAndTillTime($userId, $dtime, $lastId, $limit, $storeId, $createdAt);
                    $count = $survey->getSurveyCountWithTime($userId, $storeId, $dtime);
                    $pagelimit = ceil($count/$limit);
                    $categoryList = $category->getSurveyCategory($userId, $storeId);
                    break;
                case "year":
                    $d = date('Y/m/d h:i:s', strtotime('-1 year', strtotime(date("Y/m/d h:i:s"))));
                    $dtime = DateTime::createFromFormat('Y/m/d h:i:s', $d)->getTimestamp() * 1000;
                    $list = $survey->getAllWithLimitAndTillTime($userId, $dtime, $lastId, $limit, $storeId, $createdAt);
                    $count = $survey->getSurveyCountWithTime($userId, $storeId, $dtime);
                    $pagelimit = ceil($count/$limit);
                    $categoryList = $category->getSurveyCategory($userId, $storeId);
                    break;
                default:
                    $list = $survey->getAllWithLimit($userId, $lastId, $limit, $storeId, $createdAt);
                    $count = $survey->getSurveyCount($userId, $storeId);
                    $pagelimit = ceil($count/$limit);
                    $categoryList = $category->getSurveyCategory($userId, $storeId);
            }
            
        // }
        // else
        // {
        //     $dtime = @$_REQUEST['userTimestamp'];
        //     $list = $survey->getAllWithLimitLastId($userId, $lastId, $limit, $storeId);
        // }


    // if($list != NULL) {
        $responseArray = array('status' => "success", "data" => $list, "pagelimit" => $pagelimit , "fetched" => count($list), "totalrecord" => $count, 'categoryList' => $categoryList);
    // }
    // else {
    //     echo "Fail";
    //     print_r($list);
    //     $responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
    // }    
}
echo json_encode($responseArray);
?>
