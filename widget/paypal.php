<?php
// clearing the session before starting new API Call
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");
$me = getMe();
$email = "";
if($me->get_paypal_email() != NULL && $me->get_paypal_email() != "")
{
	$email = $me->get_paypal_email();
}
?>

<div class="span4">
	<div class="well well-small" style="padding:0px; margin:0px 20px 0px 0px; height:420px;">
		<div class="row-fluid cc_header">
		  <h4 class="text-info" style="margin:18px 0 0 12px;"><img src="img/paypal.png" style="height:36px;" />Payment Profile</h4>
		  <h5 style="margin:0 0 18px 12px ;">Use Paypal for Donations</h5>
		</div>
		
		
		<div class="row-fluid">
			<span class="span12" style="padding: 24px;">
				<p>By Linking your Paypal account below you give SchooldU the right to donate money to Education Based Charities in your name in the event that you lose a Head 2 Head challenge or at the end of a Pooled Challenge you competed in.</p>
			</span>
		</div>
		
			
		<div class="row-fluid">
			<div class="span10 offset1">
				<form action="https://schooldu.com/payment/request.php" method="post">
					<div class="input-prepend">
					  <span class="add-on">Email: </span>
					  <input type="email" maxlength="64" name="senderEmail" id="senderEmail" value="<?echo $email;?>" placeholder="Email">
					  <input type="hidden" id="maxNumberOfPayments" value="100">
					</div>
					
					<button type="submit" class="btn btn-block btn-primary" style="margin-top:50px;">Link Paypal Account</button>
				</form>
			</div>
		</div>
	</div>
</div>