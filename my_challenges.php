<?
require_once("utility/account.php");



if(isLoggedIn())
{
	getChallenges();
}

function getChallenges() {
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
	
	$h2hChallenges = $me->getMatchedChallenges();
	echo("<h5>My Head 2 Head Challenges</h5>");
	if(count($h2hChallenges ) > 0)
	{
		foreach($h2hChallenges as $aChallenge)
		{
			displayMatchedChallenge($aChallenge);
		}
	} else {
		echo("You don't have any matched challenges.");
	}
	
	$poolChallenges = $me->getPoolededChallenges();
	echo("<h5>My Pooled Challenges</h5>");
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

	//$link = generateOpenShareLink($cid);
	//$fbJsParam = '"' . $link . '","' . $name. '","' .$amount. '","' .$winTeam. '","' .$loseTeam. '"';
	?>
	
	<div class="media" id="<?echo($type . $cid);?>" style="overflow:visible;">
		  
		<div class="pull-left">
			<a href="#">
				<img src="<?echo($awayTeamImg);?>" alt="<?echo($loseTeamName);?>"/><img src="<?echo($homeTeamImg);?>" alt="<?echo($winTeamName);?>"/>
			</a>
		</div>
		  
		<div class="media-body" style="overflow:visible;">
			<h4 style="margin:0px">
				<strong style="color:red;">$<? echo($amount); ?> </strong><?echo("$winTeamName for '$charityName'");?><br/>
			</h4>
			<ul class="nav nav-pills" >
				<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-thumbs-up"></i> Facebook<b class="caret"></b></a>
				<ul class="dropdown-menu" >
					<li><a href="#" onClick='postH2HToFBFeed(<?echo($fbJsParam);?>)' ><i class="icon-thumbs-up"></i> Facebook Wall</a></li>
					<li><a href="#" onClick='sendFbMessage(<?echo($fbJsParam);?>)' ><i class="icon-envelope"></i> Facebook Message</a></li>
				</ul>
				<li><a href="#" onClick="showHide('#<?echo($cid)?>_manualTextArea')"><i class="icon-globe"></i> Manual Link</a></li>
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
			<h5><? echo("$myName vs. $opponentName " ); ?><br /></h5>
			<strong style="color:red;">$<? echo($amount); ?> </strong> On the line. | You have <?echo($winTeamName);?> for the win
			<br/><? echo("My Charity: $myCharityName");?>
			<br/><? echo("$opponentName's Charity: $myCharityName");?>
			<ul class="nav nav-pills" >
				<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-thumbs-up"></i> Facebook Taunts<b class="caret"></b></a>
				<ul class="dropdown-menu" >
					<li><a href="#" onClick='Closed_H2H_Fb_Post_To_Wall(<?echo($fbJsParam);?>)' ><i class="icon-thumbs-up"></i> Facebook Wall</a></li>
					<li><a href="#" onClick='Closed_H2H_Fb_send_Message(<?echo($fbJsParam);?>)' ><i class="icon-envelope"></i> Facebook Message</a></li>
				</ul>
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

	if(!isset($homeTeamImg) || !isset($awayTeamImg))
	{
		$homeTeamImg  =  $awayTeam->get_home_logo(); 
		$awayTeamImg = $homeTeam->get_away_logo();
	}
	//$fbJsParam = '"' . $link . '","' . $name. '","' .$amount. '","' .$winTeam. '","' .$loseTeam. '"';
	?>
	
	<div class="media" id="<?echo($type . $cid);?>" style="overflow:visible;">
		<div class="pull-left">
			<a href="#">
				<img src="<?echo($awayTeamImg);?>" alt="<?echo($loseTeamName);?>"/><img src="<?echo($homeTeamImg);?>" alt="<?echo($winTeamName);?>"/>
			</a>
		</div>
		  
		<div class="media-body" style="overflow:visible;">
			<h5><span style="color:red;">$<? echo($amount ); ?> </span> In the Pool.</h5> 
			<ul class="nav nav-pills" >
				<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-thumbs-up"></i> Facebook<b class="caret"></b></a>
				<ul class="dropdown-menu" >
					<li><a href="#" onClick='Pool_Fb_Post_To_Wall(<?echo($fbJsParam);?>)' ><i class="icon-thumbs-up"></i> Facebook Wall</a></li>
					<li><a href="#" onClick='Pool_H2H_Fb_send_Message(<?echo($fbJsParam);?>)' ><i class="icon-envelope"></i> Facebook Message</a></li>
				</ul>
				<!--<li><a href="#" onClick="deleteChallenge(<?echo("'$type','$cid'");?>) "><i class="icon-trash"></i> Delete Challenge</a></li>-->
			</ul>
		</div>
	</div>
<?
}
?>