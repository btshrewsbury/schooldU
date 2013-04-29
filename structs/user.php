<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/db.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/school.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/head2head.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/pool.php");

class User { 

private $user_id;
private $email;
private $password;
private $fb_access_token;
private $fb_code;
private $profile_pic;
private $first_name;	
private $last_name;
private $stripe_id;
private $school_id;
private $school;
private $charity_id;
private $fb_id;
private $paypal_email;
private $paypal_pa;
	
	 public function User($row) 
	{
        if(isset($row)){
			$this->user_id= $row['user_id'];
			$this->email= $row['email'];
			$this->fb_code= $row['fb_code'];
			$this->fb_access_token= $row['fb_access_token'];
			$this->fb_id= $row['fb_id'];
			$this->populateUserDetails();
		}
    }
	
	public function get_user_id() { return $this->user_id; }
	public function get_email(){ return $this->email; }
	public function get_fb_id(){ return $this->fb_id; }
	public function get_fb_code(){ return $this->fb_code; }
	public function get_fb_access_token(){ return $this->fb_access_token; }
	public function get_profile_pic(){ return $this->profile_pic; }
	public function get_first_name(){ return $this->first_name; }
	public function get_last_name(){ return $this->last_name; }
	public function get_name(){ return $this->first_name . " " . $this->last_name; }
	public function get_stripe_id(){ return $this->stripe_id; }

	public function get_school_id(){ return $this->school_id; }
	public function get_charity_id(){ return $this->charity_id; }
	public function get_paypal_email(){ return $this->paypal_email; }
	public function get_paypal_pa(){ return $this->paypal_pa; }
	public function get_school(){ 
		if(!isset($this->school))
			$this->school = School::getSchoolById($this->school_id);
		return $this->school; 
	}
	
	public function getUnmatchedChallenges()
	{
		return Head2Head::getUnmatchedChallengesByUser($this->user_id);
	}
	
	public function getTopCharities($limit)
	{
		return Head2Head::getFavoriteCharitiesByUser($this->user_id, $limit);
	}
	
	public function getActiveMatchedChallenges()
	{
		return Head2Head::getActiveMatchedChallengesByUser($this->user_id);
	}
	
	public function getActivePoolededChallenges()
	{
		return Pool::getActiveChallengesByUser($this->user_id);
	}
	
	public function getFinishedPoolededChallenges()
	{
		return Pool::getFinishedChallengesByUser($this->user_id);
	}
	
	public function getFinishedH2HChallenges()
	{
		return Head2Head::getFinishedChallengesByUser($this->user_id);
	}
	
	
	public function getAmountDonated()
	{
		$amount = Pool::getPaidAmountByUser($this->user_id);
		$amount += Head2Head::getPaidAmountByUser($this->user_id);
		return $amount;
	}
	
	public function getNumberWon()
	{
		return Head2Head::getNumberWonByUser($this->user_id);
	}
	public function getNumberLost()
	{
		return Head2Head::getNumberLostByUser($this->user_id);
	}
	
	
	public function populateUserDetails()
	{
		$row = User::getUserDetails($this->user_id);
		if(isset($row))
		{
			$this->profile_pic = $row['profile_pic'];
			$this->first_name = $row['first_name'];	
			$this->last_name = $row['last_name'];
			$this->stripe_id = $row['stripe_id'];
			$this->school_id = $row['school_id'];
			$this->charity_id = $row['charity_id'];
			$this->paypal_email = $row['paypal_email'];
			$this->paypal_pa = $row['paypal_pa'];
		}
	}
	
	public function getSchool()
	{
		if(!isset($this->school))
			$this->school = School::getSchoolById($this->school_id);
		return $this->school; 
	}
	
	public function set_email($val){ $this->email = $val; }
	public function set_password($val){ $this->password = $val; }
	public function set_fb_code($val){ $this->fb_code = $val; }
	public function set_fb_access_token($val){ $this->fb_access_token = $val; }
	public function set_profile_pic($val){ $this->profile_pic = $val; }
	public function set_first_name($val){ $this->first_name = $val; }
	public function set_last_name($val){ $this->last_name = $val; }
	public function set_stripe_id($val){ $this->stripe_id = $val; }
	public function set_fb_id($val){ $this->fb_id = $val; }
	public function set_school_id($val){ $this->school_id = $val; }
	public function set_paypal_email($val){ $this->paypal_email = $val; }
	public function set_paypal_pa($val){ $this->paypal_pa = $val; }
	
	public function delete(){
		 User::deleteUser($this->user_id);
	 }	
	
	public function save()
	{
		if(!isset($this->user_id))
		{
			$this->create();
		} else {
			$this->update();
		}
	}
	
	private function create()
	{
	
		$mod_email = 'NULL';
		$password = filter_var($this->password, FILTER_SANITIZE_STRING);
		$fb_code = filter_var($this->fb_code, FILTER_SANITIZE_STRING);
		$fb_access_token = filter_var($this->fb_access_token, FILTER_SANITIZE_STRING);
		$fb_id = (int) $this->fb_id;
		
		$profile_pic = filter_var($this->profile_pic, FILTER_SANITIZE_URL);
		$first_name = filter_var($this->first_name, FILTER_SANITIZE_STRING);
		$last_name = filter_var($this->last_name, FILTER_SANITIZE_STRING);
		$stripe_id = filter_var($this->stripe_id, FILTER_SANITIZE_STRING);
		$school_id = (int) $this->school_id;
		
		if (isset($this->email))
		{
			$mod_email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
			$mod_email = "'$mod_email'";
		}
		$createUser = "INSERT INTO `user` (`email`, `pass`,`fb_code`, `fb_access_token`, `fb_id`) 
					VALUES ($mod_email,SHA1('$password'),'$fb_code','$fb_access_token','$fb_id')";
		db_execute($createUser);
		$this->user_id = getLastId();
		$user_id = $this->user_id;
		$createDetails = "INSERT INTO `user_details` (`user_id`, `profile_pic`, `first_name`, `last_name`, `stripe_id`,`school_id`) 
					VALUES ($user_id,'$profile_pic','$first_name','$last_name','$stripe_id','$school_id')";
		db_execute($createDetails);
	}
	
	private function update()
	{
	
		$password = filter_var($this->password, FILTER_SANITIZE_STRING);
		$fb_code = filter_var($this->fb_code, FILTER_SANITIZE_STRING);
		$fb_access_token = filter_var($this->fb_access_token, FILTER_SANITIZE_STRING);
		$fb_id = (int) $this->fb_id;
		$email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
		
		$profile_pic = filter_var($this->profile_pic, FILTER_SANITIZE_URL);
		$first_name = filter_var($this->first_name, FILTER_SANITIZE_STRING);
		$last_name = filter_var($this->last_name, FILTER_SANITIZE_STRING);
		$stripe_id = filter_var($this->stripe_id, FILTER_SANITIZE_STRING);
		$school_id = (int) $this->school_id;
		$user_id = (int) $this->user_id;
		$paypal_email = filter_var($this->paypal_email, FILTER_SANITIZE_STRING);
		$paypal_pa = filter_var($this->paypal_pa, FILTER_SANITIZE_STRING);
		
		
		$updateUser = "UPDATE `user` SET `email` = '$email', `fb_code` = '$fb_code', `fb_access_token` = '$fb_access_token' WHERE `user_id` = '$user_id'";
		db_execute($updateUser);
		
		$updateDetails = "UPDATE `user_details` SET `profile_pic` = '$profile_pic', `first_name` = '$first_name', `last_name` = '$last_name', 
						`stripe_id` = '$stripe_id', `school_id` = '$school_id' , `paypal_pa` = '$paypal_pa', 
						`paypal_email` = '$paypal_email' WHERE `user_id` = '$user_id'";
		db_execute($updateDetails);
		$_SESSION['me'] = $this;
	}
	
	public static function getObjects($sql)
	{
		$result = db_execute($sql);
		$objects = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$objects[] = new User($row);
		}
		return $objects;
	}
	
	private static function getUserDetails($user_id)
	{
		$user_id = (int) $user_id;
		if(!is_int($user_id) || $user_id == 0)
		{
			return null;
		}
		
		$search = "SELECT * FROM user_details WHERE `user_id` = '$user_id' LIMIT 1";
		$result = db_execute($search);
		while ($row = mysqli_fetch_assoc($result)) {
			return $row;
		}
		return null;
	}
	
	public static function getUserById($user_id)
	{
		$user_id = (int) $user_id;
		if(!is_int($user_id) || $user_id == 0)
		{
			return null;
		}
	
		$search = "SELECT * FROM user WHERE `user_id` = '$user_id' LIMIT 1";
		$users = User::getObjects($search);
		if(count($users) > 0)
			return $users[0];
		return null;
	}
	
	public static function getUserByEmail($email)
	{
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if($email = false)
			return null;
			
		$search = "SELECT * FROM user WHERE `email` = '$email' LIMIT 1";
		$users = User::getObjects($search);
		if(count($users) > 0)
			return $users[0];
		return null;
	}
	
	public static function getUserByFbId($fbid)
	{
		$fbid = (int) $fbid;
		if(!is_int($fbid) || $fbid == 0)
		{
			return null;
		}
		
		$search = "SELECT * FROM user WHERE `fb_id` = '$fbid' LIMIT 1";
		$users = User::getObjects($search);
		if(count($users) > 0)
			return $users[0];
		return null;
	}
	
	public static function login($email,$pass)
	{
		if(isset($email) && isset($pass))
		{
			
			$local_email = filter_var($email, FILTER_SANITIZE_EMAIL);
			$local_email = escape_string($local_email);
			$local_pass = escape_string(trim($pass));
			$local_pass = filter_var($pass, FILTER_SANITIZE_STRING);
			
			$search = "SELECT user_id FROM user WHERE email='" . $local_email ."' AND pass=SHA1('" . $local_pass . "') LIMIT 1";
			$users = User::getObjects($search);
			if(count($users) > 0)
				return $users[0];
		}
		return null;
	}
	
	
	public static function deleteUser($id)	{
		$id = (int) $id;
		if(!is_int($id) || $id == 0)
		{
			return null;
		}
	
		$delete = "DELETE FROM `user` WHERE `user_id` = $id";
		db_execute($delete);
		$delete = "DELETE FROM `user_details` WHERE `user_id` = $id";
		db_execute($delete);
	}
}
?>