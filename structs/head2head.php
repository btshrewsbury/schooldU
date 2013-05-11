<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/db.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/team.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/game.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/user.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/charity.php");


class Head2Head { 

	private $challenge_id;
	private $user_id;
	private $user;
	private $team_id;
	private $team;
	private $game_id;
	private $game;
	private $charity_id;
	private $charity;
	private $paired_challenge_id;	
	private $paired_challenge;	
	private $amount;
	private $won;
	
	 public function Head2Head($row) 
	{
        if(isset($row)){
			$this->challenge_id= $row['challenge_id'];
			$this->user_id= $row['user_id'];
			$this->team_id= $row['team_id'];
			$this->game_id= $row['game_id'];
			$this->charity_id = $row['charity_id'];
			$this->paired_challenge_id = $row['paired_challenge_id'];
			$this->amount = $row['amount'];
			$this->won = $row['won'];
		}
    }
	
	public function get_challenge_id() { return $this->challenge_id; }
	public function get_user_id(){ return $this->user_id; }
	
	public function get_user(){ 
		if(!isset($this->user) && isset($this->user_id))
			$this->user = User::getUserById($this->user_id);
		return $this->user; 
	}
	
	public function get_team_id(){ return $this->team_id; }
	public function get_team(){ 
		if(!isset($this->team) && isset($this->team_id))
			$this->team = Team::getTeamById($this->team_id);
		return $this->team; 
	}
	
	public function get_game_id(){ return $this->game_id; }
	public function get_game(){ 
		if(!isset($this->game) && isset($this->game_id))
			$this->game = Game::getGameById($this->game_id);
		return $this->game; 
	}
	
	public function get_losing_team(){ 
		return $this->get_game()->get_other_team($this->team_id);
	}
	
	public function get_losing_team_id(){ 
		return $this->get_game()->get_other_team($this->team_id)->get_team_id();
	}
	
	public function get_charity_id(){ return $this->charity_id; }
	public function get_charity(){ 
		if(!isset($this->charity) && isset($this->charity_id))
			$this->charity = Charity::getCharityById($this->charity_id);
		return $this->charity; 
	}
	
	public function is_paired(){ return ($this->paired_challenge_id != 0); }
	public function get_paired_challenge_id(){ return $this->paired_challenge_id; }
	public function get_paired_challenge(){ 
		if(!isset($this->paired_challenge) && isset($this->paired_challenge_id) && $this->paired_challenge_id != 0)
		{
			$this->paired_challenge = Head2head::getChallengeById($this->paired_challenge_id);
			$this->paired_challenge->set_paired_challenge($this);
		}
		return $this->paired_challenge; 
	}
	
	//saves both objects!
	public function create_and_save_paired_challenge($user_id,$charity_id){ 
		$pairedChallenge = new Head2Head(null);

		$pairedChallenge->set_user_id($user_id);
		$pairedChallenge->set_team_id($this->get_losing_team_id());
		$pairedChallenge->set_game_id($this->get_game_id());
		$pairedChallenge->set_charity_id($charity_id);
		$pairedChallenge->set_paired_challenge_id($this->get_challenge_id());
		$pairedChallenge->set_amount($this->get_amount());
		
		$pairedChallenge->save();
		$this->set_paired_challenge_id($pairedChallenge->get_challenge_id());
		$this->save();
		return $pairedChallenge;
	}

	public function set_paired_challenge($challengeObject){ 
		$this->paired_challenge = $challengeObject; 
		$this->paired_challenge_id = $challengeObject->get_paired_challenge_id();
	}
	
	public function get_amount(){ return $this->amount; }
	public function get_won(){ return $this->won; }
	
	public function set_user_id($val){ $this->user_id = $val; }
	public function set_team_id($val){ $this->team_id = $val; }
	public function set_game_id($val){ $this->game_id = $val; }
	public function set_charity_id($val){ $this->charity_id = $val; }
	public function set_paired_challenge_id($val){ $this->paired_challenge_id = $val; }
	public function set_amount($val){ $this->amount = $val; }
	public function set_won($val){ $this->won = $val; }
	
	public function delete(){
		 Head2Head::deleteChallenge($this->challenge_id);
	 }	
	
	public function save()
	{
		if(!isset($this->challenge_id))
		{
			$this->create();
		} else {
			$this->update();
		}
	}
	
	private function create()
	{
		$user_id = (int) $this->user_id;
		$team_id = (int) $this->team_id;
		$game_id = (int) $this->game_id;
		$charity_id = (int) $this->charity_id;
		$paired_challenge_id = (int) $this->paired_challenge_id;
		$amount = (int) $this->amount;
		$won = (int) $this->won;
	
		$create = "INSERT INTO `head2head` (`user_id`, `team_id`, `game_id`, `charity_id`, `paired_challenge_id`, `amount`, `won`) 
				VALUES ('$user_id','$team_id','$game_id','$charity_id','$paired_challenge_id','$amount','$won')";
		$result = db_execute($create);
		$this->challenge_id = getLastId();
	}
	
	private function update()
	{
		$challenge_id = (int) $this->challenge_id;
		$user_id = (int) $this->user_id;
		$team_id = (int) $this->team_id;
		$game_id = (int) $this->game_id;
		$charity_id = (int) $this->charity_id;
		$paired_challenge_id = (int) $this->paired_challenge_id;
		$amount = (int) $this->amount;
		$won = (int) $this->won;
		
		$update = "UPDATE `head2head` SET `user_id` = '$user_id', `team_id` = '$team_id', `game_id` = '$game_id', `charity_id` = '$charity_id', 
					`paired_challenge_id` = '$paired_challenge_id', `amount` = '$amount', `won` = '$won' WHERE `challenge_id` = '$challenge_id'";
		$result = db_execute($update);
	}
	
	public static function getObjects($sql)
	{
		$result = db_execute($sql);
		$objects = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$objects[] = new Head2Head($row);
		}
		return $objects;
	}
	
	public static function getChallengeById($challenge_id)
	{
		$challenge_id = (int) $challenge_id;
		if(!is_int($challenge_id) || $challenge_id == 0)
		{
			return null;
		}
		$search = "SELECT * FROM head2head WHERE `challenge_id` = '$challenge_id' LIMIT 1";
		$result = Head2head::getObjects($search);
		if(count($result) != 0)
			return $result[0];
		return null;
	}
	
	public static function getChallengesByUser($user_id)
	{
		$user_id = (int) $user_id;
		if(!is_int($user_id) || $user_id == 0)
		{
			return null;
		}
		$search = "SELECT * FROM head2head WHERE `user_id` = '$user_id'";
		return Head2head::getObjects($search);
	}
	
	public static function getUnmatchedChallengesByUser($user_id)
	{
		$user_id = (int) $user_id;
		if(!is_int($user_id) || $user_id == 0)
		{
			return null;
		}
		$search = "SELECT * FROM head2head WHERE `user_id` = '$user_id' AND `paired_challenge_id` = 0 AND WON = 0";
		return Head2head::getObjects($search);
	}
	
	public static function getActiveMatchedChallengesByUser($user_id)
	{
		$user_id = (int) $user_id;
		if(!is_int($user_id) || $user_id == 0)
		{
			return null;
		}
		$search = "SELECT * FROM head2head WHERE `user_id` = '$user_id' AND `paired_challenge_id` != 0 AND WON = 0";
		return Head2head::getObjects($search);
	}
	
	public static function deleteChallenge($game_id)	{
		$game_id = (int) $game_id;
		if(!is_int($game_id) || $game_id == 0)
		{
			return;
		}
	
		$delete = "DELETE FROM `head2head` WHERE `challenge_id` = $game_id";
		db_execute($delete);
	}
	
	
	public static function getHead2HeadAmountFromGame($game_id)
	{
		$game_id = (int) $game_id;
		if(!is_int($game_id) || $game_id == 0)
		{
			return 0;
		}
		
		$sum = "SELECT SUM(amount) FROM head2head WHERE `game_id` = $game_id";
		
		$result = db_execute($sum);
		while ($row = mysqli_fetch_assoc($result)) {
			$amount = $row["SUM(amount)"];
			if($amount > 0)
				return $amount;
		}
		return 0;
	}
	
	public static function getHead2HeadMatchedAmountFromGame($game_id)
	{
		$game_id = (int) $game_id;
		if(!is_int($game_id) || $game_id == 0)
		{
			return 0;
		}
		$sum = "SELECT SUM(amount) FROM head2head WHERE `game_id` = $game_id AND `paired_challenge_id` != 0";
		$result = db_execute($sum);
		
		while ($row = mysqli_fetch_assoc($result)) {
			$amount = $row["SUM(amount)"];
			if($amount > 0)
				return $amount;
		}
		return 0;
	}
	
	public static function getHead2HeadUnmatchedAmountFromGame($game_id)
	{
		$game_id = (int) $game_id;
		if(!is_int($game_id) || $game_id == 0)
		{
			return 0;
		}
		
		$sum = "SELECT SUM(amount) FROM head2head WHERE `game_id` = $game_id AND `paired_challenge_id` = 0";
		
		$result = db_execute($sum);
		while ($row = mysqli_fetch_assoc($result)) {
			$amount = $row["SUM(amount)"];
			if($amount > 0)
				return $amount;
		}
		return 0;
	}
	
	public static function getHead2HeadUnmatchedFromGame($game_id,$limit)
	{
		$game_id = (int) $game_id;
		if(!is_int($game_id) || $game_id == 0)
		{
			return null;
		}
		
		$search = "SELECT * FROM `head2head` WHERE `game_id` = $game_id AND `paired_challenge_id` = 0 LIMIT $limit";
		return Head2head::getObjects($search);
	}
	
	public static function getHead2HeadMatchedFromGame($game_id)
	{
		$game_id = (int) $game_id;
		if(!is_int($game_id) || $game_id == 0)
		{
			return null;
		}
		
		$search = "SELECT * FROM `head2head` WHERE `game_id` = '$game_id'";
		return Head2head::getObjects($search);
	}
	
	public static function updateFinishedChallenges($game_id)
	{
		$challenges = Head2head::getHead2HeadMatchedFromGame($game_id);
		$game = Game::getGameById($game_id);
		$winTeamId = $game->get_win_team_id();
		$loseTeamId = $game->get_lose_team_id();
		for($i = 0; $i< count($challenges); $i++)
		{
			if($challenges[$i]->get_team_id() == $winTeamId)
			{
				$challenges[$i]->set_won(1);
			}
			if($challenges[$i]->get_team_id() == $loseTeamId)
			{
				$challenges[$i]->set_won(-1);
			}
			$challenges[$i]->save();
		}
	}
	
	public static function getHead2HeadUnmatchedAmount()
	{
		$sum = "SELECT SUM(amount) FROM head2head WHERE `paired_challenge_id` = 0";
		
		$result = db_execute($sum);
		while ($row = mysqli_fetch_assoc($result)) {
			$amount = $row["SUM(amount)"];
			if($amount > 0)
				return $amount;
		}
		return 0;
	}
	
	public static function getHead2HeadMatchedAmount()
	{
		$sum = "SELECT SUM(amount) FROM head2head WHERE `paired_challenge_id` != 0";
		
		$result = db_execute($sum);
		while ($row = mysqli_fetch_assoc($result)) {
			$amount = $row["SUM(amount)"];
			if($amount > 0)
				return $amount;
		}
		return 0;
	}
	
	public static function getHead2HeadAmount()
	{
		$sum = "SELECT SUM(amount) FROM head2head";
		
		$result = db_execute($sum);
		while ($row = mysqli_fetch_assoc($result)) {
			$amount = $row["SUM(amount)"];
			if($amount > 0)
				return $amount;
		}
		return 0;
	}
	
	public static function getTopCharitiesByGame($game_id,$limit = 6)
	{
		$game_id = (int) $game_id;
		if(!is_int($game_id) || $game_id == 0)
		{
			return null;
		}
		
		$sql = "select charity_id, sum(amount) from `head2head` where `game_id` = $game_id GROUP BY `charity_id` ORDER BY sum(amount) DESC LIMIT $limit";
		$result = db_execute($sql);
		$objects = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$objects[$row['charity_id']] = $row['sum(amount)'];
		}
		return $objects;
	}
	
	public static function getFavoriteCharitiesByUser($user_id,$limit = 6)
	{
		$user_id = (int) $user_id;
		if(!is_int($user_id) || $user_id == 0 || !is_int($limit))
		{
			return null;
		}
		
		$sql = "select charity_id from `head2head` where `user_id` = $user_id GROUP BY `charity_id` ORDER BY sum(amount) DESC LIMIT $limit";
		$result = db_execute($sql);
		$objects = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$objects[] = Charity::getCharityById($row['charity_id']);
		}
		if($limit == 1 && isset($objects[0]))
			return $objects[0];
		return $objects;
	}
	
	public static function getPaidAmountByUser($user_id)
	{
		$user_id = (int) $user_id;
		if(!is_int($user_id) || $user_id == 0)
		{
			return 0;
		}
		
		$search = "SELECT sum(amount) FROM head2head WHERE `user_id` = '$user_id' AND `won` = '1' GROUP BY `user_id`";
		$result = db_execute($search);
		while ($row = mysqli_fetch_assoc($result)) {
			$amount = $row["sum(amount)"];
			if($amount > 0)
				return $amount;
		}
		return 0;
	}
	
	public static function getNumberWonByUser($user_id)
	{
		$user_id = (int) $user_id;
		if(!is_int($user_id) || $user_id == 0)
		{
			return 0;
		}
		
		$search = "SELECT count(challenge_id) FROM head2head WHERE `user_id` = '$user_id' AND `won` = '1' AND `paired_challenge_id` != 0";
		$result = db_execute($search);
		while ($row = mysqli_fetch_assoc($result)) {
			$amount = $row["count(challenge_id)"];
			if($amount > 0)
				return $amount;
		}
		return 0;
	}
	
	public static function getNumberLostByUser($user_id)
	{
		$user_id = (int) $user_id;
		if(!is_int($user_id) || $user_id == 0)
		{
			return 0;
		}
	
		$search = "SELECT count(challenge_id) FROM head2head WHERE `user_id` = '$user_id' AND `won` = '-1' AND `paired_challenge_id` != 0";
		$result = db_execute($search);
		while ($row = mysqli_fetch_assoc($result)) {
			$amount = $row["count(challenge_id)"];
			if($amount > 0)
				return $amount;
		}
		return 0;
	}
	
	public static function getFinishedChallengesByUser($user_id)
	{
		$user_id = (int) $user_id;
		if(!is_int($user_id) || $user_id == 0)
		{
			return null;
		}
		$search = "SELECT * FROM head2head WHERE `user_id` = '$user_id' AND `paired_challenge_id` != 0 AND won != 0";
		return Head2head::getObjects($search);
	}
	
	public static function getLostPairedChallengesByGame($game_id,$lostTeamId)
	{
		$game_id = (int) $game_id;
		if(!is_int($game_id) || $game_id == 0)
		{
			return null;
		}
		$search = "SELECT * FROM `head2head` WHERE `game_id` = '$game_id' AND `team_id` = $lostTeamId AND `paired_challenge_id` != 0";
		return Head2head::getObjects($search);
	}
	
}

?>