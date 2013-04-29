<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/db.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/sport.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/school.php");

class Team { 

	private $team_id;
	private $name;
	private $photo;
	private $home_logo;
	private $away_logo;
	private $sport_id;
	private $sport;
	private $school_id;
	private $school;
	

	public function Team($row) 
	{
        if(isset($row))
		{
			$this->team_id= $row['team_id'];
			$this->name= $row['name'];
			$this->photo= $row['photo'];
			$this->home_logo= $row['home_logo'];
			$this->away_logo= $row['away_logo'];
			$this->sport_id = $row['sport_id'];
			$this->school_id = $row['school_id'];
		}
    }

	public function get_team_id() { return $this->team_id; }
	public function get_name(){ return $this->name; }
	public function get_photo(){ return $this->photo; }
	public function get_home_logo(){ return $this->home_logo; }
	public function get_away_logo(){ return $this->away_logo; }
	public function get_sport_id(){ return $this->sport_id; }
	public function get_sport(){ 
		if(!isset($this->sport))
			$this->sport = Sport::getSportById($this->sport_id);
		return $this->sport; 
	}
	
	public function get_school_id(){ return $this->school_id; }
	public function get_school(){ 
		if(!isset($this->school))
			$this->school = School::getSchoolById($this->school_id);
		return $this->school; 
	}
	
	public function set_name($val){ $this->name = $val; }
	public function set_photo($val){ $this->photo = $val; }
	public function set_home_logo($val){ $this->home_logo = $val; }
	public function set_away_logo($val){ $this->away_logo = $val; }
	public function set_sport_id($val){ $this->sport_id = $val; }
	public function set_school_id($val){ $this->school_id = $val; }
	
	public function delete(){
		 Team::deleteTeam($this->team_id);
	 }
	
	public function save()
	{
		if(!isset($this->team_id))
		{
			$this->create();
		} else {
			$this->update();
		}
	}
	
	private function create()
	{
		$name = filter_var($this->name, FILTER_SANITIZE_STRING);
		$photo = filter_var($this->photo, FILTER_SANITIZE_STRING);
		$home_logo = filter_var($this->home_logo, FILTER_SANITIZE_URL);
		$away_logo = filter_var($this->away_logo, FILTER_SANITIZE_URL);
		$sport_id = (int) $this->sport_id;
		$school_id = (int) $this->school_id;
		
		$create = "INSERT INTO `team` (`name`, `photo`, `home_logo`, `away_logo`,`sport_id`, `school_id`) VALUES 
				('$name','$photo','$home_logo','$away_logo','$sport_id','$school_id')";
		$result = db_execute($create);
		$this->team_id = getLastId();
	}
	
	private function update()
	{
		$name = filter_var($this->name, FILTER_SANITIZE_STRING);
		$photo = filter_var($this->photo, FILTER_SANITIZE_STRING);
		$home_logo = filter_var($this->home_logo, FILTER_SANITIZE_URL);
		$away_logo = filter_var($this->away_logo, FILTER_SANITIZE_URL);
		$sport_id = (int) $this->sport_id;
		$school_id = (int) $this->school_id;
		$team_id = (int) $this->team_id;
		
		$update = "UPDATE `team` SET `name` = '$name', `photo` = '$photo', `home_logo` = '$home_logo', `away_logo` = '$away_logo', 
				`sport_id` = '$sport_id', `school_id` = '$school_id' WHERE `team_id` = '$team_id'";
		$result = db_execute($update);
	}
	
	public static function getObjects($sql)
	{
		$result = db_execute($sql);
		$objects = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$objects[] = new Team($row);
		}
		return $objects;
	}
	
	public static function getTeams($limit)
	{
		$search = "SELECT * FROM team";
		if(isset($limit))
		{
			$limit = (int) $limit;
			$search .= " LIMIT $limit"; 
		}
		return Team::getObjects($search);
	}
	
	public static function getTeamById($team_id)
	{
		$team_id = (int) $team_id;
		if(!is_int($team_id) || $team_id == 0)
		{
			return null;
		}
		$search = "SELECT * FROM team WHERE `team_id` = '$team_id' LIMIT 1";
		$teams = Team::getObjects($search);
		if(count($teams) > 0)
			return $teams[0];
		return null;
	}
	
	public static function deleteTeam($id)	{
		$id = (int) $id;
		if(!is_int($id) || $id == 0)
		{
			return null;
		}
		
		$delete = "DELETE FROM `team` WHERE `team_id` = $id";
		db_execute($delete);
	}
}
?>