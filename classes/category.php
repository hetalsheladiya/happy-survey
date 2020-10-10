<?php
class Category {
    public $id = 0;
    public $name = "";
    public $userId = 0;
    // public $image = 0;
    // public $imagePath = 0;
    public $createdAt = 0;
    public $updatedAt = 0;
    
    public function getSurveyCategory($userId, $storeId){
        global $mysqli;
        if($storeId){
            $statement = $mysqli->prepare("SELECT c.id, c.name AS categoryName FROM survey s, `surveyCategory` sc, category c 
                                            WHERE s.userId = ? AND s.storeId = ? AND s.id = sc.surveyId AND sc.categoryId = c.id AND c.isdeleted = 0
                                                GROUP BY sc.categoryId ORDER BY c.id ASC");
            $statement->bind_param('ii', $userId, $storeId);
        }
        else{
            $statement = $mysqli->prepare("SELECT c.id, c.name AS categoryName FROM survey s, `surveyCategory` sc, category c 
                                            WHERE s.userId = ? AND s.id = sc.surveyId AND sc.categoryId = c.id AND c.isdeleted = 0
                                                GROUP BY sc.categoryId ORDER BY c.id ASC");
            $statement->bind_param('i', $userId);
        }
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $name);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new Category();  
                $o->id = $id;             
                $o->name = $name;                
                $array[] = $o;
            }
            $statement->close();
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
        
    }

    public function getAll($uId, $lastId = "", $limit = 20, $storeId) {
        global $mysqli;
        global $BASE_URL;
        if ($lastId == NULL || $lastId == "") {
            if($storeId == NULL){
                $statement = $mysqli->prepare("SELECT id, name, userId, createdAt, updatedAt, storeId, isdeleted FROM category 
                                                 WHERE userId=? AND isdeleted = 0 ORDER BY id DESC LIMIT ?");
                $statement->bind_param('ii', $uId, $limit);
            }
            else{
                $statement = $mysqli->prepare("SELECT id, name, userId, createdAt, updatedAt, storeId, isdeleted FROM category 
                                                 WHERE userId=? AND storeId = ? AND isdeleted = 0 ORDER BY id DESC LIMIT ?");
                $statement->bind_param('iii', $uId, $storeId, $limit);
            }
            
        }
        else {
            if($storeId == NULL){
                $statement = $mysqli->prepare("SELECT id, name, userId, createdAt, updatedAt, storeId, isdeleted FROM category 
                                                WHERE userId=? AND isdeleted = 0 AND id < ? ORDER BY id DESC LIMIT ?");
                $statement->bind_param('iii', $uId, $lastId, $limit);
            }
            else{
                $statement = $mysqli->prepare("SELECT id, name, userId, createdAt, updatedAt, storeId, isdeleted FROM category 
                                                WHERE userId=? AND storeId = ? AND isdeleted = 0 AND id < ? ORDER BY id DESC LIMIT ?");
                $statement->bind_param('iiii', $uId, $storeId, $lastId, $limit);
            }
            
        }
        
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $name, $userId, $createdAt, $updatedAt, $storeId, $isdeleted);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new Category();
                $o->id = $id;
                $o->name = $name;
                $o->userId = $userId;       
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                $o->isdeleted = $isdeleted;
                //$o->storeName = $storeName;
                $array[] = $o;
            }
            $statement->close();
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }
    public function getAllCategoryWithNullStore($uId){
        global $mysqli;
        global $BASE_URL;
        $statement = $mysqli->prepare("SELECT id, name, userId, image, createdAt, updatedAt, storeId FROM category  WHERE userId=? AND isdeleted=0 AND storeId IS NULL ORDER BY id DESC");
        $statement->bind_param('i', $uId);
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $name, $userId, $image, $createdAt, $updatedAt, $storeId);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new Category();
                $o->id = $id;
                $o->name = $name;
                $o->userId = $userId;
                $o->image = $image;
                $o->imagePath = $BASE_URL . $image;
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                //$o->storeName = $storeName;
                $array[] = $o;
            }
            $statement->close();
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getSingleCategory($uId, $id) {
        global $mysqli;
        global $BASE_URL;       
            $statement = $mysqli->prepare("SELECT id, name, userId, image, createdAt, updatedAt, storeId FROM Category WHERE userId=? AND id LIKE ? AND isdeleted=0");
            $statement->bind_param('ii', $uId, $id);      
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $name, $userId, $image, $createdAt, $updatedAt, $storeId);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new Category();
                $o->id = $id;
                $o->name = $name;
                $o->userId = $userId;
                $o->image = $image;
                $o->imagePath = $BASE_URL . $image;
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                //$o->storeName = $storeName;
                $array[] = $o;
            }
            $statement->close();
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }     

    public function getAllCategory($uId, $lastId = "", $limit = 20) {
        global $mysqli;
        global $BASE_URL;
        if ($lastId == NULL || $lastId == "") {
            $statement = $mysqli->prepare("SELECT id, name, userId, image, createdAt, updatedAt, storeId FROM category WHERE userId=? AND isdeleted=0 ORDER BY id DESC LIMIT ?");
            $statement->bind_param('ii', $uId, $limit);
        }
        else {
            $statement = $mysqli->prepare("SELECT id, name, userId, image, createdAt, updatedAt, storeId FROM category WHERE userId=? AND id < ? ORDER BY id DESC LIMIT ?");
            $statement->bind_param('iii', $uId, $lastId, $limit);
        }
        
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $name, $userId, $image, $createdAt, $updatedAt, $storeId);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new Category();
                $o->id = $id;
                $o->name = $name;
                $o->userId = $userId;
                $o->image = $image;
                $o->imagePath = $BASE_URL . $image;
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                $array[] = $o;
            }
            $statement->close();
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getAllStoreCategory($uId, $lastId = "", $limit = 20) {
        global $mysqli;
        global $BASE_URL;
        if ($lastId == NULL || $lastId == "") {
            $statement = $mysqli->prepare("SELECT id, name, userId, image, createdAt, updatedAt, storeId FROM category WHERE userId=? AND isdeleted=0 ORDER BY id DESC LIMIT ?");
            $statement->bind_param('ii', $uId, $limit);
        }
        else {
            $statement = $mysqli->prepare("SELECT id, name, userId, image, createdAt, updatedAt, storeId FROM category WHERE userId=? AND id < ? ORDER BY id DESC LIMIT ?");
            $statement->bind_param('iii', $uId, $lastId, $limit);
        }
        
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $name, $userId, $image, $createdAt, $updatedAt, $storeId);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new Category();
                $o->id = $id;
                $o->name = $name;
                $o->userId = $userId;
                $o->image = $image;
                $o->imagePath = $BASE_URL . $image;
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                $array[] = $o;
            }
            $statement->close();
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }
    public function getNullStoreCategory($uId, $lastId = "",$limit = 20){
        global $mysqli;
        global $BASE_URL;
        if ($lastId == NULL || $lastId == "") {
            $statement = $mysqli->prepare("SELECT id, name, userId, image, createdAt, updatedAt, storeId, isdeleted FROM category WHERE userId=? AND storeId IS NULL ORDER BY id DESC LIMIT ?");
            $statement->bind_param('ii', $uId, $limit);
        }
        else {
            $statement = $mysqli->prepare("SELECT id, name, userId, image, createdAt, updatedAt, storeId, isdeleted FROM category WHERE userId=? AND id < ? AND storeId IS NULL  ORDER BY id DESC LIMIT ?");
            $statement->bind_param('iii', $uId, $lastId, $limit);
        }
        
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $name, $userId, $image, $createdAt, $updatedAt, $storeId, $isdeleted);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new Category();
                $o->id = $id;
                $o->name = $name;
                $o->userId = $userId;
                $o->image = $image;
                $o->imagePath = $BASE_URL . $image;
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                $o->isdeleted = $isdeleted;
                $array[] = $o;
            }
            $statement->close();
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getForId($cId, $uId) {
        global $mysqli;
        global $BASE_URL;
        $statement = $mysqli->prepare("SELECT id, name, userId, createdAt, updatedAt, storeId FROM category WHERE userId=? AND id LIKE ?");
        if($statement) {
            $statement->bind_param('ii', $uId, $cId);
            $statement->execute();
            $statement->bind_result($id, $name, $userId, $createdAt, $updatedAt, $storeId);
            $array = array(); 
            if ($statement->fetch()) {
                $o = new Category();
                $o->id = $id;
                $o->name = $name;
                $o->userId = $userId;       
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
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
    public function getCountAll($uId) {
        global $mysqli;
        $statement = $mysqli->prepare("SELECT COUNT(id) FROM category WHERE userId=? AND isdeleted=0");
        $statement->bind_param('i', $uId);
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();
        $statement->close();
        if (!$count) {
            $count = 0;
        }
        return $count;
    }

    public function getCount($uId) {
        global $mysqli;
        $statement = $mysqli->prepare("SELECT COUNT(id) FROM category WHERE userId=? AND storeId IS NULL AND isdeleted=0");
        $statement->bind_param('i', $uId);
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();
        $statement->close();
        if (!$count) {
            $count = 0;
        }
        return $count;
    }
    public function getCountCategoryWithStore($uId,$storeId) {
        global $mysqli;
        $statement = $mysqli->prepare("SELECT COUNT(c.id), c.userId, s.userId, s.id, c.storeId FROM category AS c,store AS s WHERE c.userId = s.userId AND c.userId = ? AND c.storeId = s.id AND c.storeId = ? AND c.isdeleted = 0");
        $statement->bind_param('ii', $uId, $storeId);
        $statement->execute();
        $statement->bind_result($count, $userId, $userId, $storeId, $storeId);
        $statement->fetch();
        $statement->close();
        if (!$count) {
            $count = 0;
        }
        return $count;
    }

    public function deleteAll($uId)
    {
        global $mysqli;
        $statement = $mysqli->prepare("DELETE FROM category WHERE userId=?");
        $statement->bind_param('i', $uId);
        $r = $statement->execute();
        return $r;
    }
    
    public function delete($id, $uId)
    {
        global $mysqli;
        if($this->getCountAll($uId) > 4)
        {
            $statement = $mysqli->prepare("UPDATE category SET isdeleted=1 WHERE userId=? AND id LIKE ?");
            $statement->bind_param('ii', $uId, $id);
            $r = $statement->execute();
            $statement->close();
            return $r;
        } 
        else {
            return "Minimum required 4 categories.";
        }       
        
    }
    public function deleteWithStore($id, $uId, $storeId)
    {
        global $mysqli;
        if($this->getCountCategoryWithStore($uId,$storeId) > 4)
        {
            $statement = $mysqli->prepare("UPDATE category SET isdeleted=1 WHERE userId=? AND storeId=? AND id LIKE ?");
            $statement->bind_param('iii', $uId, $storeId, $id);
            $r = $statement->execute();
            $statement->close();
            return $r;
        } 
        else {
            return "Minimum required 4 categories.";
        }       
    }

    public function save() {
        global $mysqli;          
        $statement = $mysqli->prepare("INSERT INTO category (name, userId, createdAt, updatedAt) VALUES (?, ?, ?, ?)");
        $statement->bind_param('sidd', $this->name, $this->userId, $this->createdAt, $this->updatedAt);            
        $statement->execute();
        $statement->close();
        if($statement){
            return $mysqli->insert_id;
        }
        else {  
            echo $mysqli->error;
            exit();          
        }       
    }
    public function checkCategoryName($storeId, $userId, $name) {
        global $mysqli;       
        $statement = $mysqli->prepare("SELECT COUNT(c.name) FROM category AS c,store AS s WHERE c.storeId = s.id  AND c.userId = s.userId AND s.id = ? AND s.userId = ? AND c.name LIKE ? AND c.isdeleted != 1");
        $statement->bind_param('iis', $storeId, $userId, $name);
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();        
        if(!$count)
        {
            $count = 0;
        }
        return $count;
    }

    public function checkCategoryNameWithId($storeId, $userId, $name, $id) {
        global $mysqli;       
        $statement = $mysqli->prepare("SELECT COUNT(c.name) FROM category AS c,store AS s WHERE c.storeId=s.id  AND c.userId=s.userId AND s.id = ? AND s.userId = ? AND c.name LIKE ? AND c.id <> ? AND c.isdeleted != 1");
        $statement->bind_param('iisi', $storeId, $userId, $name, $id);
        $statement->execute();
        $statement->bind_result($count);
        $statement->fetch();        
        if(!$count)
        {
            $count = 0;
        }
        return $count;
    }

    public function saveWithStore() {
        global $mysqli;        
        $statement = $mysqli->prepare("INSERT INTO category (name, userId, createdAt, updatedAt, storeId) VALUES (?, ?, ?, ?, ?)");
        $statement->bind_param('siddi', $this->name, $this->userId, $this->createdAt, $this->updatedAt, $this->storeId);                
        $statement->execute();
        $statement->close();
        if($statement)
            return $mysqli->insert_id;
        else {                
            return $mysqli->error;
            exit();
        }       
    }
    
    public function update() {
        global $mysqli;
        global $BASE_URL;
        $statement = $mysqli->prepare("UPDATE category SET name = ?, userId = ?, updatedAt = ? WHERE id = ?");
        $statement->bind_param('sidi', $this->name, $this->userId, $this->updatedAt, $this->id);        
        $r = $statement->execute();
        $statement->close();
        if($r)
            return TRUE;
        else
            return FALSE;
    }

    public function __update() {
        global $mysqli;
        global $BASE_URL;
        $statement = $mysqli->prepare("UPDATE category SET name = ?, userId = ?, updatedAt = ?, storeId = ? WHERE id = ?");
        $statement->bind_param('sidii', $this->name, $this->userId, $this->updatedAt, $this->storeId, $this->id);        
        $r = $statement->execute();
        $statement->close();
        if($r)
            return TRUE;
        else
            return FALSE;
    }

    public function updateWithStore() {
        global $mysqli;
        global $BASE_URL;
        $statement = $mysqli->prepare("UPDATE category SET name = ?, userId = ?, image = ?, updatedAt = ? WHERE id = ? AND storeId = ?");
        $statement->bind_param('sisdii', $this->name, $this->userId, $this->image, $this->updatedAt, $this->id, $this->storeId);
        $this->imagePath = $BASE_URL . $this->image;
        $r = $statement->execute();
        if($r)
            return TRUE;
        else
            return FALSE;
    }    

    public function getCategoryForIds($ids) {
        global $mysqli;
        global $BASE_URL;
        $commaSepratedIds = implode($ids, ",");
        if (count($ids) > 0) {
            $statement = $mysqli->prepare("SELECT id, name, userId, createdAt, updatedAt FROM category WHERE id IN ({$commaSepratedIds})");
            if($statement) {
                $statement->execute();
                $statement->bind_result($id, $name, $userId, $createdAt, $updatedAt);
                $array = array(); 
                while ($statement->fetch()) {
                    $o = new Category();
                    $o->id = $id;
                    $o->name = $name;
                    $o->userId = $userId;             
                    $o->createdAt = $createdAt;
                    $o->updatedAt = $updatedAt;
                    $array[] = $o;
                }
                $statement->close();
                return $array;
            }
            else {
                echo $mysqli->error;
                exit();
            }
        }
        else {
            return array();
        }
    }

    public function getAllWithStoreNamePage($uId, $start_from, $record_per_page) {
        global $mysqli;
        global $BASE_URL;
        if (@$page == NULL || @$page == "") {
            $statement = $mysqli->prepare("SELECT c.id, c.name, c.userId, c.image, c.createdAt, c.updatedAt, c.storeId, s.name FROM category AS c, store AS s WHERE c.userId=? AND s.userId=c.userId AND s.id=c.storeId AND c.isdeleted=0 ORDER BY c.id DESC LIMIT ?,?");
            $statement->bind_param('iii', $uId, $start_from, $record_per_page);
        }
        else {
            $statement = $mysqli->prepare("SELECT c.id, c.name, c.userId, c.image, c.createdAt, c.updatedAt, c.storeId, s.name FROM category AS c, store AS s WHERE c.userId=? AND s.userId=c.userId AND s.id=c.storeId AND c.isdeleted=0 ORDER BY c.id DESC LIMIT ?,?");
            $statement->bind_param('iii', $uId, $start_from, $record_per_page);
        }
        
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $name, $userId, $image, $createdAt, $updatedAt, $storeId, $storeName);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new Category();
                $o->id = $id;
                $o->name = $name;
                $o->userId = $userId;
                $o->image = $image;
                $o->imagePath = $BASE_URL . $image;
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                $o->storeName = $storeName;
                $array[] = $o;
            }
            $statement->close();
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }   

    public function getAllCategoryWithPage($uId, $start_from, $limit) {
        global $mysqli;
        global $BASE_URL;        
            $statement = $mysqli->prepare("SELECT c.*, s.name FROM category AS c LEFT JOIN store AS s ON c.storeId=s.id WHERE c.userId=? AND c.isdeleted=0 ORDER BY c.id DESC LIMIT ?,?");
            $statement->bind_param('iii', $uId, $start_from, $limit);     
        
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $name, $userId, $createdAt, $updatedAt, $storeId, $storeId, $storeName);
            $array = array(); 
            while ($statement->fetch()) {
                $o = new Category();
                $o->id = $id;
                $o->name = $name;
                $o->userId = $userId;
                // $o->image = $image;
                // $o->imagePath = $BASE_URL . $image;
                $o->createdAt = $createdAt;
                $o->updatedAt = $updatedAt;
                $o->storeId = $storeId;
                $o->storeName = $storeName;
                $array[] = $o;
            }
            $statement->close();
            return $array;
        }
        else {
            echo $mysqli->error;
            exit;
        }
    }

    public function getCategoryWithStore($userId, $storeId){
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, name, storeId FROM category WHERE storeId = ? AND userId = ? AND isdeleted=0");
        $statement->bind_param('ii', $storeId, $userId);
        if($statement) {
            $statement->execute();
            $statement->bind_result($id, $name, $sId);
            $array = array();
            while ($statement->fetch()) {
                $o = new Category();
                $o->id = $id;
                $o->name = $name;
                $o->storeId = $sId;
                $array[] = $o;
            }
            $statement->close();
            return $array;
        }
        else{
            echo $mysqli->error;
            exit;
        }
    }
      public function saveCategory(){
          global $mysqli;
          $statement = $mysqli->prepare("INSERT INTO category (name, userId, createdAt, updatedAt, storeId) VALUES (?, ?, ?, ?, ?)");
          $statement->bind_param('siddi', $this->name, $this->userId, $this->createdAt, $this->updatedAt, $this->storeId);
          $statement->execute();
          $statement->close();
          if($statement){
          return $mysqli->insert_id;
          }
          else {
          echo $mysqli->error;
          exit();
          }
      }
}
?>
