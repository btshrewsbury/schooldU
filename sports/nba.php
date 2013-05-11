 <?php
class NBA { 

	public function NBA() 
	{

    }
	
	public static function displayYearSpan() 
	{ 
		$sixMonthsUp = date("Y-m-d",strtotime("+2 weeks"));
		$sixMonthsDown = date("Y-m-d",strtotime("-1 days"));

		$games = Game::getGamesOverDateRangeInSport(2,"$sixMonthsDown","$sixMonthsUp");
		?>
		<center><img src='img/bracket_banner/nba_bracket_banner.png' style='height:25px'/></center>
		<br/>
		<!--<div class="well well-small">
		<h5>Game Search</h5>
		</div>-->
		<?
		for($i = 0; $i < count($games); $i++) {
			if($i % 2 == 0)
				echo "<div class='row-fluid'>";
				
			NBA::showGame($games[$i]);
			
			if($i % 2 == 1 || $i == count($games) - 1)
				echo "</div>";
		}
		
	}
	
	public static function showGame($game) {
		$gameId = $game->get_game_id();
		$awayTeamName = $game->get_away_team()->get_name();
		$awayTeamLogo = $game->get_away_team_logo();
		$homeTeamName = $game->get_home_team()->get_name();
		$homeTeamLogo = $game->get_home_team_logo();
		$date = $game->get_formatted_date();
		$time = $game->get_formatted_time();
		$homeScore = $game->get_home_team_score();
		$awayScore = $game->get_away_team_score();
		?>
		<div class="media span6" style="margin-top:8px; border-bottom: 1px rgb(215, 219, 230) solid;">
		<div class="pull-left" style="position:relative; height:44px; overflow:hidden;">
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
		<div class="pull-right" style="position:relative; height:44px; width: 60px; overflow:hidden; text-align:center; " >
			<h5><? echo($homeScore); ?> &#124; <? echo($awayScore); ?></h5>
			
		</div>
		  
		  
		<div class="media-body">
			<strong>
				<a href="game_details.php?gid=<? echo(($gameId));?>">
					<? echo($awayTeamName); ?> vs. <? echo($homeTeamName); ?>
				</a>
			</strong> 
			<br/>
			<span class="label"><? echo($date); ?></span> 
			<span class="label"><? echo($time); ?></span> 
			<?
			if($game->is_finished())
			{?>
				<span class="label">Final</span> 
			<?}?>
			
		</div>
	</div>
	<?}

}
?>