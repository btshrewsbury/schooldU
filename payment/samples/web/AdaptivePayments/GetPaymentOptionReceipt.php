<?php

/********************************************
GetPaymentOptionReceipt.php

 This file is called after the user clicks on a button during
 the Pay process to use PayPal's AdaptivePayments Pay features'. The
 user logs in to their PayPal account.
 Called by GetPaymentOption.php
 Calls  CallerService.php,and APIError.php.
 ********************************************/

require_once '../../../lib/AdaptivePayments.php';
require_once 'web_constants.php';
require_once '../../../lib/Stub/AP/AdaptivePaymentsProxy.php';
session_start();

try {

	 
	$serverName = $_SERVER['SERVER_NAME'];
	$serverPort = $_SERVER['SERVER_PORT'];
	$url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);


	/* The returnURL is the location where buyers return when a
	 payment has been succesfully authorized.
	 The cancelURL is the location buyers are sent to when they hit the
	 cancel button during authorization of payment during the PayPal flow                 */

	 
	$payKey = $_REQUEST["payKey"];
	 
	$getPaymentOptionsRequest = new GetPaymentOptionsRequest();
	$getPaymentOptionsRequest->payKey = $payKey;
	 
	$getPaymentOptionsRequest->requestEnvelope = new RequestEnvelope();
	$getPaymentOptionsRequest->requestEnvelope->errorLanguage = "en_US";
	$ap = new AdaptivePayments();
	$response=$ap->GetPaymentOptions($getPaymentOptionsRequest);
	 
	if(strtoupper($ap->isSuccess) == 'FAILURE')
	{
		$_SESSION['FAULTMSG']=$ap->getLastError();
		$location = "APIError.php";
		header("Location: $location");
			
	}
	else
	{
		if($response->responseEnvelope->ack == "Success")
		{
			$GPOResponse = new GetPaymentOptionsResponse();
			$GPOResponse = $response;
			?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>PayPal Platform SDK - Get Payment Option Receipt</title>

<link href="common/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<br/>
        <div id="jive-wrapper">
            <div id="jive-header">
                <div id="logo">
                    <span >You must be Logged in to <a href="<?php echo DEVELOPER_PORTAL;?>" target="_blank">PayPal sandbox</a></span>
                    <a title="Paypal X Home" href="#"><div id="titlex"></div></a>
                </div>
            </div>

<div id="main">
<?php include 'menu.html'?>

<h3><b>AP - Get Payment Option
Receipt</b></h3> <br>
<br>
<br>
<table align="center" width="50%">

	<tr>
		<td class="thinfield">Email Header Image URL:</td>
		<td class="thinfield"><?php echo $GPOResponse->displayOptions->emailHeaderImageUrl ; ?></td>

	</tr>
	<tr>
		<td class="thinfield">Email Marketing Image URL:</td>
		<td class="thinfield"><?php echo $GPOResponse->displayOptions->emailMarketingImageUrl ; ?></td>
	</tr>
	<tr>
		<td class="thinfield">InstitutionId:</td>
		<td class="thinfield"><?php echo $GPOResponse->initiatingEntitity->institutionCustomer->institutionId ; ?></td>

	</tr>
	<tr>
		<td class="thinfield">Institution CustomerId:</td>
		<td class="thinfield"><?php echo $GPOResponse->initiatingEntitity->institutionCustomer->institutionCustomerId ; ?></td>
	</tr>
	<tr>
		<td class="thinfield">Email:</td>
		<td class="thinfield"><?php echo $GPOResponse->initiatingEntitity->institutionCustomer->email ; ?></td>

	</tr>

	<tr>
		<td class="thinfield">Country Code:</td>
		<td class="thinfield"><?php echo $GPOResponse->initiatingEntitity->institutionCustomer->countryCode ; ?></td>
	</tr>
	<tr>
		<td class="thinfield">Display Name:</td>
		<td class="thinfield"><?php echo $GPOResponse->initiatingEntitity->institutionCustomer->displayName ; ?></td>

	</tr>
	<tr>
		<td class="thinfield">First Name:</td>
		<td class="thinfield"><?php echo $GPOResponse->initiatingEntitity->institutionCustomer->firstName ; ?></td>
	</tr>
	<tr>
		<td class="thinfield">Last Name:</td>

		<td class="thinfield"> <?php echo $GPOResponse->initiatingEntitity->institutionCustomer->lastName ; ?></td>
	</tr>
</table>




</div>
</div>
</body>
</html>

			<?php
			

		}

	}
}

	
catch(Exception $ex) {

	$fault = new FaultMessage();
	$errorData = new ErrorData();
	$errorData->errorId = $ex->getFile() ;
	$errorData->message = $ex->getMessage();
	$fault->error = $errorData;
	$_SESSION['FAULTMSG']=$fault;
	$location = "APIError.php";
	header("Location: $location");
}

?>
