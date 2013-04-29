<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/pool.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/game.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/challengeFriends.php");


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if($_POST["action"] == "initial")
	{	
		$me = getMe();
		$amount = $_POST["amount"];
		$game_id = $_POST["game_id"];
		$game = Game::getGameById($game_id);
		$losingTeam = $game->get_other_team($_POST["winner"]);
		$winningTeam = $game->get_other_team($losingTeam->get_team_id());
		$winningTeamCharityName = $winningTeam->get_school()->get_charity()->get_name();
		$losingTeamCharityName =   $losingTeam->get_school()->get_charity()->get_name();
		$losingTeamName = $losingTeam->get_name();
		$winningTeamName = $winningTeam->get_name();
		
		
		?>
		
		<div class="row-fluid">
			<div class="span6 well well-small ">
				<center>
					<?echo("<b>$winningTeamName :</b> $winningTeamCharityName");?>
				</center>
			</div>
			<div class="span6 well well-small ">
				<center>
					<?echo("<b>$losingTeamName :</b> $losingTeamCharityName");?>
				</center>
			</div>	
		</div>
		<h5 class='text-info'>Verify Your Pooled Challenge</h5>
		<span style="padding-left:3em">I,</span> <strong><?echo($me->get_name());?></strong>, will donate <span style='color:green;'><strong>$<?echo($amount);?>.00</strong></span> 
		to the <strong>charity</strong> paired with the winning team (Listed Above), even in the slight chance it's that punk team <span style='color:red;'><strong><?echo($losingTeamName);?></strong></span>.
		I will donate my money with pride, because no matter who wins, it's going to a <b>good cause</b>. Although I'm not competing directly against someone, I will still find a way
		to artfully boast about my team and my charitable giving, humbly of course.
		<br/>
		<br/>
		
		<div class="row-fluid">
			<button class="btn btn-success span6" onclick="challengeFormSubmit('pooled')" style="min-height:40px;">Accept the Challenge!</button>
			<button class="btn btn-danger span6"  onclick="challengeFormSubmit('createChallenge')" style="min-height:40px;">I Changed My Mind</button>
		</div>
		
		<form id="challengeForm" name="challengeForm" class="hidden">
			<input type="hidden" name="amount" id="amount" value="<?echo($amount);?>">
			<input type="hidden" name="game_id" id="game_id" value="<?echo($game_id);?>">
			<input type="hidden" name="action" id="action" value="create">
		</form>
		<?
	
	}	
	if($_POST["action"] == "create")
	{
		
		$me = getMe();
		$pooledChallenge = new Pool(null);
		$pooledChallenge->set_user_id($me->get_user_id());
		$pooledChallenge->set_game_id($_POST["game_id"]);
		$pooledChallenge->set_amount($_POST["amount"]);
		$pooledChallenge->save();
		showFriendsForPool($pooledChallenge);
	}
}
?>
