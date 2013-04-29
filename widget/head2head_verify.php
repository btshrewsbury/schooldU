<?php
function showVerify()
{
	$me = getMe();
	$charity_id = $_POST["charity_id"];
	$charity = Charity::getCharityById($_POST["charity_id"]);
	$amount = $_POST["amount"];
	$game_id = $_POST["game_id"];
	$game = Game::getGameById($game_id);
	$winner = $_POST["winner"];
	$losingTeam = $game->get_other_team($_POST["winner"]);
	$winningTeam = $game->get_other_team($losingTeam->get_team_id());
	?>
	<h5 class='text-info'>Verify Your Head 2 Head Challenge</h5>
	<span style="padding-left:3em">I,</span> <strong><?echo($me->get_name());?></strong>, will donate <span style='color:green;'><strong>$<?echo($amount);?>.00</strong></span> to the charity 
	of my opponents choice if that punk team <span style='color:red;'><strong><?echo($losingTeam->get_name());?></strong></span> wins. I understand that if I lose this challenge people might 
	make fun of me. But, if I <strong>WIN</strong>, I have every right to <span style='color:green;'>boastfully congratulate</span> (<i>Rub in their Face!</i>) my opponents on their contribution 
	to <strong><?echo($charity->get_name());?></strong>. In fact it's <span style="font-size: 120%; color:red;"><b>my duty</b></span> to perform a play by play explaining how 
	<span style='color:red;'><strong><?echo($winningTeam->get_name());?></strong></span> kicked <i><?echo($losingTeam->get_name());?>'s</i> arse. I will call, email, and post on social media
	messages, gloriusly claiming my victory and detailing how my hard work is helping put students through college.
	<br/>
	<br/>
	
	<div class="row-fluid">
		<button class="btn btn-success span6" onclick="challengeFormSubmit('head2head')" style="min-height:40px;">Accept the Challenge!</button>
		<button class="btn btn-danger span6"  onclick="challengeFormSubmit('createChallenge')" style="min-height:40px;">I Changed My Mind</button>
	</div>
	
	<form id="challengeForm" name="challengeForm" class="hidden">
		<input type="hidden" name="amount" id="amount" value="<?echo($amount);?>">
		<input type="hidden" name="winner" id="winner" value="<?echo($winner);?>">
		<input type="hidden" name="charity_id" id="charity_id" value="<?echo($charity_id);?>">
		<input type="hidden" name="game_id" id="game_id" value="<?echo($game_id);?>">
		<input type="hidden" name="action" id="action" value="create">
	</form>
<?}?>