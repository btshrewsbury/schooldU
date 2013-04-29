<?
function showScores($game)
{
	$homeTeamName = $game->get_home_team()->get_name();
	$homeTeamScore =$game->get_home_team_score();
	$awayTeamName =$game->get_away_team()->get_name();
	$awayTeamScore =$game->get_away_team_score();
	
	echo("$homeTeamName: $homeTeamScore | $awayTeamName: $awayTeamScore");
}


?>