<?php

/**
 * 
 */
class User 
{
	public $id = 0;
	public $username = "";
	public $password = "";
	public $timestamp = 0;
    public $status = 1;
	
    public function saveEmail($userId, $email){
        global $mysqli;
        $statement = $mysqli->prepare("UPDATE user SET email = ? WHERE id LIKE ?");
        $statement->bind_param('si', $email, $userId);
        $r = $statement->execute();
        if($r)
            return true;
        else 
            return false;
    }
    public function saveEnquiry($name, $email, $message, $createdAt, $uId){
        global $mysqli;
        $statement = $mysqli->prepare("INSERT INTO contactinfo(name, email, message, createdAt, updatedAt, userId)VALUES(?,?,?,?,?,?)");
        $statement->bind_param('sssddi', $name, $email, $message, $createdAt, $createdAt, $uId);
        $r = $statement->execute();
        $statement->close();
        if($r){
            return $mysqli->insert_id;
        }
        else{
            return $mysqli->error;
        }
    }
	public function userActivation($uId){
        global $mysqli;
        $statement = $mysqli->prepare("UPDATE user SET status = 1 WHERE id LIKE ?");
        $statement->bind_param('i', $uId);
        $r = $statement->execute();
        $statement->close();
        if($r){
            return true;
        }
        else{
            echo $mysqli->error;
            exit();
        }
    }

    public function changedPwd($pwd, $uId){
        global $mysqli;
        $newPwd = md5($pwd);
        $statement = $mysqli->prepare("UPDATE user SET password = ? WHERE id = ?");
        $statement->bind_param('si', $newPwd, $uId);
        $r = $statement->execute();
        if($statement){         
            $statement = $mysqli->prepare("SELECT id, username FROM user WHERE id LIKE ?");
            $statement->bind_param('i', $uId);
            $statement->execute();
            $statement->bind_result($id, $username);
            while ($statement->fetch()) {               
                $o = new User();
                $o->id = $id;
                $o->username = $username;           
            }   
            $statement->close();        
            return $o;
        }
        else{
            return false;
        }
    }

    public function getOldPassword($oldpassword, $userId){
        global $mysqli;
        $pas = md5($oldpassword);
        $statement = $mysqli->prepare("SELECT password FROM user WHERE password = ? AND id = ?");
        $statement->bind_param('si', $pas, $userId);
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();
        if(!$count){
            $count = NULL;              
        }
        return $count; 
    }
    
    public function confirmationEmail($uId, $confirm){
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, verification FROM user WHERE id = ? AND verification = ?");
        $statement->bind_param('is', $uId, $confirm);
        $r = $statement->execute();
        $statement->fetch();
        if($r){
            return true;
        }else{
            echo $mysqli->error;
            exit();
        }
    }

    public function getStatusCode($email){
        global $mysqli;
        $statement = $mysqli->prepare("SELECT count(id) FROM user WHERE username = ? AND status = 1");
        $statement->bind_param('s', $email);
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();
        if (!$count) {
            $count = 0;
        }
        return $count;
    }

    
	public function login($uname, $sentPassword) {
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, username, password, createdAt, updatedAt FROM user WHERE username LIKE ? AND status = 1");
        if($statement) {
            $statement->bind_param('s', $uname);
            $statement->execute();
            $statement->bind_result($id, $username, $password, $createdAt, $updatedAt);
            
            if ($statement->fetch()) {
                $statement->close();
                if($password == md5($sentPassword)) {
                    $this->id = $id;
                    $this->username = $username;
                    $this->createdAt = $createdAt;
                    $this->updatedAt = $updatedAt;

                    // require_once './classes/allstore.php';
                    // $storeList = new AllStore();
                    // $this->stores = $storeList->getStoreListWithCategory($this->id);                  

                    // require_once './classes/category.php';
                    // $category = new Category();
                    // $this->categories = $category->getNullStoreCategory($this->id);  


                    // if ($deviceToken != "") {
                    //     $userDeviceToken = new UserDeviceToken();
                        
                    //     $userDeviceToken->userId = $id;
                    //     $userDeviceToken->deviceToken = $deviceToken;
                    //     $userDeviceToken->platform = $platform;
                    //     $userDeviceToken->deviceType = $deviceType;
                    //     $userDeviceToken->isDebug = $isDebug;
                    //     $userDeviceToken->createdAt = $timestamp;
                    //     $userDeviceToken->updatedAt = $timestamp;
                    //     $userDeviceToken->saveOrUpdate();
                    // }
                    return $this;
                }
                else {
                    return NULL;
                }
            }
            return NULL;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getForUsername($uname) {
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, username, password, createdAt, updatedAt FROM user WHERE isdeleted=0 AND username LIKE ?");
        if($statement) {
            $statement->bind_param('s', $uname);
            $statement->execute();
            $statement->bind_result($id, $username, $password, $createdAt, $updatedAt);
            if ($statement->fetch()) {                
                $o = new User();
                $o->id = $id;
                $o->username = $username;
                $o->password = $password;
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                return $o;
                $statement->close();
            }
            else {
                return NULL;
            }
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }	

    public function save() {        
        global $mysqli;
        require_once './classes/utility.php';
        $utility = new Utility();
        $verificationCode = $utility->generateRandomString(6);
        // $this->status = 1;
        $startTime = date('Y-m-d');
        // $date = strtotime('+30 day');
        // $trial_end = date('Y-m-d', $date);
        
        $statement = $mysqli->prepare("INSERT INTO user (username, email, password, createdAt, updatedAt, verification, status, trial_start) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $newPassword = md5($this->password);
        $this->password = "";

        $statement->bind_param('sssddsis', $this->username, $this->email, $newPassword, $this->createdAt, $this->updatedAt, $verificationCode, $this->status, $startTime);
        $r = $statement->execute();
        if($r) {
            $statement->close(); 
            $this->id = $mysqli->insert_id;

            require_once './classes/profile.php';
            $profile = new Profile();

            $profile->userId = $this->id;            
            $profile->createdAt = $this->createdAt;
            $profile->businessname = $this->companyname;
            
            /********************** Profile logo save ****************/
            
            if($this->logo != NULL) {
                $uploadDirectory = "uploads/profile/";
                $extension = pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION);
                $newFileName = ($this->companyname) ? "{$this->companyname}_{$this->createdAt}." . $extension : "l{$this->createdAt}.".$extension;    
               
                $target = $uploadDirectory;

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
                }
                else {
                    $responseArray = array('status' => 'fail', 'message' => $fileUploadResult);
                    echo json_encode($responseArray);
                    return;
                }
            }
    
            /****************end LOGO ******************************/

            $profile->id = $profile->save();
            // $existingUserLogo = $profile->getForUserId($this->id);

            require_once('./classes/store.php');            
            $store = new Store();

            $storeSave = $store->save($this->companyname, $this->createdAt, $this->updatedAt, $this->id, $this->email, $verificationCode, $this->username);   
            return $this->id;           
        }
        else{
            return $mysqli->error;
            exit();
        }
    }
    public function getUsername($email){
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, username FROM user WHERE email = ? AND isDeleted = 0");
        if($statement) {
            $statement->bind_param('s', $email);
            $statement->execute();
            $statement->bind_result($id, $username);
            if ($statement->fetch()) {                
                $o = new User();
                $o->id = $id;
                $o->username = $username;                
                return $o;
                $statement->close();
            }
            else {
                return NULL;
            }
        }
        else {
            return $mysqli->error;
            exit();
        }
    }

    public function resetPassword($id, $username, $email) {        
        
        $utility = new Utility();
        $subject = "Happy survey - Reset password";
        
        $html = " <html xmlns=\"http://www.w3.org/1999/xhtml\">
                    <head>  
                    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
                        <title>Survey rating</title>
                    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
                    </head>
                    <body style=\"margin: 0; padding: 0; background:#f6f4ef\">
                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-bottom: 1px solid #e6e6f2;\"> 
                        <tr>
                            <td style=\"padding: 10px 0 30px 0;\"> 
                                <table align=\"center\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"550\" style=\"border: 1px solid #e6e6f2; border-collapse: collapse;\" bgcolor=\"#fff\">
                                    <tr>
                                        <td style=\"padding: 40px 0 30px 0; color: #153643; font-size: 20px; font-family: Arial, sans-serif;\" align=\"center\">
                                           
                                            <img src=\"https://hpysrvy.com/admin/assets/images/surveylogo.png\" alt=\"Logo\" style=\"display: block;margin-bottom:20px;\" width=\"250\" height=\"70\"  />";                                                
        $html .=                            "<h4 align=\"left\" style=\"font-size: 20px; line-height: 20px; margin-left: 17%;\">Hi ".$username.",</h4>
                                            <table align=\"center\" cellpadding=\"10\" cellspacing=\"1\" width=\"400\" 
                                                style=\"font-size: 15px; border-collapse: collapse; margin-top:20px; margin-bottom:25px;\">                                     
                                                <tr>
                                                    <p align=\"left\" style=\"margin-left: 17%;font-size: 18px;\">We received a request to reset your password.</p>
                                                </tr>                                                   
                                            </table>";
        $html .=                            "<a href=\"http://"."$_SERVER[HTTP_HOST]"."/admin/resetpassword.html?u=".$id."\" style=\"padding: 10px 55px; background: rgb(251,177,2); font-size:14px; text-decoration:none;color: #fff;margin:\">Click here
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <tr><td align=\"center\" style=\"padding: 10px 0 30px 0\">© ".date('Y')."-HappySurvey. All rights reserved.</td></tr>
                        </tr>
                    </table>
                </body>
                </html>"; 
            return $utility->sendEmain($email, $subject, $html, "noreply@kmsof.com");
            
    }

    public function getCount($uId)
    {
        global $mysqli;
        global $BASE_URL;
        $statement = $mysqli->prepare("SELECT COUNT(id) FROM user WHERE id=? AND isdeleted=0");
        $statement->bind_param('i', $uId);
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();
        if (!$count) {
            $count = 0;
        }
        return $count;
    }
    
    public function getAllUserId() {
        global $mysqli;
        // require_once './config.php';
        global $BASE_URL;
        $statement = $mysqli->prepare("SELECT user.id, user.username, COALESCE(storeid,0) as storeid, COALESCE(surveyid,0) as surveyid, COALESCE(sid,0) as sid, COALESCE(qrsticker,0) as qrsticker, COALESCE(userinfo,0) as userinfo 
                                            FROM user
                                            LEFT JOIN (SELECT userId,COUNT(*) as storeid, id as sid, stickerpdf as qrsticker , infopdf as userinfo 
                                                FROM store   GROUP BY userId ) store 
                                                    ON store.userId = user.id
                                            LEFT JOIN (SELECT userId, COUNT(*) as surveyid 
                                                FROM survey GROUP BY userId) survey 
                                                    ON survey.userId = user.id
                                                        AND user.isDeleted = 0 GROUP by user.id ORDER BY id DESC");
          // $statement->bind_param('i', $uId);
          $statement->execute();
          $statement->bind_result($userId, $username, $storeIdCount, $surveyId, $storeId, $qrsticker, $infopdf);
          $array = array();
          while($statement->fetch()){
          $o = array();
          $o["userId"] = $userId;
          $o["username"] = $username;
          $o["storeIdCount"] = $storeIdCount;
          $o["surveyId"] = $surveyId;
          $o["storeId"] = $storeId;
          $o["qrsticker"] = ($qrsticker) ? $BASE_URL.$qrsticker : "";
          $o["infopdf"] = ($infopdf) ? $BASE_URL.$infopdf : "";
          $array[] = $o;
          }
          $statement->close();
          return $array;          
    }
    public function getCustomerTrialStartTime($userId){
        global $mysqli;
        $statement = $mysqli->prepare("SELECT trial_start FROM user WHERE id = ?");
        $statement->bind_param('i', $userId);       
        $statement->execute();
        $statement->bind_result($startTime);
        $statement->fetch();
        if(!$startTime){
            $startTime = 0;
        }
        return $startTime;  
    }
}

?>
