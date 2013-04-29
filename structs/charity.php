<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/db.php");


class Charity {
 	
	
	private $charity_id;
	private $name;
	private $ein;
	private $careOf;
	private $address;
	private $city;
	private $state;
	private $zip;
	private $subsection;
	private $classification;
	private $deductibility;
	private $foundation;
	private $activity;
	private $nteeCode;
	

	public function Charity($row) 	{
		if(isset($row))
		{
			$this->charity_id= $row['charity_id'];
			$this->name= ucwords(strtolower($row['name']));
			$this->ein = $row['ein'];;
			$this->careOf = $row['careOf'];
			$this->address = $row['address'];
			$this->city = $row['city'];
			$this->state = $row['state'];
			$this->zip = $row['zip'];
			$this->subsection = $row['subsection'];
			$this->classification = $row['classification'];
			$this->deductibility = $row['deductibility'];
			$this->foundation = $row['foundation'];
			$this->activity = $row['activity'];
			$this->nteeCode = $row['nteeCode'];
		}    
	}		
		
	public function get_ein() { return $this->ein;}
	//public function set_ein($var) { $this->ein = $var;}
	public function get_careOf() { return $this->careOf;}
	//public function set_careOf($var) { $this->careOf = $var;}
	public function get_address() { return $this->address;}
	//public function set_address($var) { $this->address = $var;}
	public function get_city() { return $this->city;}
	//public function set_city($var) { $this->city = $var;}
	public function get_state() { return $this->state;}
	//public function set_state($var) { $this->state = $var;}
	public function get_zip() { return $this->zip;}
	//public function set_zip($var) { $this->zip = $var;}
	public function get_subsection() { return $this->subsection;}
	//public function set_subsection($var) { $this->subsection = $var;}
	public function get_classification() { return $this->classification;}
	//public function set_classification($var) { $this->classification = $var;}
	public function get_deductibility() { return $this->deductibility;}
	//public function set_deductibility($var) { $this->deductibility = $var;}
	public function get_foundation() { return $this->foundation;}
	//public function set_foundation($var) { $this->foundation = $var;}
	public function get_activity() { return $this->activity;}
	//public function set_activity($var) { $this->activity = $var;}
	public function get_nteeCode() { return $this->nteeCode;}
	//public function set_nteeCode($var) { $this->nteeCode = $var;}
	public function get_full_address() { return "$this->address $this->city, $this->state $this->zip"; }	
	public function get_charity_id() { return $this->charity_id;}	
	public function get_name(){ return $this->name; }	
	//public function set_name($val){ $this->name = $val; }	
/*		
	 public function delete(){
		 Charity::deleteCharity($this->charity_id);
	 }	
	

	public function save()	{
		if(!isset($this->charity_id)) {
			$this->create();
		} else {
			$this->update();
		}	
	}		
	private function create()	{
			$create = "INSERT INTO `charity` (`name`, `ein`,`careOf`,`address`,`city`,`state`,`zip`,`subsection`,`classification`,`deductibility`,`foundation`,`activity`,`nteeCode`) VALUES 
					('$this->name','$this->ein','$this->careOf','$this->address','$this->city','$this->state','$this->zip','$this->subsection','$this->classification','$this->deductibility','$this->foundation','$this->activity','$this->nteeCode')";
			$result = db_execute($create);
			$this->charity_id = getLastId();
	}		
	private function update()	{
			$update = "UPDATE `charity` SET `name` = '$this->name', `description` = '$this->description', `image` = '$this->image' WHERE `charity_id` = '$this->charity_id'";
			$result = db_execute($update);
	}
	
	public static function deleteCharity($id)	{
		$id = (int) $id;
		if(!is_int($id) || $id == 0)
			return;
		$delete = "DELETE FROM `charity` WHERE `charity_id` = $id";
		db_execute($delete);
	}
	
	*/		
	public static function getObjects($sql)	{
		$result = db_execute($sql);
		$objects = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$objects[] = new Charity($row);
		}		
		return $objects;
	}		
	public static function getCharityById($charity_id)	{
		$charity_id = (int) $charity_id;
		if(!is_int($charity_id) || $charity_id == 0)
			return null;
	
		$search = "SELECT * FROM charity WHERE `charity_id` = '$charity_id' LIMIT 1";
		$result = Charity::getObjects($search);
		if(count($result) > 0)
			return $result[0];
		return null;
	}			
	public static function getCharities($limit)	{
		$search = "SELECT * FROM charity";
		if(isset($limit))
		{
			$limit = (int) $limit;
			$search .= " LIMIT $limit";
		}
		return Charity::getObjects($search);
	}
	
	public static function searchCharities($name,$state,$city,$zip,$limit = 50,$offset = 0,&$size)	{
		
		
		$name = escape_string($name);
		$state = filter_var($state, FILTER_SANITIZE_STRING);
		$city = filter_var($city, FILTER_SANITIZE_STRING);
		$zip = (int) $zip;
		$limit = (int) $limit;
		$offset = (int) $offset;
		

		$search = "";
		$addAnd = False;
		if($name != "")
		{
			$search .= "`name` LIKE '%$name%'";
			$addAnd = True;
		}		
		if($state != "")
		{
			if($addAnd)
				$search .= " AND ";
			$search .= "`state` LIKE '%$state%'";
			$addAnd = True;
		}
		if($city != "")
		{
			if($addAnd)
				$search .= " AND ";
			$search .= "`city` LIKE '%$city%'";
			$addAnd = True;
		}
		if($zip != "")
		{
			if($addAnd)
				$search .= " AND ";
			$search .= "`zip` LIKE '$zip%'";
			$addAnd = True;
		}
		if($search == "")
			return null;
			
		if($size == null)
		{
			$count = "SELECT COUNT(*) FROM charity WHERE " . $search;
			$result = db_execute($count);

			while ($row = mysqli_fetch_assoc($result)) {
				$size = $row['COUNT(*)'];
			}		
		}

		$search = "SELECT * FROM charity WHERE " . $search . " Limit $limit OFFSET $offset";
		return Charity::getObjects($search);
	}
	
	
}
?>