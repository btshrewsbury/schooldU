<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/payment/stripe/lib/Stripe.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/charity.php");

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST["stripeToken"]))
	{
		$me = getMe();
		$token = $_POST['stripeToken'];

		$customer = Stripe_Customer::create(array(
		  "card" => $token)
		);

		$me->set_stripe_id($customer->id);
		$me->save();
		header( 'Location: https://schooldu.com/payment.php' ) ;
	}
}

function payViaStripe($stripe_id,$charityId,$amount)
{
	if($stripe_id != NULL && $stripe_id != '')
	{
		$charityName = Charity::getCharityById($charityId)->get_name();
		$amount = $amount * 100;
		$result = Stripe_Charge::create(array(
		  "amount"   => $amount, # $15.00 this time
		  "currency" => "usd",
		  "customer" => $stripe_id,
		  "description" => "Donation To $charityName")
		);
	}
}
?>