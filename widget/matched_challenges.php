<?php
require_once('utility/account.php');

function displayMyMatchedChallenges() {
	$me = getMe();
	$h2hChallenges = $me->getActiveMatchedChallenges();
	echo("<hr/><h5>My Head 2 Head Challenges</h5>");
	if(count($h2hChallenges ) > 0)
	{
		foreach($h2hChallenges as $aChallenge)
		{
			displayMatchedChallenge($aChallenge);
		}
	} else {
		echo("You don't have any matched challenges.");
	}
}

function displayMatchedChallenge($challenge) {

	$opposingChallenge = $challenge->get_paired_challenge();
	$type = "head2head";
	$myName = getMe()->get_name();
	$opponent = $opposingChallenge->get_user();
	$opponentName = $opponent->get_name();
	$opponentImg = $opponent->get_profile_pic();
	$opponentCharityName = ucwords(strtolower($opposingChallenge->get_charity()->get_name()));
	$cid      = $challenge->get_challenge_id();
	$amount   = $challenge->get_amount();
	$myCharityName = ucwords(strtolower($challenge->get_charity()->get_name()));
	$winTeam  = $challenge->get_team();
	$loseTeam = $challenge->get_losing_team();
	$winTeamName  = $winTeam->get_name();
	$loseTeamName = $loseTeam->get_name();
	$homeTeamImg  = $winTeam->get_home_logo();
	$awayTeamImg = $loseTeam->get_away_logo();
	$winLabel = false;
	if($challenge->get_won() == 1)
		$winLabel = '<span class="label label-success">You Won!</span>';	
	if($challenge->get_won() == -1)
		$winLabel = '<span class="label label-error">You Lost!</span>';
	$link = "https://schooldu.com/game_details.php?gid=" . $challenge->get_game()->get_game_id();

	if(!isset($homeTeamImg) || !isset($awayTeamImg))
	{
		$homeTeamImg  =  $loseTeam->get_home_logo(); 
		$awayTeamImg = $winTeam->get_away_logo();
	}
	
	//$fbJsParam = '"' . $link . '","' . $name1 . '","' . $name2 . '","' .$amount. '","' .$winTeam. '","' .$loseTeam . '"';
	?>
	
	<div class="media" id="<?echo($type . $cid);?>" style="overflow:visible;">
		<div class="pull-left">
			<a href="#">
				<img src="<?echo($awayTeamImg);?>" alt="<?echo($loseTeamName);?>"/><img src="<?echo($homeTeamImg);?>" alt="<?echo($winTeamName);?>"/>
			</a>
		</div>
		
		<div class="pull-left">
			<img src ="<?echo($opponentImg);?>" alt="<?echo($opponentName);?>"/>
		</div>
		  
		<div class="media-body" style="overflow:visible;">
			<h5><strong style="color:red;">$<? echo($amount); ?> </strong> <? echo("$myName vs. $opponentName " ); ?><? if($winLabel != false) echo($winLabel);?><br />
			<span class="label label-info">You have <?echo($winTeamName);?> for the win paired with "<? echo($myCharityName);?>"</span><br/>
			<span class="label"><?echo("$opponentName: ");?> has <?echo($loseTeamName);?> for the win paired with "<? echo($opponentCharityName);?>"</span><br/>
			</h5>

			
			<ul class="nav nav-pills" >

				<li><a href="#" onClick='Closed_H2H_Fb_Post_To_Wall(<?echo($fbJsParam);?>)' ><i class="icon-thumbs-up"></i> Facebook Wall</a></li>
				<li><a href="#" onClick='Closed_H2H_Fb_send_Message(<?echo($fbJsParam);?>)' ><i class="icon-envelope"></i> Facebook Message</a></li>
				<li><a href="<?echo($link);?>"><i class="icon-bullhorn"></i> View Game</a></li>
				
			</ul>
		</div>
	</div>
<?}

function displayMyCompletedMatchedChallenges(){
	$me = getMe();
	
	$h2hChallenges = $me->getFinishedH2HChallenges();
	echo("<h5>My Completed Head 2 Head Challenges</h5>");
	if(count($h2hChallenges ) > 0)
	{
		foreach($h2hChallenges as $aChallenge)
		{
			displayMatchedChallenge($aChallenge);
		}
	} else {
		echo("You don't have any completed matched challenges.");
	}
}

?>