<?php

function createHead2Head($game_id,$winner,$charity_id,$amount)
{
	$me = getMe();

	$newChallenge = new Head2Head(null);
	$newChallenge->set_user_id($me->get_user_id());
	$newChallenge->set_team_id($winner);
	$newChallenge->set_game_id($game_id);
	$newChallenge->set_charity_id($charity_id);
	$newChallenge->set_amount($amount);
	$newChallenge->save();
	return $newChallenge;
}

?>
