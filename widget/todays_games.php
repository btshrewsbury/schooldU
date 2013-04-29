<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/game.php");

function showGames() {
	$games = Game::getGames(6,null);
	for($i = 0; $i < count($games); $i++) {
		displayGame($games[$i]);
	}
}

function displayGame($game) {
	$gameId = $game->get_game_id();
	$awayTeamName = $game->get_away_team()->get_name();
	$awayTeamLogo = $game->get_away_team_logo();
	$homeTeamName = $game->get_home_team()->get_name();
	$homeTeamLogo = $game->get_home_team_logo();
	$awayTeamScore = $game->get_away_team_score();
	$homeTeamScore = $game->get_home_team_score();
	$date = explode('-',$game->get_date());
	$date = $date[1] . '/' . $date[2];

	?>
	
	<div class="media" style="margin-top:0px; border-bottom: 1px rgb(215, 219, 230) solid;"> 
		<!--<div class="pull-right" >
			Score: <?echo("$homeTeamScore | $awayTeamScore");?>
		</div>-->
		<div class="media-body">
				<strong><a class="titleLink" href="game_details.php?gid=<? echo(($gameId));?>"><? echo("$date - $homeTeamName vs. $awayTeamName"); ?></a></strong>
		</div>
		
	</div>
<?}
?>	
	
	<div class="span4 gamesTile dropshadow" id="taxDeductibleTile">
		<div id="taxDeductibleTileInner">
			<?showGames();?>
		</div>
	</div>