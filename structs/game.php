<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/db.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/team.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/head2head.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/pool.php");

class Game { 

	private $game_id;
	private $date;
	private $time;
	private $home_team_id;
	private $away_team_id;
	private $home_team;
	private $away_team;
	private $stadium;
	private $is_finished;
	private $home_team_score;
	private $away_team_score;
	
	 public function Game($row) 
	{
        if(isset($row))
		{
			$this->game_id= $row['game_id'];
			$this->date= $row['date'];
			$this->time= $row['time'];
			$this->home_team_id= $row['home_team_id'];
			$this->away_team_id= $row['away_team_id'];
			$this->stadium= $row['stadium'];
			$this->is_finished= $row['is_finished'];
			$this->home_team_score= $row['home_team_score'];
			$this->away_team_score= $row['away_team_score'];
		}
    }
	
	public function get_game_id() { return $this->game_id; }
	public function get_date(){ return $this->date; }
	public function get_formatted_date()
	{ 	$formattedDate = explode ("-",$this->date); 
		$formattedDate = $formattedDate[1] . "/" . $formattedDate[2] . "/" . $formattedDate[0];
		return $formattedDate;
	}
	public function get_time(){ return $this->time; }
	public function get_formatted_time()
	{ 	$formattedTime = explode (":",$this->time); 
		$hour = intval($formattedTime[0]);
		$period = ($hour > 12) ? "PM" : "AM";
		$hour = abs($hour - 12);
		$formattedTime = $hour . ":" . $formattedTime[1] . $period;
		return $formattedTime;
	}
	public function get_home_team_id(){ return $this->home_team_id; }
	public function get_away_team_id(){ return $this->away_team_id; }
	public function get_stadium(){ return $this->stadium; }
	public function is_finished(){ return $this->is_finished == 1; }
	public function get_home_team_score(){ return $this->home_team_score; }
	public function get_away_team_score(){ return $this->away_team_score; }
	public function get_away_team_logo(){ return $this->get_away_team()->get_away_logo(); }
	public function get_home_team_logo(){ return $this->get_home_team()->get_home_logo(); }
	public function get_unmatched_challenges($limit){ return Head2Head::getHead2HeadUnmatchedFromGame($this->game_id,$limit); }

	public function get_other_team($teamId)
	{
		if($teamId == $this->home_team_id)
			return $this->get_away_team();		
		if($teamId == $this->away_team_id)
			return $this->get_home_team();
	}
	
	public function get_pooled_amount(){ return Pool::getPooledAmountFromGame($this->game_id); }
	public function get_head2head_amount(){ return Head2Head::getHead2HeadAmountFromGame($this->game_id); }
	public function get_head2head_amount_matched(){ return Head2Head::getHead2HeadMatchedAmountFromGame($this->game_id); }
	public function get_head2head_amount_unmatched(){ return Head2Head::getHead2HeadUnmatchedAmountFromGame($this->game_id); }
	public function get_top_charities($limit){ return Head2Head::getTopCharitiesByGame($this->game_id,$limit); }
	
	public function get_win_team_Id()
	{
		if($this->is_finished())
		{	
			if($this->get_home_team_score() > $this->get_away_team_score())
			{
				return $this->get_home_team_id();
			}
			return $this->get_away_team_id();
		}
		return null;
	}
	
	public function get_win_team()
	{
		if($this->is_finished())
		{	
			if($this->get_home_team_score() > $this->get_away_team_score())
			{
				return $this->get_home_team();
			}
			return $this->get_away_team();
		}
		return null;
	}
	
	public function get_lose_team_id()
	{
		if($this->is_finished())
		{	
			if($this->get_home_team_score() < $this->get_away_team_score())
			{
				return $this->get_home_team_id();
			}
			return $this->get_away_team_id();
		}
		return null;
	}
	
	public function get_lose_team()
	{
		if($this->is_finished())
		{	
			if($this->get_home_team_score() < $this->get_away_team_score())
			{
				return $this->get_home_team();
			}
			return $this->get_away_team();
		}
		return null;
	}
	
	
	public function get_home_team(){ 
		if(!isset($this->home_team))
		{
			$result = Team::getTeamById($this->home_team_id);
			$this->home_team = $result;
		}
		return $this->home_team; 
	}
	
	public function get_away_team(){ 
		if(!isset($this->away_team))
		{
			$result = Team::getTeamById($this->away_team_id);
			$this->away_team = $result;
		}
		return $this->away_team; 
	}
	
	public function set_date($val){ $this->date = $val; }
	public function set_time($val){ $this->time = $val; }
	public function set_home_team_id($val){ $this->home_team_id = $val; }
	public function set_away_team_id($val){ $this->away_team_id = $val; }
	public function set_stadium($val){ $this->stadium = $val; }
	public function set_is_finished($val){ $this->is_finished = $val; }
	public function set_home_team_score($val){ $this->home_team_score = $val; }
	public function set_away_team_score($val){ $this->away_team_score = $val; }
	
	public function gameOver()
	{
		Head2Head::updateFinishedChallenges($this->game_id);
		$this->set_is_finished(1);
		$this->save();
	}
	
	public function delete(){
		 Game::deleteGame($this->game_id);
	 }	
	 
	public function save()
	{
		if(!isset($this->game_id))
		{
			$this->create();
		} else {
			$this->update();
		}
	}
	
	private function create()
	{
		$date = filter_var($this->date, FILTER_SANITIZE_NUMBER_INT);
		$time = filter_var($this->time, FILTER_SANITIZE_STRING);
		$home_team_id = (int) $this->home_team_id;
		$away_team_id = (int) $this->away_team_id;
		$stadium = filter_var($this->stadium, FILTER_SANITIZE_STRING);
		$is_finished = (int) $this->is_finished;
		$home_team_score = (int) $this->home_team_score;
		$away_team_score = (int) $this->away_team_score;
		
		$createGame = "INSERT INTO `game` (`date`, `time`, `home_team_id`, `away_team_id`, `stadium`, `is_finished`, `home_team_score`, `away_team_score`) 
						VALUES ('$date','$time','$home_team_id','$away_team_id','$stadium','$is_finished','$home_team_score','$away_team_score')";
		$result = db_execute($createGame);
		$this->game_id = getLastId();
	}
	
	private function update()
	{
		$game_id = (int) $this->game_id;
		$date = filter_var($this->date, FILTER_SANITIZE_NUMBER_INT);
		$time = filter_var($this->time, FILTER_SANITIZE_STRING);
		$home_team_id = (int) $this->home_team_id;
		$away_team_id = (int) $this->away_team_id;
		$stadium = filter_var($this->stadium, FILTER_SANITIZE_STRING);
		$is_finished = (int) $this->is_finished;
		$home_team_score = (int) $this->home_team_score;
		$away_team_score = (int) $this->away_team_score;
		
		$updateGame = "UPDATE `game` SET `date` = '$date', `time` = '$time', `home_team_id` = '$home_team_id', `away_team_id` = '$away_team_id', 
					`stadium` = '$stadium', `is_finished` = '$is_finished', `home_team_score` = '$home_team_score', 
					`away_team_score` = '$away_team_score' WHERE `game_id` = '$game_id'";
		$result = db_execute($updateGame);
	}
	
	public static function getObjects($sql)
	{
		$result = db_execute($sql);
		$objects = array();
		while ($row = mysqli_fetch_assoc($result)) {
			if($row != null)
				$objects[] = new Game($row);
		}
		return $objects;
	}
	
	public static function getGames($limit,$active)
	{
		
		$gameSearch = "SELECT * FROM game ORDER BY `date` DESC";
		if(isset($limit))
		{
			$limit = (int) $limit;
			$gameSearch .= " LIMIT $limit"; 
		}
		
		if(isset($active))
		{
			$gameSearch .= " WHERE `date` >= CURDATE()"; 
		}

		return Game::getObjects($gameSearch);
	}

	public static function getAllGames($active)
	{
		$gameSearch = "SELECT * FROM game";
		
		if(isset($active))
		{
			$gameSearch .= " WHERE `date` >= CURDATE()"; 
		}
		return Game::getObjects($gameSearch);
	}

	public static function getGameById($game_id)
	{
		$game_id = (int) $game_id;
		if(!is_int($game_id) || $game_id == 0)
			return null;
			
		$gameSearch = "SELECT * FROM game WHERE `game_id` = $game_id LIMIT 1";
		$games = Game::getObjects($gameSearch);
		if(count($games) > 0)
			return $games[0];
		return null;
	}
	
	public static function getGameByIdAndSportId($game_id,$sport_id)
	{
		$game_id = (int) $game_id;
		$sport_id = (int) $sport_id;
		
		if(!is_int($game_id) || $game_id == 0 || !is_int($sport_id) || $sport_id == 0)
			return null;
			
		$gameSearch = "SELECT * FROM game WHERE `game_id` = $game_id AND `sport_id` = '$sport_id' LIMIT 1";
		$games = Game::getObjects($gameSearch);
		if(count($games) > 0)
			return $games[0];
		return null;
	}

	public static function getGamesByTeamIds($team1,$team2,$active)
	{
		$team1 = (int) $team1;
		$team2 = (int) $team2;
		if(!is_int($team1) || !is_int($team2) || $team1 == 0 || $team2 == 0)
			return null;
			
		$gameSearch = "SELECT * FROM game WHERE (`home_team_id` = $team1 AND `away_team_id` = $team2) OR (`home_team_id` = $team2 AND `away_team_id` = $team1)";
		
		if(isset($active))
		{
			$gameSearch .= " AND `date` >= CURDATE()"; 
		}

		return Game::getObjects($gameSearch);
	}

	public static function getGamesByTeamId($team_id,$active)
	{
		$team_id = (int) $team_id;
		if(!is_int($team_id) || $team_id == 0)
			return null;
			
		$gameSearch = "SELECT * FROM game WHERE `home_team_id` = $team_id OR `away_team_id` = $team_id";
		
		if(isset($active))
		{
			$gameSearch .= " AND `date` >= CURDATE()"; 
		}

		return Game::getObjects($gameSearch);
	}

	public static function getGamesOnDate($date)
	{
		if(!isset($date))
			return null;
		
		$date = filter_var($date, FILTER_SANITIZE_NUMBER_INT);
	
		$gameSearch = "SELECT * FROM game WHERE `date` = $date";
		return Game::getObjects($gameSearch);
	}
	
	public static function getGamesOverDateRange($startDate,$endDate)
	{
		if(!isset($startDate) || !isset($endDate))
			return null;
		
		$startDate = filter_var($startDate, FILTER_SANITIZE_NUMBER_INT);
		$endDate = filter_var($endDate, FILTER_SANITIZE_NUMBER_INT);

		$gameSearch = "SELECT * FROM game WHERE `date` >= '$startDate' AND `date` <= '$endDate'";
		return Game::getObjects($gameSearch);
	}
	
	public static function getGamesOverDateRangeInSport($sport_id,$startDate,$endDate)
	{
		if(!isset($startDate) || !isset($endDate))
			return null;
		
		$startDate = filter_var($startDate, FILTER_SANITIZE_NUMBER_INT);
		$endDate = filter_var($endDate, FILTER_SANITIZE_NUMBER_INT);

		$gameSearch = "SELECT * FROM game WHERE `date` >= '$startDate' AND `date` <= '$endDate' AND `sport_id` = '$sport_id'";
		return Game::getObjects($gameSearch);
	}

	public static function deleteGame($id)	{
		$id = (int) $id;
		if(!is_int($id) || $id == 0)
			return;
		
		$delete = "DELETE FROM `game` WHERE `game_id` = $id";
		db_execute($delete);
	}

} 

?>