<?php


class surveyCategory {

	public $id;
	public $surveyId;
	public $categoryId;
	public $name;
	public $rating = 0;

	public function getSurveyCategoryRating($storeId, $userId){
		global $mysqli;
		// SELECT cat.name categoryName, temp.rating averageRating FROM (SELECT sc.categoryId catId, avg(sc.rating) rating FROM `surveyCategory` as sc, `survey` as s WHERE s.id = sc.surveyId AND s.userId = ? GROUP BY sc.categoryId) as temp, category as cat WHERE temp.catId = cat.id ORDER BY averageRating DESC 
		if($storeId){
			$statement = $mysqli->prepare("SELECT c.name AS categoryName, AVG(sc.rating) AS rating FROM survey s, `surveyCategory` sc, category c 
											WHERE s.userId = ? AND s.storeId = ? AND s.id = sc.surveyId AND sc.categoryId = c.id AND c.isdeleted = 0
												GROUP BY sc.categoryId ORDER BY AVG(sc.rating) DESC");
			$statement->bind_param('ii', $userId, $storeId);
		}
		else{
			$statement = $mysqli->prepare("SELECT c.name AS categoryName, AVG(sc.rating) AS rating FROM survey s, `surveyCategory` sc, category c 
											WHERE s.userId = ? AND s.id = sc.surveyId AND sc.categoryId = c.id AND c.isdeleted = 0
											GROUP BY sc.categoryId ORDER BY AVG(sc.rating) DESC");
			$statement->bind_param('i', $userId);
		}
		if($statement){
			$statement->execute();
			$statement->bind_result($category, $rating);
			$data = array();
			while ($statement->fetch()) {
				$o = new StdClass();
				$o->categoryName = $category;
				$o->rating = $rating;
				$data[$o->categoryName] = $o->rating;            	
        	}
        	$statement->close();
        	return $data;			
		}
		else{
			return $mysqli->error;
			exit();
		}
	}
	public function save() {
		global $mysqli;		
		$statement = $mysqli->prepare("INSERT INTO surveyCategory(surveyId, categoryId, rating) VALUES (?,?,?)");
		$statement->bind_param('iid', $this->surveyId, $this->categoryId, $this->rating);			
		$r = $statement->execute();
		$statement->close();
		if($r) {
			$this->id = $mysqli->insert_id;
			return $this->id;
		}
		else {
			return FALSE;
		}
	}

	public function getsurveyCategoryForsurveyIds($surveyIds) {
		global $mysqli;
		$commaSepratedsurveyIds = implode($surveyIds, ",");
		// if (count($commaSepratedsurveyIds) > 0) {
			$statement = $mysqli->prepare("SELECT sc.id, sc.surveyId, sc.categoryId, c.name, sc.rating FROM surveyCategory AS sc, category AS c WHERE sc.categoryId = c.id AND sc.surveyId IN ({$commaSepratedsurveyIds}) AND isdeleted = 0");
			if($statement) {
				$statement->execute();
				$statement->bind_result($id, $surveyId, $categoryId, $name, $rating);
				$array = array();
				while ($statement->fetch()) {
		            $o = new surveyCategory();
		            $o->id = $id;               
		            $o->surveyId = $surveyId;
		            $o->categoryId = $categoryId;
		            $o->name = $name;
		            $o->rating = (float) number_format($rating,1);
		            $array[] = $o;
		        }
		        $statement->close();
		        return $array;
			}
			else {
				echo $mysqli->error;
				exit();
			}
		// }
		// else {
		// 	return $array();
		// }
	}

	public function getCategory($id) {
		global $mysqli;
		$statement = $mysqli->prepare("SELECT s.id, s.surveyId, s.categoryId, c.name FROM surveyCategory AS s, category AS c WHERE s.categoryId = c.id AND s.surveyId = ?");
		
		if($statement) {
			$statement->bind_param('i',$id);
			$statement->execute();
			$statement->bind_result($id, $surveyId,$categoryId,$name);
			$array = array();
			while ($statement->fetch()) {
	            $o = new surveyCategory();
	            $o->id = $id;               
	            $o->surveyId = $surveyId;
	            $o->categoryId = $categoryId;
	            $o->name = $name;
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

	public function getCat($id) {
		global $mysqli;
		//$commaSepratedsurveyIds = implode($categoryId, ",");
		$statement = $mysqli->prepare("SELECT s.surveyId, s.categoryId, c.name FROM surveyCategory AS s, category AS c WHERE s.categoryId = c.id AND s.surveyId ?");
		
		if($statement) {
			$statement->bind_param('i',$id);
			$statement->execute();
			$statement->bind_result($id,$categoryId,$name);
			$array = array();
			while ($statement->fetch()) {
	            $o = new surveyCategory();
	            //$o->id = $id;       
	            
	            $o->categoryId = $categoryId;
	            $o->name = $name;
	            $array[] = $o;
	        }	        
	        return $array;
		}
		else {
			echo $mysqli->error;
			exit();
		}

	}

	public function insertsurveyCategories($surveyId, /*$categoryIds,*/ $ratings) {
			
		require_once './classes/category.php';
		$categoryIds = array();

		foreach ($ratings as $rating) {
			$categoryIds[] = $rating['id'];
		}

		$category = new Category();
		$categories = $category->getCategoryForIds($categoryIds);

		$array = array();

		foreach ($ratings as $rating) {
			$surveyCategory = new surveyCategory();
 		
			$categoryId = $rating['id'];
			$surveyCategory->surveyId = $surveyId;
			$surveyCategory->categoryId = $categoryId;
			$surveyCategory->rating = (float) number_format($rating['rating'],1);

			foreach ($categories as $category) {
				if($category->id == $categoryId) {
					$surveyCategory->name = $category->name;					
				}				
			}		
			$surveyCategory->save();
			$array[] = $surveyCategory;
		}
		return $array;
	}
}
?>

