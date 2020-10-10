<?php

/**
 * 
 */
class Profile
{	
    public $id = 0;
    public $firstname = "";
    public $lastname = "";
    public $businessname = "Happy survey";
    public $logo = "";
    public $logoPath = "";
    public $background = "";
    public $backgroundPath = "";
    public $userId = "";
    public $createdAt = 0;
    public $updatedAt = 0;

	public function getForUserId($uid) {
        global $mysqli;
        global $BASE_URL;
        $statement = $mysqli->prepare("SELECT p.id, p.firstname, p.lastname, p.businessname, p.logo, p.userId, p.createdAt, p.updatedAt, u.email FROM profile p, user u WHERE p.userId = u.id AND p.userId LIKE ?");
        if($statement) {
            $statement->bind_param('i', $uid);
            $statement->execute();
            $statement->bind_result($id, $firstname, $lastname, $businessname, $logo, $userId, $createdAt, $updatedAt, $email);
            $array = array(); 
            if ($statement->fetch()) {
                $this->id = $id;
                $this->firstname = $firstname;
                $this->lastname = $lastname;
                $this->businessname = ($businessname == "" || $businessname == NULL) ? "Happy survey" : $businessname;
                $this->logo = $logo;
                // $this->logoPath = $BASE_URL . (($logo == "" || $logo == NULL) ? "uploads/profile/surveyapplogo.jpg" : $logo);
                // $this->background = $background;
                // $this->backgroundPath = $BASE_URL . (($background == "" || $background == NULL) ? "uploads/profile/defaultbg.jpg" : $background);
                $this->userId = $userId;
                $this->email = $email;
                $this->createdAt = $createdAt;
                $this->updatedAt = $updatedAt;
                return $this;
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
        global $BASE_URL;
        $statement = $mysqli->prepare("INSERT INTO profile (firstname, lastname, businessname, logo, userId, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $statement->bind_param('ssssidd', $this->firstname, $this->lastname, $this->businessname, $this->logo, $this->userId, $this->createdAt, $this->updatedAt);
        // $this->logoPath = $BASE_URL . (($this->logo == "" || $this->logo == NULL) ? "uploads/profile/surveyapplogo.jpg" : $this->logo);
        // $this->backgroundPath = $BASE_URL . (($this->background == "" || $this->background == NULL) ? "uploads/profile/defaultbg.jpg" : $this->background);
        $r = $statement->execute();
        $statement->close();
        if($r)
            return $mysqli->insert_id;
        else
            return FALSE;
    }

    public function update() {
        global $mysqli;
        global $BASE_URL;
        $this->logoPath = $BASE_URL . (($this->logo == "" || $this->logo == NULL) ? "uploads/profile/surveyapplogo.jpg" : $this->logo);
        // $this->backgroundPath = $BASE_URL . (($this->background == "" || $this->background == NULL) ? "uploads/profile/defaultbg.jpg" : $this->background);
        $statement = $mysqli->prepare("UPDATE profile SET firstname=?, lastname=?, businessname=?, logo=?, userId=?, updatedAt=? WHERE id=?");
        $statement->bind_param('ssssidi', $this->firstname, $this->lastname, $this->businessname, $this->logo, $this->userId, $this->updatedAt, $this->id);
        $r = $statement->execute();
        $statement->close();
        if($r){                
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}


?>