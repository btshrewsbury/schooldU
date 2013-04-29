<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/db.php");
require_once('lib/nusoap.php');
$client = new nusoap_client('http://services.chalkgaming.com/ChalkServices.asmx?WSDL', 'wsdl');
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$params = array('Username'=>'bshrewsbury','Password'=>'bSh1012','Sport'=>'Basketball','League'=>'NBA');
$result = $client->call('MatchupList', $params);

$MatchupListResult = $result['MatchupListResult'];
$ResultSet = $MatchupListResult['ResultSet'];
$Matchups = $ResultSet['Matchups'];
$games = $Matchups['Game'];


foreach($games as $game)
{
	filter_var($local_email, FILTER_SANITIZE_STRING);

	foreach($game as $key => &$value) {
	   $value = filter_var($value, FILTER_SANITIZE_STRING);
   }

	$search = "SELECT * FROM `team` WHERE `team_id` = " . $game['AwayTeamId'] . " LIMIT 1";
	$result = db_execute($search);
	if(mysqli_num_rows($result) > 0)
	{
		$updateTeam = "UPDATE `team` SET `away_logo` = '" . $game["AwayLogo"] . "' WHERE `team_id` = " . $game['AwayTeamId'] . " AND `sport_id` = 2";
		$result = db_execute($updateTeam);
	} else {
		$create = "INSERT INTO `team` (`team_id`,`name`,`away_logo`,`sport_id`,`school_id`) VALUES (" . $game['AwayTeamId'] . ",'" . $game["AwayTeam"] . "','" . $game["AwayLogo"] . "',2,1)";
		$result = db_execute($create);
	}
	
	$search = "SELECT * FROM team WHERE `team_id` = " . $game['HomeTeamId'] . " AND `sport_id` = 2 LIMIT 1";
	$result = db_execute($search);
	if(mysqli_num_rows($result) > 0)
	{
		$updateTeam = "UPDATE `team` SET `home_logo` = '" . $game["HomeLogo"] . "' WHERE `team_id` = " . $game['HomeTeamId'] . " AND `sport_id` = 2";
		$result = db_execute($updateTeam);
	} else {
		$create = "INSERT INTO `team` (`team_id`,`name`,`home_logo`,`sport_id`,`school_id`) VALUES (" . $game['HomeTeamId'] . ",'" . $game["HomeTeam"] . "','" . $game["HomeLogo"] . "',2,1)";
		$result = db_execute($create);
	}

	$date = explode('/',$game["GameDate"]);
	$date = $date[2] . '-' . $date[0] . '-' . $date[1];
	
	
	$search = "SELECT * FROM game WHERE `game_id` = " . $game['GameId'] . " LIMIT 1";
	$result = db_execute($search);
	if(mysqli_num_rows($result) > 0)
	{
		$updateGame = "UPDATE `game` SET `date` = '$date', `time` = '" . $game["GameTime"] . "', `home_team_id` = '" . $game["HomeTeamId"] . "', `away_team_id` = '" . $game["AwayTeamId"] . "', `stadium` = '" . $game["Stadium"] . "' WHERE `game_id` = " . $game['GameId'];
		$result = db_execute($updateGame);
	} else {
		$createGame = "INSERT INTO `game` (`game_id`, `date`, `time`, `home_team_id`, `away_team_id`, `stadium`, `sport_id`) VALUES (" . $game["GameId"] . ",'" . $date . "','" . $game["GameTime"] . "','" . $game["HomeTeamId"] . "','" . $game["AwayTeamId"] . "','" . $game["Stadium"] . "','2')";
		echo($createGame);
		$result = db_execute($createGame);
	}
}
echo "FINISHED!";
?>
