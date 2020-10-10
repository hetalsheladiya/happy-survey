<?php

header('Content-Type: application/json');

require_once './config.php'; 
require_once './dbconfig.php';
require_once './classes/user.php';
require_once './classes/utility.php';

$companyname = @$_REQUEST['companyname'];
$username = @$_REQUEST['username'];
$email = @$_REQUEST['email'];
$password = @$_REQUEST['password'];
$logo = @$_FILES['logo'];

$companyname = trim($companyname);
$username = trim($username);
$email = trim($email);
$password = trim($password);

// $captcha = @$_REQUEST['g-recaptcha-response'];
// $secretKey = "6LcrDa8UAAAAAJzKwvP6fwjz7_tenVf1mixroTE4";
// $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
// $response = file_get_contents($url);
// $responseArray = array();

list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));

$user = new User();
$existingUser = $user->getForUsername($username);

// if($companyname == NULL || $companyname == "") {
// 	$responseArray = array('status' => 'fail', 'message' => 'Please provide Companyname');	
// }
if($username == NULL || $username == "") {
    $responseArray = array('status' => 'fail', 'message' => 'Please provide username.');  
}
else if($existingUser != NULL) {
    $responseArray = array('status' => 'fail', 'message' => "User already exist with username {$username} please try with login.");
}
else if($password == NULL || $password == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide password.');	
}
else if(strlen($password) < 6){
    $responseArray = array('status' => 'fail', 'message' => 'Your password must contain at least 6 characters.');
}
// else if(!$captcha){
//  $responseArray = array('status' => 'fail', 'message' => 'Please check the the captcha form'); 
// }
else {    
    // $responseKeys = json_decode($response,true);
    // if($responseKeys["success"]){

        if($email != NULL || $email != "") {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $responseArray = array('status' => 'fail', 'message' => 'Invalid email format.');
            }
            elseif($existingUser == NULL) {
                $user->companyname = $companyname;
                $user->username = $username;
                $user->email = $email;
                $user->password = $password;
                $user->createdAt = $timestamp;
                $user->updatedAt = $timestamp;
                $user->logo = $logo;
                $result = $user->save();

                if($result) {
                    $user->id = $result;                  

                    require_once './classes/store.php';
                    $storeList = new Store();
                    $user->stores = $storeList->getList($user->id);

                    // require_once './classes/category.php';
                    // $category = new category();
                    // $list = array();
                    // $list = $category->getAll($user->id, "", 20);
                    // $user->categories = $list;

                    // if ($deviceToken != "") {
                        
                    //     $userDeviceToken = new UserDeviceToken();
                        
                    //     $userDeviceToken->userId = $result;
                    //     $userDeviceToken->deviceToken = $deviceToken;
                    //     $userDeviceToken->platform = $platform;
                    //     $userDeviceToken->deviceType = $deviceType;
                    //     $userDeviceToken->isDebug = $isDebug;
                    //     $userDeviceToken->createdAt = $timestamp;
                    //     $userDeviceToken->updatedAt = $timestamp;
                    //     $userDeviceToken->saveOrUpdate();
                    // }
                    require_once './classes/profile.php';
                    $profile = new Profile();                    
                    $profile->getForUserId($user->id);                    
                   
                    $responseArray = array('status' => 'success', 'user' => $user, 'profile' => $profile, 'message' => 'Please check your email for confirmation.');                   
                    
                }
                else {
                    global $mysqli;
                    $responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
                }
            }
           
        }
        else{
        
            if($existingUser == NULL) {
                $user->companyname = $companyname;
                $user->username = $username;
                $user->email = $email;
                $user->password = $password;
                $user->createdAt = $timestamp;
                $user->updatedAt = $timestamp;
                $user->logo = $logo;
                $result = $user->save();

                if($result) {
                    $user->id = $result;

                    require_once './classes/store.php';
                    $storeList = new Store();
                    $user->stores = $storeList->getList($user->id);

                    // require_once './classes/category.php';
                    // $category = new category();
                    // $list = array();
                    // $list = $category->getAll($user->id, "", 20);
                    // $user->categories = $list;

                    // if ($deviceToken != "") {
                        
                    //     $userDeviceToken = new UserDeviceToken();
                        
                    //     $userDeviceToken->userId = $result;
                    //     $userDeviceToken->deviceToken = $deviceToken;
                    //     $userDeviceToken->platform = $platform;
                    //     $userDeviceToken->deviceType = $deviceType;
                    //     $userDeviceToken->isDebug = $isDebug;
                    //     $userDeviceToken->createdAt = $timestamp;
                    //     $userDeviceToken->updatedAt = $timestamp;
                    //     $userDeviceToken->saveOrUpdate();
                    // }
                    require_once './classes/profile.php';
                    $profile = new Profile();
                    // $profile->userId = $user->id;            
                    // $profile->createdAt = $timestamp;
                    // $profile->businessname = $companyname;
                    // $profile->id = $profile->save();
                    $profile->getForUserId($user->id);  

                    
                    $responseArray = array('status' => 'success', 'user' => $user, 'profile' => $profile, 'message' => 'Your account is ready to use.');                   
                    
                }
                else {
                    global $mysqli;
                    $responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
                }
            }
        }
        // else {
        //     $responseArray = array('status' => 'fail', 'message' => "User already exist with username {$username}.");
        // }
    // // }
    // else{
    //     $responseArray = array('status' => 'fail', 'message' => 'You are spammer!');
    // }

        
}
echo json_encode($responseArray);
?>
