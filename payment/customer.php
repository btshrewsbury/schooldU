<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/payment/stripe/lib/Stripe.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");

$sid = session_id();
if(!isset($sid)) {
    session_start();
}

	
		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here https://manage.stripe.com/account
		Stripe::setApiKey("sk_test_PdQSZi4OSfLDETNSRLxB65D0");
		$me = getMe();
		$stripe_id = $me->get_stripe_id();
		

		$cust = Stripe_Customer::retrieve($stripe_id);

		
		Stripe_Charge::create(array(
		  "amount"   => 500, # $15.00 this time
		  "currency" => "usd",
		  "customer" => $me->get_stripe_id())
		);
		echo("charged");


?>