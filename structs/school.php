<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/db.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/charity.php");

class School { 

	private $school_id;
	private $name;
	private $city;
	private $state;
	private $charity_id;
	private $charity;
	
	 public function School($row) 
	{
        if(isset($row)){
			$this->school_id= $row['school_id'];
			$this->name= $row['name'];
			$this->city= $row['city'];
			$this->state = $row['state'];
			$this->charity_id = $row['charity_id'];
		}
    }
	
	public function get_school_id() { return $this->school_id; }
	public function get_name(){ return $this->name; }
	public function get_city(){ return $this->city; }
	public function get_state(){ return $this->state; }
	public function get_charity_id(){ return $this->charity_id; }
	public function get_charity(){ 
		if(!isset($this->charity))
			$this->charity = Charity::getCharityById($this->charity_id);
		return $this->charity; 
	}
	
	public function set_name($val){ $this->name = $val; }
	public function set_city($val){ $this->city = $val; }
	public function set_state($val){ $this->state = $val; }
	public function set_charity_id($val){$this->charity_id = $val; }
	
	public function delete(){
		 School::deleteSchool($this->school_id);
	 }	
	
	public function save()
	{
		if(!isset($this->school_id))
		{
			$this->create();
		} else {
			$this->update();
		}
	}
	
	private function create()
	{
		$name = filter_var($this->name, FILTER_SANITIZE_STRING); 
		$city = filter_var($this->city, FILTER_SANITIZE_STRING); 
		$state = filter_var($this->state, FILTER_SANITIZE_STRING); 
		$charity_id = (int) $this->charity_id;
		
		$create = "INSERT INTO `school` (`name`, `city`, `state`,`charity_id`) VALUES ('$name','$city','$state','$charity_id')";
		$result = db_execute($create);
		$this->school_id = getLastId();
	}
	
	private function update()
	{
		$name = filter_var($this->name, FILTER_SANITIZE_STRING); 
		$city = filter_var($this->city, FILTER_SANITIZE_STRING); 
		$state = filter_var($this->state, FILTER_SANITIZE_STRING); 
		$charity_id = (int) $this->charity_id;
		$school_id = (int) $this->school_id;
		
		$update = "UPDATE `school` SET `name` = '$name', `city` = '$city', `state` = '$state', `charity_id` = '$charity_id' WHERE `school_id` = '$school_id'";
		$result = db_execute($update);
	}
	
	public static function getObjects($sql)
	{
		$result = db_execute($sql);
		$objects = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$objects[] = new School($row);
		}
		return $objects;
	}
	
	public static function getSchoolById($school_id)
	{
		$school_id = (int) $school_id;
		if(!is_int($school_id) || $school_id == 0)
		{
			return null;
		}
		
		$search = "SELECT * FROM school WHERE `school_id` = '$school_id' LIMIT 1";
		$result = School::getObjects($search);
		if(count($result) > 0)
			return $result[0];
		return null;
	}
	
	public static function getSchools()
	{
		$search = "SELECT * FROM school";
		return School::getObjects($search);
	}
	
	public static function deleteSchool($id)	{
		$id = (int) $id;
		if(!is_int($id) || $id == 0)
		{
			return null;
		}
		$delete = "DELETE FROM `school` WHERE `school_id` = $id";
		db_execute($delete);
	}
}
?>