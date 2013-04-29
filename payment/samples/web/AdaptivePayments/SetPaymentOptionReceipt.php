<?php

/********************************************
 SetPaymentOptionReceipt.php

 This file is called after the user clicks on a button during
 the Pay process to use PayPal's AdaptivePayments Pay features'. The
 user logs in to their PayPal account.
 Called by SetPaymentOption.php
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
	 
	$SetPaymentOptionsRequest = new SetPaymentOptionsRequest();
	$SetPaymentOptionsRequest->requestEnvelope = new RequestEnvelope();
	$SetPaymentOptionsRequest->requestEnvelope->errorLanguage = "en_US";
	$SetPaymentOptionsRequest->payKey = $payKey;
	 
	if((!empty($_REQUEST['institutionId']))|(!empty($_REQUEST['firstName']))|(!empty($_REQUEST['lastName']))|(!empty($_REQUEST['displayName']))|(!empty($_REQUEST['institutionCustomerId']))|(!empty($_REQUEST['countryCode']))|(!empty($_REQUEST['email'])))
	{

		$SetPaymentOptionsRequest->initiatingEntity = new InitiatingEntity();
		$SetPaymentOptionsRequest->initiatingEntity->institutionCustomer = new InstitutionCustomer();
		$SetPaymentOptionsRequest->initiatingEntity->institutionCustomer->institutionId = $_REQUEST['institutionId'];
		 
		$SetPaymentOptionsRequest->initiatingEntity->institutionCustomer->firstName = $_REQUEST['firstName'];
		$SetPaymentOptionsRequest->initiatingEntity->institutionCustomer->lastName = $_REQUEST['lastName'];
		$SetPaymentOptionsRequest->initiatingEntity->institutionCustomer->displayName = $_REQUEST['displayName'];
		$SetPaymentOptionsRequest->initiatingEntity->institutionCustomer->institutionCustomerId = $_REQUEST['institutionCustomerId'];
		$SetPaymentOptionsRequest->initiatingEntity->institutionCustomer->countryCode = $_REQUEST['countryCode'];
		$SetPaymentOptionsRequest->initiatingEntity->institutionCustomer->email = $_REQUEST['email'];
	}
	$SetPaymentOptionsRequest->displayOptions = new DisplayOptions();
	$SetPaymentOptionsRequest->displayOptions->emailHeaderImageUrl = $_REQUEST['emailHeaderImageUrl'];
	$SetPaymentOptionsRequest->displayOptions->emailMarketingImageUrl = $_REQUEST['emailMarketingImageUrl'];

	 
	 
	 
	 
	 
	 
		
	/* Make the call to PayPal to get the Pay token
	 If the API call succeded, then redirect the buyer to PayPal
	 to begin to authorize payment.  If an error occured, show the
	 resulting errors
	 */
	$ap = new AdaptivePayments();
	$response=$ap->SetPaymentOptions($SetPaymentOptionsRequest);
	 
	if(strtoupper($ap->isSuccess) == 'FAILURE')
	{
		$_SESSION['FAULTMSG']=$ap->getLastError();
		$location = "APIError.php";
		header("Location: $location");
			
	}
	else
	{
		$_SESSION['payKey'] = $response->payKey;
		if($response->responseEnvelope->ack == "Success")
		{
			if(isset($_GET['cs'])) {
				$_SESSION['payKey'] = '';
			}
				
			if(isset($_REQUEST["payKey"])){
				$payKey = $_REQUEST["payKey"];}
				if(empty($payKey))
				{
					$payKey = $_SESSION['payKey'];
				}
				?>
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title>PayPal Platform SDK - Set Payment Option</title>
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
	<h3>Set Payment Options - Response</h3>

<br />

<table align="center" width="50%">
	<tr>
		<td class="thinfield">Ack:</td>
		<td class="thinfield"><?php echo $response->responseEnvelope->ack ; ?></td>
	</tr>
	<tr>
		<td class="thinfield"> CorrelationId:</td>

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
</table>
<br />
<table align="center">
	<tr>
		

		<td class="thinfield"><a href="ExecutePayment.php?payKey=<?php echo $payKey ; ?>">* Execute
		Payment</a></td>
	</tr>
</table>
</div>
</div>
</body>
</html>

				<?php
				/* Display the API response back to the browser.
				 If the response from PayPal was a success, display the response parameters'
				 If the response was an error, display the errors received using APIError.php.
				 */
					

					





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