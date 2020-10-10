<?php
header('Content-Type: application/json');
 
require_once './dbconfig.php';
require_once './classes/surveycategory.php';

$time = @$_REQUEST['time'];
$userId = @$_REQUEST['userId'];
$storeId = @$_REQUEST['storeId'];
if($userId == NULL || $userId == "") {
    $responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
    echo json_encode($responseArray);
}
else {    

    $surveycategory = new SurveyCategory();
    $result = $surveycategory->getSurveyCategoryRating($storeId, $userId);
    if($result){
        $responseArray = array('status' => "success", "data" => $result);
    }
    else{
        $responseArray = array('status' => "fail", 'message' => 'Error occured while getting categories rating.', "data" => []);
    }
    echo json_encode($responseArray);
}

?>
