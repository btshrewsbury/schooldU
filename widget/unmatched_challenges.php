<?php
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
			displayUmatchedChallenge($link,$user->get_profile_pic(),$user->get_name(),$descrip);
		}
	} else {
		echo("<strong>No Umatched Challenges!</strong>");
	}
}

function displayUmatchedChallenge($link,$profile_pic,$name,$descrip)
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

?>