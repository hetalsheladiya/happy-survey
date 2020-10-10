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

$firstname = trim($firstname);
$lastname = trim($lastname);
$businessname = trim($businessname);  

require_once './classes/store.php';
$store = new Store();
$qrCodeArray = $store->getStoreQrcode($userId);
// print_r($qrCodeArray); die();

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

        $aa = $profile->getForUserId($userId);
        if($aa->logo) {
            unlink($aa->logo);
        }

        $utility = new Utility();
        $fileUploadResult = $utility->uploadImage($uploadDirectory, $newFileName, "logo");
        if($fileUploadResult === true) {
            $profile->logo = $target . $newFileName;

            $source_properties = getimagesize($target.$newFileName);
            $image_type = $source_properties[2]; 
            if( $image_type == IMAGETYPE_JPEG ) {   
                $image_resource_id = imagecreatefromjpeg($target.$newFileName);
                $target_layer = $utility->fn_resize($image_resource_id, $source_properties[0], $source_properties[1]);
                imagejpeg($target_layer, $target.$newFileName);  
            }
            elseif( $image_type == IMAGETYPE_GIF )  {  
                $image_resource_id = imagecreatefromgif($target.$newFileName); 
                $target_layer = $utility->fn_resize($image_resource_id, $source_properties[0], $source_properties[1]);
                imagegif($target_layer, $target.$newFileName); 
            }
            elseif( $image_type == IMAGETYPE_PNG ) {
                $image_resource_id = imagecreatefrompng($target.$newFileName); 
                $target_layer = $utility->fn_resize($image_resource_id, $source_properties[0], $source_properties[1]);
                imagepng($target_layer, $target.$newFileName);
            }

            require_once './classes/store.php';
            $store = new Store();
            $qrCodeArray = $store->getStoreQrcode($userId);
            $i = 1;

            foreach ($qrCodeArray as $value) {
                $storeId = $value["storeId"];
                $file = $value["qrcodeimage"];
                $oldPdf = $value["sticker"];

                unlink($oldPdf);

            /*******************QRCODE PDF ***************/

             require_once  './classes/vendor/autoload.php';
             require_once './classes/random_compat-master/lib/random.php';

             require_once  './classes/colorextract/colors.inc.php';             
             $ex = new GetMostCommonColors();
             $num_results = 20;
             $reduce_brightness = 1;
             $reduce_gradients = 1;
             $delta = 24;
             $colors = $ex->Get_Color( $profile->logo, $num_results, $reduce_brightness, $reduce_gradients, $delta);
             $colorarray = array_values($colors);
             $index = array_search($colorarray[1], $colors);            
           
             $mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
             $pdfFolder = "qrcode-pdf/";
             
             $p = "qr-code{$timestamp}".$i.".pdf";
             $pdfFile_name = $pdfFolder.$p;

             $path_parts1 = pathinfo($BASE_URL.'qrcode-pdf/'.$p);
             $newPdfName =  $path_parts1['basename'];

             $html = '<body style="font-family: League Spartan; font-size: 10pt;">
                       <style>
                       @page {
                           margin: 0%;
                       }
                       h1{
                           margin-top:7.5%;
                           text-align: center;
                           font-family:League Spartan;
                           font-size:33px;
                           font-weight: bold;
                       }
                       </style>
                           <div class="main">
                               <div style="border: 23px solid #'.$index.';border-radius: 30px;">
                                   <h1>THANKS FOR CHOOSING</h1>
                                   <div style="text-align: center;margin-top:7%;">
                                       <img src="http://'."$_SERVER[HTTP_HOST]".'/'.$profile->logo.'" height="100" max-width="100%">
                                   </div>
                                   <h1>TO PROVIDE FEEDBACK SCAN QR CODE</h1>
                                   <div style="text-align: center;">
                                       <img src="http://'."$_SERVER[HTTP_HOST]".'/'.$file.'" height="385" width="385">
                                   </div>
                               </div>
                           </div>
                       </body>';

                  $mpdf->WriteHTML($html);
                  file_put_contents($pdfFile_name, $mpdf->Output($p, 'S'));

                  
                  $statement = $mysqli->prepare("UPDATE store SET stickerpdf = ? WHERE id LIKE ?");   
                  $statement->bind_param('si', $pdfFile_name , $storeId);
                  $r = $statement->execute();
                  $i++;
                  // $statement->close();
            }
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