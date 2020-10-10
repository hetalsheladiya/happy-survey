<?php
/**
 * 
 */
class Rating
{	
    public $link = '';

    public function update($surveyId, $comment, $name, $phonenumber, $email, $updatedAt){
        global $mysqli;
        $statement = $mysqli->prepare("UPDATE survey SET comment = ?, email = ?, name = ?, phonenumber = ?, updatedAt = ? WHERE id = ?");
        $statement->bind_param('sssidi', $comment, $email, $name, $phonenumber, $updatedAt, $surveyId);
        $r = $statement->execute();
        $statement->close();
        if($r){
            return true;
        }
        else{
            return false;
        }

    }

    public function getRatingList($uId, $start, $limit){
        global $mysqli;
        $statement = $mysqli->prepare("SELECT r.id, s.name, r.rating, r.comment, r.createdAt 
                                        FROM rating r, store s 
                                            WHERE r.storeId=s.id AND r.userId = ? ORDER BY r.id DESC LIMIT ?,?");
        $statement->bind_param('iii', $uId, $start, $limit);        
        $statement->execute();
        $statement->bind_result($id, $storeId, $rating, $comment, $createdAt);
        $array = array();
        while ($statement->fetch()) {
            $o = new Rating();
            $o->id = $id;
            $o->rating = $rating;
            $o->comment = $comment;
            $o->createdAt = $createdAt;
            $o->storeId = $storeId;
            $array[] = $o;
        }
        $statement->close();
        return $array;        
    }

    public function getRatingListWithStore($uId, $storeId, $start, $limit){
        global $mysqli;
        $statement = $mysqli->prepare("SELECT r.id, s.name, r.rating, r.comment, r.createdAt 
                                        FROM rating r, store s 
                                            WHERE r.storeId = s.id AND r.userId = ? AND r.storeId = ? ORDER BY r.id DESC LIMIT ?,?");
        $statement->bind_param('iiii', $uId, $storeId, $start, $limit);        
        $statement->execute();
        $statement->bind_result($id, $storeId, $rating, $comment, $createdAt);
        $array = array();
        while ($statement->fetch()) {
            $o = new Rating();
            $o->id = $id;
            $o->rating = $rating;
            $o->comment = $comment;
            $o->createdAt = $createdAt;
            $o->storeId = $storeId;
            $array[] = $o;
        }
        $statement->close();
        return $array;        
    }

	public function save($uId, $storeId, $rating, $comment, $createdAt){
		global $mysqli;
		$statement = $mysqli->prepare("INSERT INTO rating(userId, storeId, rating, comment, createdAt, updatedAt)VALUES(?,?,?,?,?,?)");
		$statement->bind_param('iiisdd', $uId, $storeId, $rating, $comment, $createdAt, $createdAt);
		$r = $statement->execute();
		// if($r){
			return $mysqli->insert_id;
		// }
		// else{
		// 	echo $mysqli->error;
		// 	exit();
		// }
	}

    public function _save($uId, $storeId, $rating, $createdAt){
        global $mysqli;
        $statement = $mysqli->prepare("INSERT INTO rating(userId, storeId, rating, createdAt, updatedAt)VALUES(?,?,?,?,?)");
        $statement->bind_param('iiidd', $uId, $storeId, $rating, $createdAt, $createdAt);
        $r = $statement->execute();
        // if($r){
            return $mysqli->insert_id;
        // }
        // else{
        //  echo $mysqli->error;
        //  exit();
        // }
    }

	public function getAllSurveyResultSadCount($uId) {
        global $mysqli;
        $statement= $mysqli->prepare("SELECT count(id) FROM rating WHERE isdeleted=0 AND userId=? AND rating IN (1,2)");
        if($statement) {
            $statement->bind_param('i', $uId);
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

    public function getAllSurveyResultNeautralCount($uId) {
        global $mysqli;
        $statement= $mysqli->prepare("SELECT count(id) FROM rating WHERE isdeleted=0 AND userId=? AND rating IN (3)");
        if($statement) {
            $statement->bind_param('i', $uId);
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

    public function getAllSurveyResultHappyCount($uId) {
        global $mysqli;
        $statement= $mysqli->prepare("SELECT count(id) FROM rating WHERE isdeleted=0 AND userId=? AND rating IN (4,5)");
        if($statement) {
            $statement->bind_param('i', $uId);
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

    public function getCountAll($uId) {
        global $mysqli;
        $statement = $mysqli->prepare("SELECT COUNT(id) FROM rating WHERE userId = ? AND isdeleted = 0");
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

    public function getCustomUrlAfterRating($uId, $storeId){
        global $mysqli;
        $statement = $mysqli->prepare("SELECT glink, welcomeMsg, message
                                            FROM store
                                                WHERE id LIKE ? AND userId LIKE ?");
        $statement->bind_param('ii', $storeId, $uId);
        if($statement){
            $statement->execute();
            $statement->bind_result($glink, $welcomeMsg, $message);
            while ($statement->fetch()) {
                $o = new Rating();                
                $o->link = $glink;
                $o->welcomeMsg = $welcomeMsg; 
                $o->message = $message;                 
                return $o;             
            }            
            $statement->close();
        }       
        else{
            return $mysqli->error;
            exit();
        }  
    }

    public function getUserEmail($userId){
        global $mysqli;
        $statement = $mysqli->prepare("SELECT email FROM user WHERE id LIKE ?");
        $statement->bind_param('i', $userId);
        $statement->execute();
        $statement->bind_result($email);
        $statement->fetch();        
        return $email;
    }

    public function sendEmailNotification($ee, $userId, $surveyId){
        global $mysqli;
        $statement = $mysqli->prepare("SELECT id, isHappy, comment, email, name, phonenumber, userId, createdAt, updatedAt, storeId FROM survey WHERE isdeleted=0 AND id=?");
        $statement->bind_param('i', $surveyId);
        if($statement){
            $statement->execute();
            $statement->bind_result($id, $isHappy, $comment, $email, $name, $phonenumber, $userId, $createdAt, $updatedAt, $storeId);         

            $array = array(); 
            $surveyIds = array();

            while ($statement->fetch()) {
                $o = new Rating();
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
            // return $array;
            $categoryArray = [];
            
            $html = ' <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>  
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                            <title>Survey rating</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                        </head>
                        <body style="margin: 0; padding: 0; background:#f6f4ef">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom: 1px solid #e6e6f2;"> 
                            <tr>
                                <td style="padding: 10px 0 30px 0;"> 
                                    <table align="center" border="1" cellpadding="0" cellspacing="0" width="550" style="border: 1px solid #e6e6f2; border-collapse: collapse;" bgcolor="#fff">
                                        <tr>
                                            <td style="padding: 40px 0 30px 0; color: #153643; font-size: 20px; font-family: Arial, sans-serif;" align="center">
                                               
                                                <img src="https://hpysrvy.com/admin/assets/images/surveylogo.png" alt="Logo" style="display: block;margin-bottom:20px;" width="250" height="70"  />                                                
                                                <h4 align="center">You have received a new customer feedback</h4>
                                                <table align="center" cellpadding="10" cellspacing="1" width="400" 
                                                    style="font-size: 15px; border-collapse: collapse; margin-top:20px; margin-bottom:25px;">';
                                                    foreach ($array as $value) {
                                                        $categoryArray = $value->categories;
                                                        ($value->isHappy == 0) ? $happy = 'Sad' : ''; 
                                                        ($value->isHappy == 1) ? $happy = 'Neautral' : ''; 
                                                        ($value->isHappy == 2) ? $happy = 'Happy' : ''; 
            $html .=                               '<tr>
                                                        <td width="50%"><b>Customer Happiness</b></td>
                                                        <td align="right" width="40%">'.$happy.'</td>
                                                    </tr>';
            $html .=                               '<tr>
                                                        <td><b>Customer Name</b></td>
                                                        <td align="right">'.$value->name.'</td>
                                                    </tr>';
            $html .=                                '<tr>
                                                        <td><b>Customer Email</b></td>
                                                        <td align="right">'.$value->email.'</td>
                                                    </tr>';
            $html .=                                '<tr>
                                                        <td><b>Customer Phone</b></td>
                                                        <td align="right">'.$value->mobile.'</td>
                                                    </tr>';
            $html .=                                '<tr>
                                                        <td width="50%"><b>Comment</b></td>
                                                        <td align="right" width="50%">'.$value->comment.'</td>
                                                    </tr>';
                                                    foreach ($categoryArray as $cat) {
                                                        if($cat->rating > 0){
            $html .=                                '<tr>
                                                        <td><b>Category</b></td>
                                                        <td align="right">'.$cat->name.'</td>
                                                    </tr>';  
            $html .=                                '<tr>
                                                        <td><b>Rating</b></td>
                                                        <td align="right">'.$cat->rating.'</td>
                                                    </tr>';  
                                                        }                      
                                                    }         
                                                }
            $html .=                          '</table>
                                                <a href="https://hpysrvy.com/admin/login.html" style="padding: 10px 55px; background: rgb(251,177,2); font-size:14px; text-decoration:none;color: #fff;margin:">View Details
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <tr>
                                <td align="center" style="padding: 10px 0 30px 0;"> © 2019-HappySurvey. All rights reserved.<br/>If you have any questions feel free to email us at hi@logileap.com </td>
                                </tr>
                            </tr>
                        </table>
                    </body>
                    </html>'; 

            require_once './classes/utility.php';
            $utility = new Utility();
            $subject = "Happy Survey - Your store's survey feedback";  
            $result = $utility->sendEmailforSurvey($ee, $subject, $html, "norply@logileap.net");
            return $result;
        }
        else{
            return $mysqli->error();
            exit();
        }        
    }
}

?>