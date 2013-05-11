<?php
require_once('utility/account.php');

function showUnmatchedChallenges($game)
{
	$challenges = $game->get_unmatched_challenges(6);
	if(count($challenges) > 0)
	{
		foreach($challenges as $challenge)
		{
			$user = $challenge->get_user();
			$charity_name = $challenge->get_charity()->get_name();
			$amount = $challenge->get_amount();
			$win_team_name = $challenge->get_team()->get_name();
			$descrip = "$$amount on $win_team_name for $charity_name";//
			$link = "https://schooldu.com/game_details.php?cid=" . $challenge->get_challenge_id();
			displayMiniUnmatchedChallenge($link,$user->get_profile_pic(),$user->get_name(),$descrip);
		}
	} else {
		echo("<strong>No Umatched Challenges!</strong>");
	}
}

function displayMiniUnmatchedChallenge($link,$profile_pic,$name,$descrip)
{
?>
	<div class="media">
	  <div class="pull-left">
		<img src="<?echo($profile_pic);?>">
	  </div>
	  <div class="media-body">
		<h5 class="media-heading"><?echo($name);?> <a href="<?echo($link);?>"><span class="label label-info">View Challenge</span></a> </h5>
		<?echo($descrip);?>
		
	  </div>
	</div>
<?
}


function displayMyUnmatchedChallenges() {
	$me = getMe();
	$unmatchedChallenges = $me->getUnmatchedChallenges();
	echo("<h5>My Unmatched Head 2 Head Challenges</h5>");
	if(count($unmatchedChallenges ) > 0)
	{
		foreach($unmatchedChallenges as $umChallenge)
		{
			displayUnmatchedChallenge($umChallenge);
		}
	} else {
		echo("You don't have any open challenges.");
	}
}

function displayUnmatchedChallenge($challenge) {
	$type = "head2headOpen";
	$name = getMe()->get_name();
	$cid      = $challenge->get_challenge_id();
	$amount   = $challenge->get_amount();
	$charityName = ucwords(strtolower($challenge->get_charity()->get_name()));
	$winTeam  = $challenge->get_team();
	$loseTeam = $challenge->get_losing_team();
	$winTeamName  = $winTeam->get_name();
	$loseTeamName = $loseTeam->get_name();
	$homeTeamImg  = $winTeam->get_home_logo();
	$awayTeamImg = $loseTeam->get_away_logo();

	if(!isset($homeTeamImg) || !isset($awayTeamImg))
	{
		$homeTeamImg  =  $loseTeam->get_home_logo(); 
		$awayTeamImg = $winTeam->get_away_logo();
	}
	
	$head2headMsg = "$name put down $$amount.00 for $charityName and thinks $winTeamName is going to kick $loseTeamName's arse during March Madness. Are you ready to put money up for charity? For glory? For the chance to rub $winTeamName's loss in $name's face?";
	$head2headLink = "https://schooldu.com/game_details.php?cid=" . $cid;
	$head2headTitle = "Created a Head 2 Head Donation Challenge";	

	$link = "https://schooldu.com/game_details.php?cid=" . $cid;
	//$fbJsParam = '"' . $link . '","' . $name. '","' .$amount. '","' .$winTeam. '","' .$loseTeam. '"';
	$fbMsgParam = "'',head2headLink_$cid,head2headTitle_$cid,head2headMsg_$cid";
	?>
	<script>
		var <?echo("head2headMsg_$cid = \"$name put down $$amount.00 for $charityName and thinks $winTeamName is going to kick $loseTeamName's arse. Are you ready to put money up for charity? For glory? For the chance to rub $winTeamName's loss in $name's face?\";");?>
		var <?echo("head2headLink_$cid = \"$link\";");?>
		var <?echo("head2headTitle_$cid  = \"Created a Head 2 Head Donation Challenge\";");?>	
	</script>
	
	<div class="media" style="margin:4px;" id="<?echo($type . $cid);?>" style="overflow:visible;">
		  
		<div class="pull-left">
			<a href="<?echo($link);?>">
				<img src="<?echo($awayTeamImg);?>" alt="<?echo($loseTeamName);?>"/><img src="<?echo($homeTeamImg);?>" alt="<?echo($winTeamName);?>"/>
			</a>
		</div>
		  
		<div class="media-body" style="overflow:visible;">
			<h5 style="margin:0px">
				<strong style="color:red;">$<? echo($amount); ?> </strong><?echo("$winTeamName for '$charityName'");?><br/>
			</h5>
			<ul class="nav nav-pills" style="margin-bottom:0px;">
				<li><a href="#" onClick="sendFbMessage(<?echo($fbMsgParam);?>)" ><i class="icon-envelope"></i> Facebook Message</a></li>
				<li><a href="#" onClick="showHide('#<?echo($cid)?>_manualTextArea')"><i class="icon-globe"></i> Manual Link</a></li>
				<li><a href="<?echo($link);?>"><i class="icon-bullhorn"></i> View</a></li>
				<li><a href="#" onClick="deleteChallenge(<?echo("'$type','$cid'");?>) "><i class="icon-trash"></i> Delete Challenge</a></li>
			</ul>
			
			<div id="<?echo("$cid");?>_emailResult"></div>
			<div class="hidden" id="<?echo($cid);?>_emailFormContainer">
			 <form class="form-inline" method='post' onsubmit="sendMail('#<?echo("$cid");?>_emailResult','#<?echo($cid);?>_emailFormContainer'); return false;" action='dev/challengeMail.php' id="emailForm">
				<label class="control-label" for="name">Recipient's Email:</label>
				<input type="email" placeholder="Email" id="email" required name="email" >
				<input type="hidden" id="name" name="name" value="<?echo($name);?>">
				<input type="hidden" id="link" name="link" value="<?echo($link);?>">
				<button type="submit" class="btn btn-primary">Send Email</button>
			  </form>
			</div>
			<div id="<?echo($cid);?>_manualTextArea" class="hidden">
				<textarea class="span10" rows="2"><? echo($link); ?></textarea>
			 </div>
			
		</div>
	</div>
<?}?>

