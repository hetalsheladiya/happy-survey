<?php
header('Content-Type: application/json');
 
include_once './dbconfig.php';
require_once './classes/survey.php';
require_once './classes/category.php';

$time = @$_REQUEST['time'];
$userId = @$_REQUEST['userId'];
$storeId = @$_REQUEST['storeId'];
if($userId == NULL || $userId == "") {
    $responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
    echo json_encode($responseArray);
}
else {
    $category = new Category();
    $responseArray = array();

    $list = $category->getAll($userId, "", 20, $storeId);
   
    
    $sadCount = 0;
    $neutralCount = 0;
    $happyCount = 0;

    $survey = new Survey();
    $dataArray = array();
    foreach ($list as $data) {        
        $category = array();
        $categoryId = $data->id;
        $category['name'] = $data->name;
        $category['sadCount'] = ($storeId) ? $survey->getSurveyCategoryResultCountWithStore(0, $categoryId, $userId, $storeId) : 
                                             $survey->getSurveyCategoryResultCount(0, $categoryId, $userId);
        $category['neutralCount'] = ($storeId) ? $survey->getSurveyCategoryResultCountWithStore(1, $categoryId, $userId, $storeId) : 
                                                 $survey->getSurveyCategoryResultCount(1, $categoryId, $userId);
        $category['happyCount'] = ($storeId) ? $survey->getSurveyCategoryResultCountWithStore(2, $categoryId, $userId, $storeId) : 
                                               $survey->getSurveyCategoryResultCount(2, $categoryId, $userId) ;
        $category['totalCategoryCount'] = $category['sadCount']+$category['neutralCount']+$category['happyCount'];
        $dataArray[] = $category;
    }

    $categoryArray = $dataArray;

    $result = array();

    if($storeId){
        $totalSadCount = $survey->getAllSurveyResultCountWithStore(0, $userId, $storeId);
        $totalNutralCount = $survey->getAllSurveyResultCountWithStore(1, $userId, $storeId);
        $totalHappyCount = $survey->getAllSurveyResultCountWithStore(2, $userId, $storeId);
    }
    else{
        $totalSadCount = $survey->getAllSurveyResultCount(0, $userId);
        $totalNutralCount = $survey->getAllSurveyResultCount(1, $userId);
        $totalHappyCount = $survey->getAllSurveyResultCount(2, $userId);
    }   

    $totalCount = $totalSadCount + $totalNutralCount + $totalHappyCount;

    $result["totalCount"] = $totalCount;
    $result["category"] = $dataArray;
    $result["totalSadCount"] = $totalSadCount;
    $result["totalNeutralCount"] = $totalNutralCount;
    $result["totalHappyCount"] = $totalHappyCount;
    
    
        $responseArray = array('status' => "success", "data" => $result);
    

    echo json_encode($responseArray);
}

?>
