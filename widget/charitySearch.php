<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/charity.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");

if(isset($_REQUEST["charity_name"]))
{
	$name = $_REQUEST["charity_name"];
	$state = $_REQUEST["state"];
	$city = $_REQUEST["city"];
	$zip = $_REQUEST["zip"];
	$offset = (isset($_REQUEST["offset"]) ? $_REQUEST["offset"] : 0);
	$limit = 12;
	
	$charities = Charity::searchCharities($name,$state,$city,$zip,$limit,$offset,&$size);
	$pages = ceil($size / $limit);
	$thisPage = floor($offset / $limit) + 1;
		
	if(count($charities) == 0)
	{
		echo "OH NO! No Charities were Found?, Please check the name and try again<br/>";
	} else {
		echo("<div class='row-fluid'><div class='span6'>");
		$rowNum = 0;
		foreach($charities as $aCharity)
		{
			if($rowNum == $limit / 2)
			{
				echo("</div><div class='span6'>");
			}
		?>
			<div class="btn btn-block charityOption" name="<?echo($aCharity->get_charity_id());?>">	  
				<div class="media-body" style="padding: 4px 10px;">
						<strong><?echo($aCharity->get_name());?></strong><br/>			
						<?echo($aCharity->get_full_address());?>
				</div>
			</div>
		<?
			$rowNum++;
		}
		echo '</div></div><br/>';
		if($pages > 1)
		{
			echo('<div class="pull-right" style="padding-right:10px;">');
			if($thisPage != 1)
			{
				$prevOffset = $offset - $limit;
				echo " <a style=' cursor: pointer;' onclick='charitySearchPage($prevOffset)'>&lt; prev</a> ";
			}
			echo "page $thisPage of $pages";
			if($thisPage != $pages)
			{
				$nextOffset = $offset + $limit;
				echo " <a style=' cursor: pointer;' onclick='charitySearchPage($nextOffset)'>next &gt;</a> ";
			}
			echo('</div>');
		}
		?>
			<script>
				$(".charityOption").click(function() {
					$(".charityOption").removeClass('btn-success');
					$(".charityOption").attr('id', '');
					$(this).addClass('btn-success');
					$(this).attr('id', 'selected_charity');
					
					$(".challengeButton").removeClass('disabled');
				});
			</script>
		<?
	}
}

function showSearchForm($action)
{
	$amount = $_POST["amount"];
	$game_id = $_POST["game_id"];
	$winner = $_POST["winner"];
	$challenge_id = $_POST['challenge_id'];
	$me = getMe();
?>
	<div>
		<h5><span class='text-info'>Head 2 Head Challenge</span></h5>
	</div>
	<div class="well well-small">
		<form id="charitySearchForm" class="form-inline"action="#" onsubmit="charitySearch(); return false;" style="margin:8px;">
		  <span class="add-on"><b>Charity Name: </b></span>
		  <input name="charity_name" id="charity_name" title="Enter Name"></input>			 
		  <button type="submit" class="btn btn-info" >Search</button>
		  <input name ="size" id ="size" type="hidden" value="<?echo($size);?>" />
		  <input name ="offset" id ="offset" type="hidden" value="" />

		  
		</form>
		<form id="challengeForm" name="challengeForm" class="hidden">
			<input type="hidden" name="amount" id="amount" value="<?echo($amount);?>">
			<input type="hidden" name="winner" id="winner" value="<?echo($winner);?>">
			<input type="hidden" name="charity_id" id="charity_id" value="">
			<input type="hidden" name="game_id" id="game_id" value="<?echo($game_id);?>">
			<input type="hidden" name="action" id="action" value="<?echo($action);?>">
			<input type="hidden" name="challenge_id" id="challenge_id" value="<?echo($challenge_id);?>">
		</form>
	</div>	
	
	<div id="charitySearchResults">
	</div>
	<br/><br/>
	<div class="row-fluid">
		<button class="btn btn-success span6 disabled challengeButton" onclick="charityFound()" style="min-height:40px;">Lets Verify!</button>
		<button class="btn btn-danger span6"  onclick="challengeFormSubmit('createChallenge')" style="min-height:40px;">Cancel</button>
	</div>
	
	
<?
}

function showCharitySearchNoForm()
{
?>
	<div>
		<h4><span class='text-info'>Education Based Charities</span></h4>
	</div>

		<form id="charitySearchForm" class="form-inline"action="#" onsubmit="charitySearch(); return false;" style="margin:8px;">
		  <span class="add-on"><b>Charity Name: </b></span>
		  <input name="charity_name" id="charity_name" title="Enter Name"></input>			 
		  <button type="submit" class="btn btn-info" >Search</button>
		  <input name ="size" id ="size" type="hidden" value="<?echo($size);?>" />
		  <input name ="offset" id ="offset" type="hidden" value="" />

		  
		</form>
		<form id="challengeForm" name="challengeForm" class="hidden">
			<input type="hidden" name="amount" id="amount" value="<?echo($amount);?>">
			<input type="hidden" name="winner" id="winner" value="<?echo($winner);?>">
			<input type="hidden" name="charity_id" id="charity_id" value="">
			<input type="hidden" name="game_id" id="game_id" value="<?echo($game_id);?>">
			<input type="hidden" name="action" id="action" value="<?echo($action);?>">
			<input type="hidden" name="challenge_id" id="challenge_id" value="<?echo($challenge_id);?>">
		</form>
	
	
	<div id="charitySearchResults">
	</div>

	
<?
}
?>