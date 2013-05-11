<?php
require_once("utility/account.php");
$sid = session_id();
if(!isset($sid)) {
    session_start();
}

if(isLoggedIn())
{
	$me = getMe();
	if($me->get_paypal_pa() == NULL || $me->get_paypal_pa() == "")
	{
		if($_SERVER["PHP_SELF"] != '/profile.php')
		{
			//header( 'Location: https://schooldu.com/profile.php' ) ;
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>School'd U <?echo($title);?></title>
    <meta name="description" content="<?echo($description);?>">
    <meta name="author" content="Brandon Shrewsbury">
	<link href="favicon.ico" rel="shortcut icon">
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/schoold.css" rel="stylesheet">
	
	
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/schooldu.js"></script>
	<script src="js/social.js"></script>
	<script src="https://js.stripe.com/v2/"></script>
	<script src="js/payment.js"></script>
	<script>
		$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });
	</script>

  </head>