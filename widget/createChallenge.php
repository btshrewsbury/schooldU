<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/game.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["action"]))
{
	$game_id = $_POST["game_id"];
	$theGame = Game::getGameById($game_id);
	
	showCreateChallenge($theGame);
	
}
	
function showCreateChallenge($theGame)
{
	$me = getMe();
	$gameId = $theGame->get_game_id();
	$homeTeam = $theGame->get_home_team();
	$awayTeam = $theGame->get_away_team();
	$homeTeamId = $homeTeam->get_team_id();
	$awayTeamId = $awayTeam->get_team_id();
	$awayTeamName = $awayTeam->get_name();
	$homeTeamName = $homeTeam->get_name();
?>
	
	<form id="challengeForm" autocomplete="off" class="span8">
		<div class="span6">
			<h5 class="text-info" id="startChallengeForm"  style="margin-top:0px">Create a Challenge</h5>
			<div>
				
				<div>
					<h5>Who's going to win?:</h5>
					<label class="radio">
					  <input type="radio" name="winner" id="option_team1" value="<?echo($homeTeamId);?>"  required>
					  <?print("$homeTeamName");?>
					</label>
					<label class="radio">
					  <input type="radio" name="winner" id="option_team2" value="<?echo($awayTeamId );?>"  required>
					  <?print("$awayTeamName");?>
					</label>
				</div>
			</div>
		</div>
			
		<div class="span6">
			<div class="input-prepend input-append inline">
			<br/>
				<label class="control-label" for="amount">How sure are you?:</label>
			  <span class="add-on">$</span>
			  <input class="input-small" name="amount" id="amount" type="number" value="5" min="5" style="text-align:right;" required title="Minimum $5">
			  <input type="hidden" name="game_id" id="game_id" value="<?echo($gameId);?>">
			  <input type="hidden" name="action" id="action" value="initial">
			  <span class="add-on">.00</span>
			</div>  
		</div>
		<span class="text-error">Minimum $5</span>
	</form>
	<div class="span4">
		<button class="btn btn-info span10 <?if(!$me) echo('disabled');?>"  onclick="challengeFormSubmit('head2head'<?if(!$me) echo(',true');?>)" style="min-height:40px; margin:10px"><img src="img/glyphicons_024_parents.png" alt="Go Head to Head"/> Go Head to Head </button>
		<button class="btn btn-success span10  <?if(!$me) echo('disabled');?>"  onclick="challengeFormSubmit('pooled'<?if(!$me) echo(',true');?>)" style="min-height:40px; margin:10px"><img src="img/glyphicons_043_group.png" alt="Join the Pool"/> Join the Pool </button>
	</div>
<?}?>