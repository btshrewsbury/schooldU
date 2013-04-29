<?php
function showCharityBreakdown($game)
{
	$charitiesTuple = $game->get_top_charities(6);
	$total = 0;
	if(count($charitiesTuple) > 0)
	{
	
		foreach($charitiesTuple as $charity_id => $amount) {
			$total += $amount;
		}
		foreach($charitiesTuple as $charity_id => $amount) {
			$aCharity = Charity::getCharityById($charity_id);
			displayCharityRow($aCharity,$amount,$total);
		}
	} else {
		echo("<strong>No Head 2 Head Challenges Yet</strong>");
	}
}

function displayCharityRow($charity,$amount,$total)
{
	$charity_name = $charity->get_name();
	$data = "$$amount - $charity_name";
	?>
	<div class="progress" style="margin-bottom:2px">
		<div class="bar" style="width: <?echo($amount / $total * 100);?>%; text-align:left;"><span style="padding:8px;"><?echo($data);?></span></div>
	</div>
	<!--<div class="media">
	  <div class="media-body">
		<h5 class="media-heading"> </h5>
	  </div>
	</div>-->
	<?
}
?>