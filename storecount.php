<?php
header('Content-Type: application/json');
 
include_once './dbconfig.php';
require_once './classes/user.php';
require_once './config.php';


$responseArray = array();
$user = new User();
$list = array();
   
$list = $user->getAllUserId();           

$responseArray = array('status' => "success", "data" => $list);    

echo json_encode($responseArray);
?>