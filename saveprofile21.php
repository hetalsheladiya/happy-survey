<?php

header('Content-Type: application/json');

include_once './config.php';
include_once './dbconfig.php';
require_once './classes/profile.php';
require_once './classes/utility.php';

$firstname = @$_REQUEST['firstname'];
$lastname = @$_REQUEST['lastname'];
$businessname = @$_REQUEST['businessname'];
$logo = @$_FILES['logo'];
// $background = @$_FILES["background"];
$userId = @$_REQUEST['userId'];
$deviceToken = @$_REQUEST['deviceToken'];

list($msec, $sec) = explode(' ', microtime());
$timestamp = (int) ($sec.substr($msec, 2, 3));

$responseArray = array();

if($userId == NULL || $userId == "") {
	$responseArray = array('status' => 'fail', 'message' => 'Please provide userId');
	echo json_encode($responseArray);
}
else {
    $profile = new Profile();
    $isNewUser = true;
    if($profile->getForUserId($userId) === true) {
        $isNewUser = false;
    }
    else {
        $profile->userId = $userId;
        $profile->createdAt = $timestamp;
    }
    $profile->updatedAt = $timestamp;

    if(!($firstname == NULL || $firstname == "")) {
        $profile->firstname = $firstname;
    }
    if(!($lastname == NULL || $lastname == "")) {
        $profile->lastname = $lastname;
    }
    if(!($businessname == NULL || $businessname == "")) {
        $profile->businessname = $businessname;
    }
    if($logo != NULL) {
        $uploadDirectory = "uploads/profile/";
        $extension = pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION);
        $newFileName = "l{$timestamp}." . $extension;
        $target = $uploadDirectory;

        $utility = new Utility();
        $fileUploadResult = $utility->uploadImage($uploadDirectory, $newFileName, "logo");
        if($fileUploadResult === true) {
            $profile->logo = $target . $newFileName;
        }
        else {
            $responseArray = array('status' => 'fail', 'message' => $fileUploadResult);
            echo json_encode($responseArray);
            return;
        }
    }
    // if($background != NULL) {
    //     $uploadDirectory = "uploads/profile/";
    //     $extension = pathinfo($_FILES["background"]["name"],PATHINFO_EXTENSION);
    //     $newFileName = "b{$timestamp}." . $extension;
    //     $target = $uploadDirectory;

    //     $utility = new Utility();
    //     $fileUploadResult = $utility->uploadImage($uploadDirectory, $newFileName, "background");
    //     if($fileUploadResult === true) {
    //         $profile->background = $target . $newFileName;
    //     }
    //     else {
    //         $responseArray = array('status' => 'fail', 'message' => $fileUploadResult);
    //         echo json_encode($responseArray);
    //         return;
    //     }
    // }
    
    global $mysqli;
    if ($isNewUser == false) {
        $result = $profile->save();
        if($result) {
            $profile->id = $result;
            $responseArray = array('status' => 'success', 'message' => 'Profile saved successfully.', 'profile' => $profile);
        }
        else {
            $responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
        }
    }
    else {
        $result = $profile->update();
        if($result) {
            $profile->id = $result;
            $responseArray = array('status' => 'success',  'message' => 'Profile updated successfully.', 'profile' => $profile);
        }
        else {
            $responseArray = array('status' => 'fail', 'message' => 'Please try again after sometime or contact to the Logileap LLC.', 'error' => $mysqli->error);
        }
    }
    echo json_encode($responseArray);
}
?>