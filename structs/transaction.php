<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/db.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/head2head.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/pool.php");

class Transaction { 

	private $transaction_id;
	private $user_id;
	private $h2h_challenge_id;
	private $pool_challenge_id;
	private $charity_id;
	private $paid;
	
	 public function Transaction($row) 
	{
        if(isset($row)){
			$this->transaction_id= $row['transaction_id'];
			$this->user_id= $row['user_id'];
			$this->h2h_challenge_id= $row['h2h_challenge_id'];
			$this->pool_challenge_id = $row['pool_challenge_id'];
			$this->charity_id = $row['charity_id'];
			$this->paid = $row['paid'];
		}
    }
	
	public function get_transaction_id() { return $this->transaction_id; }
	public function get_user_id(){ return $this->user_id; }
	public function get_user()
	{ 
		return User::getUserById($this->user_id);
	}
	public function get_h2h_challenge_id(){ return $this->h2h_challenge_id; }
	public function get_amount()
	{ 
		if($this->get_h2h_challenge_id() != 0)
			return Head2head::getChallengeById($this->h2h_challenge_id)->get_amount();
		else
			return Pool::getChallengeById($this->pool_challenge_id)->get_amount();
	}
	public function get_pool_challenge_id(){ return $this->pool_challenge_id; }
	public function get_charity_id(){ return $this->charity_id; }
	public function get_paid(){ return $this->paid; }
	
	public function set_user_id($val){ $this->user_id = $val; }
	public function set_h2h_challenge_id($val){ $this->h2h_challenge_id = $val; }
	public function set_pool_challenge_id($val){ $this->pool_challenge_id = $val; }
	public function set_charity_id($val){ $this->charity_id = $val; }
	public function set_paid($val){$this->paid = $val; }
	
	public function save()
	{
		if(!isset($this->transaction_id))
		{
			$this->create();
		} else {
			$this->update();
		}
	}
	
	private function create()
	{
		$user_id = (int) $this->user_id; 
		$h2h_challenge_id = (int) $this->h2h_challenge_id; 
		$pool_challenge_id = (int) $this->pool_challenge_id; 
		$charity_id = (int) $this->charity_id; 
		$paid = (int) $this->paid;
		
		$create = "INSERT INTO `transaction` (`user_id`, `h2h_challenge_id`, `pool_challenge_id`,`charity_id`,`paid`) VALUES ('$user_id','$h2h_challenge_id','$pool_challenge_id','$charity_id','$paid')";
		$result = db_execute($create);
		$this->transaction_id = getLastId();
	}
	
	private function update()
	{
		$user_id = filter_var($this->user_id, FILTER_SANITIZE_STRING); 
		$h2h_challenge_id = filter_var($this->h2h_challenge_id, FILTER_SANITIZE_STRING); 
		$pool_challenge_id = filter_var($this->pool_challenge_id, FILTER_SANITIZE_STRING); 
		$paid = (int) $this->paid;
		$charity_id = (int) $this->charity_id; 
		$transaction_id = (int) $this->transaction_id;
		
		$update = "UPDATE `transaction` SET `user_id` = '$user_id', `h2h_challenge_id` = '$h2h_challenge_id', `pool_challenge_id` = '$pool_challenge_id', `charity_id` = '$charity_id', `paid` = '$paid' WHERE `transaction_id` = '$transaction_id'";
		$result = db_execute($update);
	}
	
	public static function getObjects($sql)
	{
		$result = db_execute($sql);
		$objects = array();
		while ($row = mysqli_fetch_assoc($result)) {
			$objects[] = new Transaction($row);
		}
		return $objects;
	}
	
	public static function getTransactionById($transaction_id)
	{
		$transaction_id = (int) $transaction_id;
		if(!is_int($transaction_id) || $transaction_id == 0)
		{
			return null;
		}
		
		$search = "SELECT * FROM transaction WHERE `transaction_id` = '$transaction_id' LIMIT 1";
		$result = Transaction::getObjects($search);
		if(count($result) > 0)
			return $result[0];
		return null;
	}
	
	public static function getTransactions()
	{
		$search = "SELECT * FROM transaction";
		return Transaction::getObjects($search);
	}
	
	public static function getUnpaidTransactions()
	{
		$search = "SELECT * FROM transaction WHERE `paid` = 0";
		return Transaction::getObjects($search);
	}
	
	public static function ProcessUnpaidTransactions()
	{
		$transactions = Transaction::getUnpaidTransactions();
		for($i = 0; $i < count($transactions); $i++)
		{
			$charityId = $transactions[$i]->get_charity_id();
			$stripeKey = $transactions[$i]->get_user()->get_stripe_id();
			$amount = $transactions[$i]->get_amount();
			
			payViaStripe($stripeKey,$charityId,$amount);
			$transactions[$i]->set_paid(1);
			$transactions[$i]->save();
		}
	}
	
	public static function createTransactionsFromGameEnd($gameId)
	{
		$game = Game::getGameById($gameId);
		$loser_id = $game->get_lose_team_id();
		$transactions = array();
		$pooledCharityId = $game->get_win_team()->get_school()->get_charity_id();
		
		$pooledGames = Pool::getChallengesByGame($gameId);
		for($i = 0; $i < count($pooledGames); $i++)
		{
			$aTransaction = new Transaction(null);
			$aTransaction->set_user_id($pooledGames[$i]->get_user_id());
			$aTransaction->set_pool_challenge_id($pooledGames[$i]->get_challenge_id());
			$aTransaction->set_charity_id($pooledCharityId);
			$aTransaction->set_paid(0);
			$aTransaction->save();
			$transactions[] = $aTransaction;
		}
		
		$lostH2HGames = Head2Head::getLostPairedChallengesByGame($gameId,$loser_id);
		
		for($i = 0; $i < count($lostH2HGames); $i++)
		{
			$winnerCharityId = $lostH2HGames[$i]->get_paired_challenge()->get_charity_id();
			$aTransaction = new Transaction(null);
			$aTransaction->set_user_id($lostH2HGames[$i]->get_user_id());
			$aTransaction->set_h2h_challenge_id($lostH2HGames[$i]->get_challenge_id());
			$aTransaction->set_charity_id($winnerCharityId);
			$aTransaction->set_paid(0);
			$aTransaction->save();
			$transactions[] = $aTransaction;
		}
		return $transactions;
	}
	
	
	
	public static function deleteTransaction($id)	{
		$id = (int) $id;
		if(!is_int($id) || $id == 0)
		{
			return null;
		}
		$delete = "DELETE FROM `transaction` WHERE `transaction_id` = $id";
		db_execute($delete);
	}
}
?>