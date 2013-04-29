<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/db.php");

class Sport { 

	private $sport_id;
	private $type;
	
	 public function Sport($row) 
	{
        if(isset($row)){
			$this->sport_id= $row['sport_id'];
			$this->type= $row['type'];
		}
    }
	
	public function get_sport_id() { return $this->sport_id; }
	public function get_type(){ return $this->type; }
	public function set_type($val){ $this->type = $val; }
	
	public function delete(){
		 Sport::deleteSport($this->sport_id);
	 }	
	 
	public function save()
	{
		if(!isset($this->sport_id))
		{
			$this->create();
		} else {
			$this->update();
		}
	}
	
	private function create()
	{
		$type = filter_var($this->type, FILTER_SANITIZE_STRING);  
		$create = "INSERT INTO `sport` (`type`) VALUES ('$type')";
		$result = db_execute($create);
		$this->sport_id = getLastId();
	}
	
	private function update()
	{
		$type = filter_var($this->type, FILTER_SANITIZE_STRING);  
		$sport_id = (int) $this->sport_id;
		$update = "UPDATE `sport` SET `type` = '$type' WHERE `sport_id` = '$this->sport_id'";
		$result = db_execute($update);
	}
	
	public static function getObjects($sql)
	{
		$result = db_execute($sql);
		$objects = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$objects[] = new Sport($row);
		}
		return $objects;
	}
	
	public static function getSportById($sport_id)
	{
		$sport_id = (int) $sport_id;
		if(!is_int($sport_id) || $sport_id == 0)
		{
			return null;
		}
		$search = "SELECT * FROM sport WHERE `sport_id` = '$sport_id' LIMIT 1";
		$result = Sport::getObjects($search);
		if(count($result) > 0)
			return $result[0];
		return null;
	}
	
	public static function getSports()
	{
		$search = "SELECT * FROM sport";
		return Sport::getObjects($search);
	}
	
	public static function deleteSport($id)	{
		$id = (int) $id;
		if(!is_int($id) || $id == 0)
		{
			return null;
		}
		$delete = "DELETE FROM `sport` WHERE `sport_id` = $id";
		db_execute($delete);
	}
}
?>