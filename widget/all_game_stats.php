<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/head2head.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/pool.php");

$all_game_stats_totalAmountInPool = Pool::getPooledAmount();
$all_game_stats_amountInHead2Head = Head2Head::getHead2HeadAmount();
?>
	
<div class="span4 amountTile dropshadow clickable" id="amountDonatedTile">
	<div id="amountDonatedTileLeft">
		<p class="tileInnerText" id="amountDonatedTileLeftInner"><span style="font-size:xx-large;">$<?echo($all_game_stats_amountInHead2Head);?></span><br />in Head 2 Head</p>
	</div>
	<div id="amountDonatedTileRight">
		<p class="tileInnerText" id="amountDonatedTileRightInner"><span style="font-size:xx-large;">$<?echo($all_game_stats_totalAmountInPool);?></span><br />in Pool</p>
	</div>
</div>

