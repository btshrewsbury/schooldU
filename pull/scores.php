<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/db.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/payment/processStripe.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/transaction.php");
require_once('lib/nusoap.php');



$client = new nusoap_client('http://services.chalkgaming.com/ChalkServices.asmx?WSDL', 'wsdl');
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
$today = date("n-j-y",strtotime("+1 day"));
$weekAgo = date("n-j-y",strtotime("-6 days"));
$params = array('Username'=>'bshrewsbury','Password'=>'bSh1012','Sport'=>'Basketball','League'=>'NBA','StartDate'=>$weekAgo,'EndDate'=>$today);
$result = $client->call('Scoreboard', $params);
$Scoreboard = $result['ScoreboardResult'];
$ResultSet = $Scoreboard['ResultSet'];
$Scoreboard = $ResultSet['Scoreboard'];
$games = $Scoreboard['Game'];

//var_dump($games);
foreach($games as $game)
{
	$gameId = $game['GameId'];
	$aGame = Game::getGameByIdAndSportId($gameId,2);
	
	if(isset($aGame))
	{
		$finished = ($game['Status'] == "Final" ? 1 : 0);
		$homeScore = $game['HomeScore'];
		$awayScore = $game['AwayScore'];
		$aGame->set_away_team_score($awayScore);
		$aGame->set_home_team_score($homeScore);
		
		echo("<br/>updated game $gameId");
		
		if(!$aGame->is_finished() && $finished == 1)
		{
			$aGame->gameOver();
			Transaction::createTransactionsFromGameEnd($gameId);
			echo(" - <b>ended!</b>");
		}
	}
}
Transaction::ProcessUnpaidTransactions();
echo "<br/>FINISHED!";
?>
