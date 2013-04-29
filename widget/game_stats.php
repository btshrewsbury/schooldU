<?php
function showColumn($game)
{
 	 $amountInPool = $game->get_pooled_amount();
	 $amountInHead2HeadOpen = $game->get_head2head_amount_unmatched();
	 $amountInHead2Head = $game->get_head2head_amount_matched();
 ?>
	<div class="widgetTitle blueBG"><span class="titleLink">Head 2 Head Challenges</span></div>
	<div class="amountWidget" id="head2headAmountWidget">
		<p style="font-size:large;"><span style="font-size:xx-large;">$<?echo($amountInHead2Head);?></span><br />In Head 2 Head</p>
	</div>
	
	<div class="widgetTitle greenBG"><span class="titleLink" >Pooled Challenges</span></div>
	<div class="amountWidget" id="pooledAmountWidget">
		<p style="font-size:large;"><span style="font-size:xx-large;">$<?echo($amountInPool);?></span><br />In the Pool</p>
	</div>

	<div class="widgetTitle grayBG"><span class="titleLink">Unmatched Challenges</span></div>
	<div class="amountWidget" id="unmatchedHead2headAmountWidget">
		<p style="font-size:large;"><span style="font-size:xx-large;">$<?echo($amountInHead2HeadOpen);?></span><br />Unmatched</p>
	</div>
	
	<?if(isLoggedIn()){?>
		<div class="amountWidget clickable" id="viewMyChallengeWidget" >
			<p style="font-size:x-large;">View my challenges</p>
		</div>
	<?}?>
	<script>
		

	$("#viewMyChallengeWidget").click(
		function()
		{
			window.location = "account.php";
			return false;
		}
	);
	</script>
	
<?}
?>
