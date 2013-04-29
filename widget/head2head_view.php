<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");

function displayChallenge($theChallenge)
{
	$me = getMe();
	$challenge_id = $theChallenge->get_challenge_id();
	$challengerName = $theChallenge->get_user()->get_name();
	$amount = $theChallenge->get_amount();
	$winTeamName = $theChallenge->get_team()->get_name();
	$loseTeamName = $theChallenge->get_losing_team()->get_name();
	$charityName= $theChallenge->get_charity()->get_name();
	$isMyChallenge = $me == $theChallenge->get_user();
	$game_id = $theChallenge->get_game_id();
	?>
	
	<div id='joinHead2headAlert'></div>
	<h3><?echo("$winTeamName vs. $loseTeamName");?></h3>
	 <?echo($challengerName);?> put down <b><span style='color:green;'>$<?echo($amount);?>.00</span></b> for <?echo($charityName);?> and thinks <b><?echo($winTeamName);?></b> is going to kick <b><?echo($loseTeamName);?>'s</b> 
	 <i><span style='color:red;'>arse</span></i>. Are you ready to put money up for <i><b>charity</b></i>? for 
	 <span style='color:red;'>bragging rights</span>? for the chance to rub  <b><?echo($winTeamName);?>'s</b> <span style='color:red;'>loss</span> in <?echo($challengerName);?>'s <b>face</b>? 
	 Accept this challenge and make your rival pay!
	<br/><br/>
	<div class="row-fluid">
	<?if($isMyChallenge){?>
		<button class="btn btn-success span6 offset3" style="min-height:40px;">Can't Accept my own challenge!</button>	
	<?} else if(isset($me)){?>
		<div class="row-fluid">
			<button class="btn btn-success span6" onclick="challengeFormSubmit('head2head')" style="min-height:40px;">Accept the $<?echo($amount);?> Challenge!</button>
			<button class="btn btn-danger span6"  onclick="challengeFormSubmit('createChallenge')" style="min-height:40px;">Make My Own</button>
		</div>
	<?} else {?>
		<button class="btn btn-success span6 offset3 disabled" style="min-height:40px;">Login to Accept <?echo($challengerName);?>'s Challenge!</button>
		<?}?>
	</div>
	<form id="challengeForm" name="challengeForm" class="hidden">
		<input type="hidden" name="challenge_id" id="challenge_id" value="<?echo($challenge_id);?>">
		<input type="hidden" name="game_id" id="game_id" value="<?echo($game_id);?>">
		<input type="hidden" name="action" id="action" value="charityPair">
	</form>
	<?

}

function displayClosedChallenge($theChallenge)
{
	$name = $theChallenge->get_user()->get_name();
	$game_id = $theChallenge->get_game_id();
	?>
	
	<h3>Dagnabbit!</h3>
	It looks like someone beat you to <?echo($name);?>'s challenge! This head 2 head challenge has already been accepted, but you can still make your own! Click the button below to get started.<br/>
	<br/><br/>
	
	<div class="row-fluid"> 
		<button class="btn btn-success span6 offset3"  onclick="challengeFormSubmit('createChallenge')" style="min-height:40px;">Create a Donation Challenge</button>
	</div>
	<form id="challengeForm" name="challengeForm" class="hidden">
		<input type="hidden" name="game_id" id="game_id" value="<?echo($game_id);?>">
		<input type="hidden" name="action" id="action" value="nothin">
	</form>
<?}
?>