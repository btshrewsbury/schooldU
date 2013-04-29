<?php

// clearing the session before starting new API Call
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/payment/lib/web_constants.php");
require_once($_SERVER["DOCUMENT_ROOT"] . '/payment/lib/AdaptivePayments.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/payment/lib/Stub/AP/AdaptivePaymentsProxy.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/payment/stripe/lib/Stripe.php");

$me = getMe();
$email = "";
$displayPaypalStatus = false;
$displayStripeStatus = false;
$icon = "img/invalid.png";


if($me->get_paypal_email() != NULL && $me->get_paypal_email() != "")
{
	$email = $me->get_paypal_email();
	if($me->get_paypal_pa() != NULL && $me->get_paypal_pa() != "")
	{
		try {
			$preapprovalKey = $me->get_paypal_pa();
			$PDRequest = new PreapprovalDetailsRequest();
			
			$PDRequest->requestEnvelope = new RequestEnvelope();
			$PDRequest->requestEnvelope->errorLanguage = "en_US";
			$PDRequest->preapprovalKey = $preapprovalKey; 
			
			$ap = new AdaptivePayments();
			$response = $ap->PreapprovalDetails($PDRequest);

			if(strtoupper($ap->isSuccess) == 'FAILURE')
			{
				$_SESSION['FAULTMSG']=$ap->getLastError();
			} else {
				$displayPaypalStatus = true;
				$icon = "img/check.png";
			}
		}
		catch(Exception $ex) {
		}
	}
}

if($me->get_stripe_id() != NULL && $me->get_stripe_id() != "")
{
	$cust = Stripe_Customer::retrieve($me->get_stripe_id());
	if(isset($cust->id))
	{
		$displayStripeStatus = true;
		$last4 = $cust->active_card->last4;
		$type = $cust->active_card->type;
		$exp_month = $cust->active_card->exp_month;
		$exp_year = $cust->active_card->exp_year;
		$name = $cust->active_card->name;
		$address_line1 =  $cust->active_card->address_line1;
		$address_city = $cust->active_card->address_city;
		$address_state =  $cust->active_card->address_state;
		$address_zip =  $cust->active_card->address_zip;
		$icon = "img/check.png";
	}
}


?>

<div class="span4">
	<div class="well well-small" style="padding:0px; margin:0px 20px 0px 0px; height:420px;">
		<div class="row-fluid cc_header">
		  <h4 class="text-info" style="margin:18px 0 0 12px;"><img src="<?echo($icon);?>" style="margin-right:10px; height:36px;"/>Payment Information</h4>
		  <h5 style="margin:0 0 18px 60px ;">Your Payment Settings</h5>
		</div>


		<?if($displayPaypalStatus){?>
			<h4 class="text-info" style="margin:18px 0 0 12px;"><img src="img/paypal.png" style="height:36px;" />Payment On File</h4>
			<table class="offset1">
				<tbody>
					<tr>
						<td class="thinfield" style="padding-right:8px;">Preapproval Key:</td>
						<td class="thinfield"><?php echo $preapprovalKey ?></td>
					</tr> 	
					  <tr>
						<td class="thinfield">Payments:</td>
						<td class="thinfield">$<?php echo $response->curPaymentsAmount ?></td>
					</tr>
					<tr>
						<td class="thinfield">Status:</td>
						<td class="thinfield"><?php echo $response->status ?></td>
					</tr>
					<tr>
						<td class="thinfield">Attempts:</td>
						<td class="thinfield"><?php echo $response->curPeriodAttempts ?></td>
					</tr>
					<tr>
						<td class="thinfield">Approved status:</td>
						<td class="thinfield"><?php echo $response->approved ?></td>
					</tr>
				</tbody>
			</table>
		<?}elseif($displayStripeStatus){?>
			<h4 class="text-info" style="margin:18px 0 0 28px;"><img src="img/StripeLogo.png" style="height:36px;" /> Payment On File</h4>
			<table class="offset1">
				<br/>
				<tbody>
					<tr>
						<td class="thinfield" style="padding-right:8px;"> Type:</td>
						<td class="thinfield"><?php echo $type ?></td>
						
					</tr> 	
					<tr>
						<td class="thinfield" style="padding-right:8px;"> Number:</td>
						<td class="thinfield">************<?php echo $last4 ?></td>
					</tr> 	
					<tr>
						<td class="thinfield" style="padding-right:8px;"> Exp. Date:</td>
						<td class="thinfield"><?php echo("$exp_month/$exp_year"); ?></td>
					</tr> 
					<tr>
						<td class="thinfield" style="padding-right:8px;"> Cardholder Name:</td>
						<td class="thinfield"><?php echo $name ?></td>
					</tr>
					<tr>
						<td class="thinfield" style="padding-right:8px;"> Billing address:</td>
						<td class="thinfield"><?php echo $address_line1 ?></td>
					</tr>					
					<tr>
						<td class="thinfield"></td>
						<td class="thinfield">
							<?php echo $address_city ?><br/>
							<?php echo $address_state ?>,
							<?php echo $address_zip ?><br/>
						</td>
					</tr> 	

						
						
				</tbody>
			</table>
		
		<?}else{?>
			<span class="span12" style="padding: 24px;">
				<p>You don't have any payment settings on file. Either link your Paypal Account or add a Credit card to begin challenging friends.</p>
			</span>
		<?}?>
	</div>
</div>


