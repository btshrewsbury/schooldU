<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/scoreboard.php");

function displayGameOver($game)
{
	$homeTeamName = $game->get_home_team()->get_name();
	$homeTeamScore =$game->get_home_team_score();
	$awayTeamName =$game->get_away_team()->get_name();
	$awayTeamScore =$game->get_away_team_score();
	if($homeTeamScore > $awayTeamScore)
	{
		$homeTeamScore = "<span class='text-success'>$homeTeamScore</span>";
	} else {
		$awayTeamScore = "<span class='text-success'>$awayTeamScore</span>";
	}
	
	?>
	
	<div class="row-fluid">
		<div class="span5" style="text-align:center;">
			<h3><?echo("$homeTeamName");?></h3>
			<h1><?echo("$homeTeamScore");?></h1>
		</div>
		<div class="span2" style="text-align:center;">
			<br/><h1>FINAL</h1>
		</div>
		<div class="span5" style="text-align:center;">
			<h3><?echo("$awayTeamName");?></h3>
			<h1><?echo("$awayTeamScore");?></h1>
		</div>
	</div>
	
	
	
	
	<?
	
}



?>