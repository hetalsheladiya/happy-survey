<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of message_details
 *
 * @author BK
 */

class Survey {
    public $id = 0;
    public $isHappy = true;
    public $email = "";
    public $comment = "";
    public $userId = 0;
    public $createdAt = 0;
    public $updatedAt = 0;
    public $rating = 0 ;
    public $storeId = NULL;
    public $timestamp = 0;

    public function getAllWithLimit($uId, $lastId = "", $limit = 20, $storeId, $createdAt) {
        global $mysqli;
        global $BASE_URL;
        if ($lastId == NULL || $lastId == "") {
            if($createdAt == NULL || $createdAt == ""){
                if($storeId != '') {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment,email,name,phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND storeId= ? ORDER BY id DESC LIMIT ?");
                   // echo "SELECT id, isHappy, email, category, comment, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId={$uId} AND storeId={$storeId} ORDER BY id DESC LIMIT {$limit}";
                    $statement->bind_param('iii', $uId, $storeId, $limit);
                }
                else {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? ORDER BY id DESC LIMIT ?");
                    $statement->bind_param('ii', $uId, $limit);
                }
            } else {
                if($storeId != '') {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt < ? AND storeId=? ORDER BY createdAt DESC LIMIT ?");
                    $statement->bind_param('idii', $uId, $createdAt, $storeId, $limit);
                }
                else {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt < ? ORDER BY createdAt DESC LIMIT ?");
                    $statement->bind_param('idi', $uId, $createdAt, $limit);
                }
            }                
        }
        else {
            if($createdAt == NULL || $createdAt == ""){
                if($storeId != '') {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND storeId=? ORDER BY id DESC LIMIT ?, ?");
                    $statement->bind_param('iiii', $uId, $storeId, $lastId, $limit);
                }
                else {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? ORDER BY id DESC LIMIT ?, ?");
                    $statement->bind_param('iii', $uId, $lastId, $limit);
                }
            }
            else {
                if ($storeId != '') {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt < ? AND storeId=? ORDER BY createdAt DESC LIMIT ?, ?");
                    $statement->bind_param('idiii', $uId, $createdAt, $storeId, $lastId, $limit);
                }
                else {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt < ? ORDER BY createdAt DESC LIMIT ?, ?");
                    $statement->bind_param('idii', $uId, $createdAt, $lastId, $limit);
                }                
            }
        }        
        
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $isHappy, $comment, $email, $name, $phonenumber, $userId, $createdAt, $updatedAt, $storeId);
            $array = array(); 
            $surveyIds = array();
            
            while ($statement->fetch()) {
                $o = new survey();
                $o->id = $id;
                $o->isHappy = $isHappy;               
                $o->comment = $comment;
                $o->email = $email;
                $o->name = $name;
                $o->mobile = $phonenumber;
                $o->userId = $userId;             
                $o->createdAt = $createdAt;
                $surveyIds[] = $id;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                $array[] = $o;
            }

            $statement->close();
            if (count($surveyIds) > 0) {
                require_once './classes/surveycategory.php';
                $obj = new surveyCategory();
                $surveyCategories = $obj->getsurveyCategoryForsurveyIds($surveyIds);               
                $i = 0;                
                foreach ($array as $survey) {
                    $result = array();
                    $categoryNameArray = array();
                    foreach ($surveyCategories as $surveyCategory) {
                        if ($surveyCategory->surveyId == $survey->id) {
                            $result[] = $surveyCategory;
                            $categoryNameArray[$surveyCategory->name] = $surveyCategory->rating;
                        }
                    }
                    $survey->categories = $result;
                    $survey->categoriesRating = $categoryNameArray;
                    $array[$i] = $survey;
                    $i++;
                }
            }
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getAllWithLimitAndTillTime($uId, $timestamp, $lastId = "", $limit = 20, $storeId, $createdAt) {
        global $mysqli;
        if ($lastId == NULL || $lastId == "") {
           if($createdAt == "" || $createdAt == NULL)
           {
                if($storeId != ""){
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND storeId=? AND userId=? AND createdAt > ? ORDER BY id DESC LIMIT ?");
                    $statement->bind_param('iidi', $storeId, $uId, $timestamp, $limit);
                }
                else{
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt > ?  ORDER BY id DESC LIMIT ?");
                    $statement->bind_param('idi', $uId, $timestamp, $limit);
                }  
           }
           else {
                if($storeId != "") {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt > ? AND createdAt < ? AND storeId=?  ORDER BY id DESC LIMIT ?");
                    $statement->bind_param('iddii', $uId, $timestamp,  $createdAt, $storeId, $limit);
                }
                else {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt > ? AND createdAt < ?  ORDER BY id DESC LIMIT ?");
                    $statement->bind_param('iddi', $uId, $timestamp,  $createdAt, $limit);
                }                
           }                   
        }
        else {
            if($createdAt == NULL || $createdAt == "")
            {
                if($storeId != "") {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt,storeId FROM survey WHERE isdeleted=0 AND storeId=? AND userId=? AND createdAt > ? ORDER BY id DESC LIMIT ?, ?"); 
                    $statement->bind_param('iidii', $storeId, $uId, $timestamp, $lastId, $limit);
                }
                else {
                   $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt > ? ORDER BY id DESC LIMIT ?, ?"); 
                   $statement->bind_param('idii', $uId, $timestamp, $lastId, $limit);                     
                }
            }
            else {
                if($storeId != "") {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt > ? AND storeId = ? ORDER BY id DESC LIMIT ?, ?"); 
                    $statement->bind_param('idiii', $uId, $createdAt, $storeId, $lastId, $limit);
                }
                else {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt > ? ORDER BY id DESC LIMIT ?, ?"); 
                    $statement->bind_param('idii', $uId, $createdAt, $lastId, $limit);
                }
            }
        }
        
        if($statement) {            
            $statement->execute();
            $statement->bind_result($id, $isHappy, $comment, $email, $name, $phonenumber, $userId, $createdAt, $updatedAt, $storeId);         

            $array = array(); 
            $surveyIds = array();

            while ($statement->fetch()) {
                $o = new survey();
                $o->id = $id;
                $o->isHappy = $isHappy;                
                $o->comment = $comment;
                $o->email = $email;
                $o->name = $name;
                $o->mobile = $phonenumber;
                $o->userId = $userId;             
                $o->createdAt = $createdAt;
                $surveyIds[] = $id;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                $array[] = $o;
            }
            $statement->close();
            if (count($surveyIds) > 0) {
                require_once './classes/surveycategory.php';
                $obj = new surveyCategory();
                $surveyCategories = $obj->getsurveyCategoryForsurveyIds($surveyIds);

                $i = 0;
                foreach ($array as $survey) {
                    $result = array();
                    $categoryNameArray = array();
                    foreach ($surveyCategories as $surveyCategory) {
                        if ($surveyCategory->surveyId == $survey->id) {
                            $result[] = $surveyCategory;
                            $categoryNameArray[$surveyCategory->name] = $surveyCategory->rating;
                        }
                    }
                    $survey->categories = $result;
                    $survey->categoriesRating = $categoryNameArray;
                    $array[$i] = $survey;
                    $i++;
                }
            }            
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    ////////////////////
    public function getAll($uId) {
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt FROM survey WHERE isdeleted=0 AND userId=? ORDER BY id DESC");
        if($statement) {
            $statement->bind_param('i', $uId);
            $statement->execute();
            $statement->bind_result($id, $isHappy, $comment, $userId, $createdAt, $updatedAt);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new survey();
                $o->id = $id;
                $o->isHappy = $isHappy;                
                $o->comment = $comment;
                $o->userId = $userId;
                $o->createdAt = $createdAt;                
                $o->updatedAt = $updatedAt;
                $array[] = $o;
            }
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }
    
    public function getSurveyCategoryResultCountWithStore($isHappy, $categoryId, $uId, $storeId) {
        global $mysqli;
     
        $statement= $mysqli->prepare("SELECT count(sc.id) FROM survey AS s, surveyCategory AS sc WHERE s.id=sc.surveyId ANd s.isdeleted=0 AND s.userId=? AND sc.categoryId=? AND s.isHappy=? AND s.storeId = ? AND sc.rating != 0");
        if($statement) {
            $statement->bind_param('iiii', $uId, $categoryId, $isHappy, $storeId);
            $statement->execute();
            $statement->bind_result($count);
            if ($statement->fetch()) {
                return $count;
            }
            return 0;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getSurveyCategoryResultCount($isHappy, $categoryId, $uId) {
        global $mysqli;
     
        $statement= $mysqli->prepare("SELECT count(sc.id) FROM survey AS s, surveyCategory AS sc WHERE s.id=sc.surveyId ANd s.isdeleted=0 AND s.userId=? AND sc.categoryId=? AND s.isHappy=? ");
        if($statement) {
            $statement->bind_param('iii', $uId, $categoryId, $isHappy);
            $statement->execute();
            $statement->bind_result($count);
            if ($statement->fetch()) {
                return $count;
            }
            return 0;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getAllSurveyResultCountWithStore($isHappy, $uId, $storeId) {
        global $mysqli;
        $statement= $mysqli->prepare("SELECT count(id) FROM survey WHERE isdeleted=0 AND userId=? AND isHappy=? AND storeId = ?");
        if($statement) {
            $statement->bind_param('iii', $uId, $isHappy, $storeId);
            $statement->execute();
            $statement->bind_result($count);
            if ($statement->fetch()) {
                return $count;
            }
            return 0;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getAllSurveyResultCount($isHappy, $uId) {
        global $mysqli;
        $statement= $mysqli->prepare("SELECT count(id) FROM survey WHERE isdeleted=0 AND userId=? AND isHappy=?");
        if($statement) {
            $statement->bind_param('ii', $uId, $isHappy);
            $statement->execute();
            $statement->bind_result($count);
            if ($statement->fetch()) {
                return $count;
            }
            return 0;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getAllLastDay($uId) {
        $d = date('Y/m/d h:i:s', strtotime('-1 day', strtotime(date("Y/m/d h:i:s"))));
        $dtime = DateTime::createFromFormat('Y/m/d h:i:s', $d)->getTimestamp() * 1000;
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt FROM survey WHERE isdeleted=0 AND userId=? AND createdAt > {$dtime} ORDER BY id DESC");
        if($statement) {
            $statement->bind_param('i', $uId);
            $statement->execute();
            $statement->bind_result($id, $isHappy, $comment, $userId, $createdAt, $updatedAt);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new survey();
                $o->id = $id;
                $o->isHappy = $isHappy;                
                $o->comment = $comment;
                $o->userId = $userId;
                $o->createdAt = $createdAt;                
                $o->updatedAt = $updatedAt;
                $array[] = $o;
            }
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getAllLastWeek($uId) {
        $d = date('Y/m/d h:i:s', strtotime('-1 week', strtotime(date("Y/m/d h:i:s"))));
        $dtime = DateTime::createFromFormat('Y/m/d h:i:s', $d)->getTimestamp() * 1000;
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt FROM survey WHERE isdeleted=0 AND userId=? AND createdAt > {$dtime} ORDER BY id DESC");
        if($statement) {
            $statement->bind_param('i', $uId);
            $statement->execute();
            $statement->bind_result($id, $isHappy, $comment, $userId, $createdAt, $updatedAt);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new survey();
                $o->id = $id;
                $o->isHappy = $isHappy;                
                $o->comment = $comment;
                $o->userId = $userId;
                $o->createdAt = $createdAt;                
                $o->updatedAt = $updatedAt;
                $array[] = $o;
            }
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getAllLastMonth($uId) {
        $d = date('Y/m/d h:i:s', strtotime('-1 month', strtotime(date("Y/m/d h:i:s"))));
        $dtime = DateTime::createFromFormat('Y/m/d h:i:s', $d)->getTimestamp() * 1000;
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt FROM survey WHERE isdeleted=0 AND userId=? AND createdAt > {$dtime} ORDER BY id DESC");
        if($statement) {
            $statement->bind_param('i', $uId);
            $statement->execute();
            $statement->bind_result($id, $isHappy, $comment, $userId, $createdAt, $updatedAt);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new survey();
                $o->id = $id;
                $o->isHappy = $isHappy;                
                $o->comment = $comment;
                $o->userId = $userId;
                $o->createdAt = $createdAt;                
                $o->updatedAt = $updatedAt;
                $array[] = $o;
            }
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getAllLastYear($uId) {
        $d = date('Y/m/d h:i:s', strtotime('-1 year', strtotime(date("Y/m/d h:i:s"))));
        $dtime = DateTime::createFromFormat('Y/m/d h:i:s', $d)->getTimestamp() * 1000;
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId createdAt, updatedAt FROM survey WHERE isdeleted=0 AND userId=? AND createdAt > {$dtime} ORDER BY id DESC");
        if($statement) {
            $statement->bind_param('i', $uId);
            $statement->execute();
            $statement->bind_result($id, $isHappy, $comment, $userId, $createdAt, $updatedAt);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new survey();
                $o->id = $id;
                $o->isHappy = $isHappy;                
                $o->comment = $comment;
                $o->userId = $userId;
                $o->createdAt = $createdAt;                
                $o->updatedAt = $updatedAt;
                $array[] = $o;
            }
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getForId($id, $uId) {
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, isHappy, email, category, comment, userId, createdAt, updatedAt FROM survey WHERE userId=? AND id LIKE ?");
        if($statement) {
            $statement->bind_param('ii', $uId, $id);
            $statement->execute();
            $statement->bind_result($id, $isHappy, $email, $category, $comment, $userId, $createdAt, $updatedAt);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new survey();
                $o->id = $id;
                $o->isHappy = $isHappy;
                $o->email = $email;
                $o->category = $category;
                $o->comment = $comment;
                $o->userId = $userId;
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $array[] = $o;
            }
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getSurveyCountWithTime($uId, $storeId, $timestamp) {
        global $mysqli;
        if($timestamp == ""){
            if($storeId == ""){
                $statement = $mysqli->prepare("SELECT COUNT(id) FROM survey WHERE userId = ?");
                $statement->bind_param('i', $uId);
            }
            else{
                $statement = $mysqli->prepare("SELECT COUNT(id) FROM survey WHERE userId = ? AND storeId = ?");
                $statement->bind_param('ii', $uId, $storeId);
            }
        }
        else{
            if($storeId == ""){
                $statement = $mysqli->prepare("SELECT COUNT(id) FROM survey WHERE userId = ? AND createdAt > ?");
                $statement->bind_param('id', $uId, $timestamp);
            }
            else{
                $statement = $mysqli->prepare("SELECT COUNT(id) FROM survey WHERE userId = ? AND storeId = ? AND createdAt > ?");
                $statement->bind_param('iid', $uId, $storeId, $timestamp);
            }
        }        
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();
        if (!$count) {
            $count = 0;
        }
        return $count;
    }

    public function getSurveyCount($uId, $storeId) {
        global $mysqli;
        if($storeId){
            $statement = $mysqli->prepare("SELECT COUNT(id) FROM survey WHERE userId = ? AND storeId = ?");
            $statement->bind_param('ii', $uId, $storeId);
        }
        else{
            $statement = $mysqli->prepare("SELECT COUNT(id) FROM survey WHERE userId = ?");
            $statement->bind_param('i', $uId);
        }        
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();
        if (!$count) {
            $count = 0;
        }
        return $count;
    }

    public function deleteAllsurvey($uId)
    {
        global $mysqli;
        $statement = $mysqli->prepare("DELETE FROM survey WHERE userId=?");
        $statement->bind_param('i', $uId);
        $r = $statement->execute();
        return $r;
    }
    
    public function deletesurvey($id, $uId)
    {
        global $mysqli;
        $statement = $mysqli->prepare("UPDATE survey SET isdeleted=1 WHERE userId=? AND id LIKE ?");
        $statement->bind_param('ii', $uId, $id);
        $r = $statement->execute();
        return $r;
    }

    public function surveyDeviceInfoSave($deviceType, $devicename, $deviceModal, $deviceOs, $createdAt, $updatedAt, $appVersion, $appBuild, $id){
        global $mysqli;
        $statement = $mysqli->prepare("INSERT INTO surveyDeviceInfo (deviceType, devicename, deviceModal, deviceOs, createdAt, updatedAt, appVersion, appBuild, surveyId)VALUES (?,?,?,?,?,?,?,?,?)");
        $statement->bind_param('ssssddssi', $deviceType, $devicename, $deviceModal, $deviceOs, $createdAt, $updatedAt, $appVersion, $appBuild, $id);
        $r = $statement->execute();
        if($r){
            return $mysqli->insert_id;
        }else{
            return FALSE;
        }
    }

    public function save($category, $storeId) {        
        global $mysqli;        
        $statement = $mysqli->prepare("INSERT INTO survey (isHappy, userId, createdAt, updatedAt, storeId) VALUES (?, ?, ?, ?, ?)");
        $statement->bind_param('iiddi', $this->isHappy, $this->userId, $this->createdAt, $this->updatedAt, $this->storeId);
        // echo $this->phonenumber;die;
        // if($statement){echo "hello";die;}
        $r = $statement->execute();
        $statement->close();
        if ($r) {
            $surveyId = $mysqli->insert_id;
            $this->id = $mysqli->insert_id;           

                // $survey = new Survey();

                // $survey = $survey->surveyDeviceInfoSave($this->deviceType, $this->devicename, $this->deviceModal, $this->deviceOs, $this->createdAt, $this->updatedAt, $this->appVersion, $this->appBuild, $this->id);
            
            if ($category != '') {
                require_once'./classes/surveycategory.php';
                $surveycategory = new surveyCategory();
                //$categoryIds = explode(",", $this->category);
                $this->categories = $surveycategory->insertsurveyCategories($surveyId, $category);                
            }       
            // if ($this->isHappy == 0) {
            //     require_once './classes/userdevicetoken.php';
            //     $userDeviceToken = new UserDeviceToken();
            //     $userDeviceToken->notification($this->userId, $this->comment, $deviceToken, $this);
            // }
            return $surveyId;
        }
        else {
            echo $mysqli->error;
            return FALSE;
        }
    }
    
    public function update() {
        global $mysqli;
        $statement = $mysqli->prepare("UPDATE survey SET isHappy=?, email=?, category=?, comment=?, userId=? updatedAt=? WHERE id=?");
        $statement->bind_param('isssidi', $this->isHappy, $this->email, $this->category, $this->comment, $this->userId, $this->updatedAt, $this->id);
        $r = $statement->execute();
        $statement->close();
        if($r) 
            return TRUE;
        else
            return FALSE;
    }

    public function getAllWithPage($uId, $start_from, $record_per_page, $storeId) {
        global $mysqli;
        global $BASE_URL;
        if (@$lastId == NULL || $lastId == "") {
            if(@$createdAt == NULL || $createdAt == ""){
                if($storeId == NULL) {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? ORDER BY id DESC LIMIT ?");
                    $statement->bind_param('ii', $uId, $limit);                    
                }
                else {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND storeId=? ORDER BY id DESC LIMIT ?,?");
                   // echo "SELECT id, isHappy, email, category, comment, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId={$uId} AND storeId={$storeId} ORDER BY id DESC LIMIT {$limit}";
                    $statement->bind_param('iiii', $uId, $storeId, $start_from, $record_per_page);
                }
            }else {
                $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt < ? ORDER BY createdAt DESC LIMIT ?");
                $statement->bind_param('idi', $uId, $createdAt, $limit);
            }
                
        }
        else {
            if($createdAt == NULL || $createdAt == ""){
                if($storeId != '') {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND storeId=? AND id < ? ORDER BY id DESC LIMIT ?,?");
                    $statement->bind_param('iiiii', $uId, $storeId, $lastId, $start_from, $record_per_page);
                }
                else {
                    $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND id < ? ORDER BY id DESC LIMIT ?");
                    $statement->bind_param('iii', $uId, $lastId, $limit);
                }
            }else {
                $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND userId=? AND createdAt < ? ORDER BY createdAt DESC LIMIT ?");
                $statement->bind_param('iidi', $uId, $lastId, $createdAt, $limit);
            }
        }        
        
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $isHappy, $comment, $userId, $createdAt, $updatedAt, $storeId);
            $array = array(); 
            $surveyIds = array();
            
            while ($statement->fetch()) {
                $o = new survey();
                $o->id = $id;
                $o->isHappy = $isHappy;                
                $o->comment = $comment;
                $o->userId = $userId;             
                $o->createdAt = $createdAt;
                $surveyIds[] = $id;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                $array[] = $o;
            }

            $statement->close();
            if (count($surveyIds) > 0) {
                require_once './classes/surveycategory.php';
                $obj = new surveyCategory();
                $surveyCategories = $obj->getsurveyCategoryForsurveyIds($surveyIds);

                $i = 0;
                foreach ($array as $survey) {
                    $result = array();
                    foreach ($surveyCategories as $surveyCategory) {
                        if ($surveyCategory->surveyId == $survey->id) {
                            $result[] = $surveyCategory;
                        }
                    }
                    $survey->categories = $result;
                    $array[$i] = $survey;
                    $i++;
                }
            }
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getAllWithLimitLastId($uId, $lastId = "", $limit = 50, $storeId) {
        global $mysqli;
        if ($lastId == NULL || $lastId == "") {

            if($storeId != ""){
                $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt, storeId, isdeleted FROM survey WHERE isdeleted=0 AND storeId=? AND userId=?  ORDER BY id ASC LIMIT ?");
                $statement->bind_param('iii', $storeId, $uId, $limit);
            }
            else{
                $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt, storeId, isdeleted FROM survey WHERE isdeleted=0 AND userId=?  ORDER BY id ASC LIMIT ?");
                $statement->bind_param('ii', $uId, $limit);
            }
           
        }
        else {            
            if($storeId != "") {
                $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt,storeId, isdeleted FROM survey WHERE isdeleted=0 AND storeId=? AND userId=? AND id > ? ORDER BY id ASC LIMIT ?"); 
                $statement->bind_param('iiii', $storeId, $uId, $lastId, $limit);
            }
            else {
               $statement = $mysqli->prepare("SELECT id, isHappy, comment, userId, createdAt, updatedAt, storeId, isdeleted FROM survey WHERE isdeleted=0 AND userId=? AND id > ? ORDER BY id ASC LIMIT ?"); 
               $statement->bind_param('iii', $uId, $lastId, $limit);                     
            }            
        }
        
        if($statement) {            
            $statement->execute();
            $statement->bind_result($id, $isHappy, $comment, $userId, $createdAt, $updatedAt, $storeId, $isdeleted);         

            $array = array(); 
            $surveyIds = array();

            while ($statement->fetch()) {
                $o = new survey();
                $o->id = $id;
                $o->isHappy = $isHappy;                
                $o->comment = $comment;
                $o->userId = $userId;             
                $o->createdAt = $createdAt;
                $surveyIds[] = $id;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                $o->isdeleted = $isdeleted; 
                $array[] = $o;
            }
            $statement->close();
            if (count($surveyIds) > 0) {
                require_once './classes/surveycategory.php';
                $obj = new surveyCategory();
                $surveyCategories = $obj->getsurveyCategoryForsurveyIds($surveyIds);

                $i = 0;
                foreach ($array as $survey) {
                    $result = array();
                    foreach ($surveyCategories as $surveyCategory) {
                        if ($surveyCategory->surveyId == $survey->id) {
                            $result[] = $surveyCategory;
                        }
                    }
                    $survey->categories = $result;
                    $array[$i] = $survey;
                    $i++;
                }
            }            
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }    
}
?>