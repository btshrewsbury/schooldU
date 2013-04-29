<?php

/********************************************
 ExecutePaymentReceipt.php

 This file is called after the user clicks on a button during
 the Pay process to use PayPal's AdaptivePayments Pay features'. The
 user logs in to their PayPal account.
 Called by ExecutePayment.php
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

	$executePaymentRequest = new ExecutePaymentRequest();
	$executePaymentRequest->payKey = $payKey;

	$executePaymentRequest->requestEnvelope = new RequestEnvelope();
	$executePaymentRequest->requestEnvelope->errorLanguage = "en_US";
	$ap = new AdaptivePayments();
	$response=$ap->ExecutePayment($executePaymentRequest);

	if(strtoupper($ap->isSuccess) == 'FAILURE')
	{
		$_SESSION['FAULTMSG']=$ap->getLastError();
		$location = "APIError.php";
		header("Location: $location");
			
	}
	else
	{
		if($response->paymentExecStatus == "COMPLETED")
		{
			if($response->responseEnvelope->ack == "Success")
			{
				?>
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title>PayPal Platform SDK - Execute Payment Options</title>
<link href="common/style.css" rel="stylesheet" type="text/css" />
</head>
<body >
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
<div id="request_form">
<h3>Pay - Create, Set, Execute API Flow</h3>
	<h3>Execute Payment Receipt</h3>


<br />

<table align="center">
	<tr>
		<td class="thinfield">paymentExecStatus:    </td>
		<td class="thinfield"><?php echo $response->paymentExecStatus ; ?></td>
	</tr>
	<tr>
		<td class="thinfield">Ack:</td>
		<td class="thinfield"><?php echo $response->responseEnvelope->ack ; ?></td>
	</tr>
	<tr>
		<td class="thinfield">CorrelationId:</td>

		<td class="thinfield"><?php echo $response->responseEnvelope->correlationId ; ?></td>
	</tr>
	<tr>
		<td class="thinfield">TimeStamp:</td>
		<td class="thinfield"><?php echo $response->responseEnvelope->timestamp ; ?></td>
	</tr>
	<tr>

		<td class="thinfield">Build:</td>
		<td class="thinfield"><?php echo $response->responseEnvelope->build ; ?></td>
	</tr>
</table align="center">
 <table align="center">
   <tr>
  
      <td class="thinfield"><a href="GetPaymentDetails.php?payKey=<?php echo $payKey; ?>">* Get Payment Details</a></td>
    </tr>
 </table>

<br />

</div>
</div>
</body>
</html>

				<?php

			}

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
