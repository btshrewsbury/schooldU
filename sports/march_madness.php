<?php
$sid = session_id();
if(!isset($sid)) {
    session_start();
}
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/game.php");

function display_mm()
{
	echo('<div class="span4">');
	show_mm_Games();
	echo('</div>');
}

function show_mm_Games() {
	$fourWeeksAhead = date("n-j-y",strtotime("+4 week"));
	$twoWeeksAgo = date("n-j-y",strtotime("-2 week"));
	$games = Game::getGames(64,null);
	$games = Game::getGamesOverDateRange("2013-03-25","2013-03-30");
	
	
	$columnSize = floor(count($games) / 2) ;

	for($i = 0; $i < count($games); $i++) {
		if($i %4 == 0)
		{
			echo('<br/>');
		}
		if( $i < $columnSize )
		{
			display_mm_LHGame($games[$i]);
			
			if($i == $columnSize - 1)
			{
				echo('<br/></div>');
				echo('<div class="span4" style="text-align:center;">
				<img src="img/bracket_banner/cb_bracket_banner.png" alt="March Madness Round 1"/></div>');
				echo('<div class="span4">');
			}
		}
		
		else
		{
			display_mm_RHGame($games[$i]);
		}
    }
}

function display_mm_LHGame($game) {
	$gameId = $game->get_game_id();
	$awayTeamName = $game->get_away_team()->get_name();
	$awayTeamLogo = $game->get_away_team_logo();
	$homeTeamName = $game->get_home_team()->get_name();
	$homeTeamLogo = $game->get_home_team_logo();
	
	?>
	
	<div class="media" style="margin-top:8px; border-bottom: 1px rgb(215, 219, 230) solid;">
		<div class="pull-left" style="position:relative; width:128px; height:44px; overflow:hidden;">
			<div style="float:left; position:relative; width:64px; overflow:hidden;">
				<a href="game_details.php?gid=<? echo($gameId);?>">
					<img src ="<?echo($awayTeamLogo);?>" width="64" height="64" alt="<? echo($awayTeamName); ?>"/>
				</a>
			</div>
			<div style="float:left; position:relative; width:64px; overflow:hidden;">
				<a href="game_details.php?gid=<? echo($gameId);?>">
					<img src ="<?echo($homeTeamLogo);?>" width="64" height="64" alt="<? echo($homeTeamName); ?>"/>
				</a>
			</div>
		</div>
		  
		  
		<div class="media-body">
			<strong><a href="game_details.php?gid=<? echo(($gameId));?>"><? echo($awayTeamName); ?></a></strong>
			<br/>
			<strong><a href="game_details.php?gid=<? echo(($gameId));?>"><? echo($homeTeamName); ?></a></strong> 
		</div>
	</div>
<?}

function display_mm_RHGame($game) {

	$gameId = $game->get_game_id();
	$awayTeamName = $game->get_away_team()->get_name();
	$awayTeamLogo = $game->get_away_team_logo();
	$homeTeamName = $game->get_home_team()->get_name();
	$homeTeamLogo = $game->get_home_team_logo();
	
	?>
	
	<div class="media" style="margin-top:8px; border-bottom: 1px rgb(215, 219, 230) solid;">
		<div class="pull-right" style="position:relative; width:128px; height:44px; overflow:hidden;">
			<div style="float:left; position:relative; width:64px; overflow:hidden;">
				<a href="game_details.php?gid=<? echo(($gameId));?>">
					<img src ="<?echo($awayTeamLogo);?>" width="64" height="64" alt="<? echo($awayTeamName); ?>"/>
				</a>
			</div>
			<div style="float:left; position:relative; width:64px; overflow:hidden;">
				<a href="game_details.php?gid=<? echo(($gameId));?>">
					<img src ="<?echo($homeTeamLogo);?>" width="64" height="64" alt="<? echo($homeTeamName); ?>"/>
				</a>
			</div>
		</div>
		  
		  
		<div class="media-body" style="text-align:right">
			<strong><a href="game_details.php?gid=<? echo($gameId);?>"><? echo($awayTeamName); ?></a></strong>
			<br/>
			<strong><a href="game_details.php?gid=<? echo($gameId);?>"><? echo($homeTeamName); ?></a></strong>
		</div>
	</div>
<?}?>

