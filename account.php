<?php
require_once('page_framework/header.php');
require_once('utility/account.php');

if(!isLoggedIn())
{
	header("index_working.php");
}

?>

  <body>
    <div class="container">
		<? include 'page_framework/nav.php'; ?>
			<div class="well well-large">
				<div class="tabbable"> <!-- Only required for left/right tabs -->
				  <ul class="nav nav-pills">
					<li class="active"><a href="#active" data-toggle="tab">Active Challenges</a></li>
					<li><a href="#completed" data-toggle="tab">Completed Challenges</a></li>
				  </ul>
				  <div class="tab-content">
					<div class="tab-pane active" id="active">
						<h4 class="text-info">Active Challenges</h4>
						<div class="well well-small">
							<?getActiveChallenges();?>
						</div>
					</div>
					<div class="tab-pane" id="completed">
						<h4 class="text-info">Completed Challenges</h4>
						<div class="well well-small">
							<?getCompletedChallenges();?>
						</div>
					</div>
				  </div>
				</div>
			</div>
			<?include_once('page_framework/footer.php');?>
    </div>
  </body>
</html>

<?
require_once("utility/account.php");





function getActiveChallenges() {
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

function getCompletedChallenges() {
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
		var <?echo("head2headMsg_$cid = \"$name put down $$amount.00 for $charityName and thinks $winTeamName is going to kick $loseTeamName's arse during March Madness. Are you ready to put money up for charity? For glory? For the chance to rub $winTeamName's loss in $name's face?\";");?>
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
				<!--<li><a href="#" onClick="deleteChallenge(<?echo("'$type','$cid'");?>) "><i class="icon-trash"></i> Delete Challenge</a></li>-->	
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
<?}

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

function displayPooledChallenge($challenge) {
	$type = "head2headOpen";
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
		
	}
	//$fbJsParam = '"' . $link . '","' . $name. '","' .$amount. '","' .$winTeam. '","' .$loseTeam. '"';
	?>
	
	<div class="media" style="margin:4px;" id="<?echo($type . $cid);?>" style="overflow:visible;">
		<div class="pull-left">
			<a href="#">
				<img src="<?echo($awayTeamImg);?>" alt="<?echo($loseTeamName);?>"/><img src="<?echo($homeTeamImg);?>" alt="<?echo($winTeamName);?>"/>
			</a>
		</div>
		  
		<div class="media-body" style="overflow:visible;">
			<h5 style="margin:0px"><span style="color:red;">$<? echo($amount ); ?> </span> In the <?echo("$homeTeamName vs $awayTeamName");?> Pool. <?echo($resultSpan);?></h5>  
			<ul class="nav nav-pills" style="margin-bottom:0px;">
				<li><a href="#" onClick='Pool_H2H_Fb_send_Message(<?echo($fbJsParam);?>)' ><i class="icon-envelope"></i> Facebook Message</a></li>
				<li><a href="<?echo($link);?>"><i class="icon-bullhorn"></i> View Game</a></li>
				<!--<li><a href="#" onClick="deleteChallenge(<?echo("'$type','$cid'");?>) "><i class="icon-trash"></i> Delete Challenge</a></li>-->
			</ul>
		</div>
	</div>
<?
}
?>