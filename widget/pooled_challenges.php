<?php
require_once('utility/account.php');

function displayMyPooledChallenges() {
	$me = getMe();	
	$poolChallenges = $me->getActivePoolededChallenges();
	echo("<hr/><h5>My Pooled Challenges</h5>");
	if(count($poolChallenges ) > 0)
	{
		foreach($poolChallenges as $aChallenge)
		{
			displayPooledChallenge($aChallenge);
		}
	} else {
		echo("You haven't joined any Pools.");
	}	
}

function displayMyCompletedPooledChallenges(){
	$me = getMe();
	$poolChallenges = $me->getFinishedPoolededChallenges();
	echo("<hr/><h5>My Completed Pooled Challenges</h5>");
	if(count($poolChallenges ) > 0)
	{
		foreach($poolChallenges as $aChallenge)
		{
			displayPooledChallenge($aChallenge);
		}
	} else {
		echo("You don't have any completed Pool challenges.");
	}	
}

function displayPooledChallenge($challenge) {
	$type = "activePool";
	$name = getMe()->get_name();
	$cid      = $challenge->get_challenge_id();
	$amount   = $challenge->get_amount();
	//$charityName = ucwords(strtolower($challenge->get_charity()->get_name()));
	$game = $challenge->get_game();
	$homeTeam  = $game->get_home_team();
	$awayTeam = $game->get_away_team();

	$homeTeamName  = $homeTeam->get_name();
	$awayTeamName = $awayTeam->get_name();
	$homeTeamImg  = $homeTeam->get_home_logo();
	$awayTeamImg = $awayTeam->get_away_logo();
	$link = "https://schooldu.com/game_details.php?gid=" . $game->get_game_id();
	
	if(!isset($homeTeamImg) || !isset($awayTeamImg))
	{
		$homeTeamImg  =  $awayTeam->get_home_logo(); 
		$awayTeamImg = $homeTeam->get_away_logo();
	}
	$resultSpan = "";
	if($game->is_finished())
	{
		$winTeam = $game->get_win_team();
		$winTeamCharityName = $winTeam->get_school()->get_charity()->get_name();
		$resultSpan = "<span class='label label-success'>$$amount Paid to $winTeamCharityName</span>";
	
	} else {
		$deleteIcon = "<li><a href='#' onClick='deleteChallenge(\"$type\",\"$cid\")'><i class='icon-trash'></i> Delete Challenge</a></li>";
	}
	$fbMsgParam = "'',poolLink_$cid,poolTitle_$cid,poolMsg_$cid";
	
	?>
	<script>
		var <?echo("poolMsg_$cid = \"$name put down $$amount.00 for Charity. The $$amount goes to the Charity SchooldU has paired with the winning team. Are you up for the challenge?\";");?>
		var <?echo("poolLink_$cid = \"$link\";");?>
		var <?echo("poolTitle_$cid  = \"Join the SchooldU Donation Challenge\";");?>	
	</script>
	
	<div class="media" style="margin:4px;" id="<?echo($type . $cid);?>" style="overflow:visible;">
		<div class="pull-left">
			<a href="#">
				<img src="<?echo($awayTeamImg);?>" alt="<?echo($loseTeamName);?>"/><img src="<?echo($homeTeamImg);?>" alt="<?echo($winTeamName);?>"/>
			</a>
		</div>
		  
		<div class="media-body" style="overflow:visible;">
			<h5 style="margin:0px"><span style="color:red;">$<? echo($amount ); ?> </span> In the <?echo("$homeTeamName vs $awayTeamName");?> Pool. <?echo($resultSpan);?></h5>  
			<ul class="nav nav-pills" style="margin-bottom:0px;">
				<li><a href="#" onClick="sendFbMessage(<?echo($fbMsgParam);?>)" ><i class="icon-envelope"></i> Facebook Message</a></li>
				<li><a href="<?echo($link);?>"><i class="icon-bullhorn"></i> View Game</a></li>
				<?echo($deleteIcon);?>
			</ul>
		</div>
	</div>
<?
}
?>