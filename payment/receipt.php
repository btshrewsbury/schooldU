<?php
/******************************************************
PreapprovalDetails.php

This page is specified as the ReturnURL for the Preapproval Operation.
When returned from PayPal this page is called.
Page get the payment details for the preapprovalKey either stored
in the session or passed in the Request.

******************************************************/

require_once 'lib/AdaptivePayments.php';
require_once 'lib/Stub/AP/AdaptivePaymentsProxy.php';
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");

session_start();
	
	if(isset($_GET['cs'])) {
		$_SESSION['preapprovalKey'] = '';
	}

	try {
			if(isset($_REQUEST["preapprovalKey"])){
			$preapprovalKey = $_REQUEST["preapprovalKey"];
			}
			if(empty($preapprovalKey))
			{
				$preapprovalKey = $_SESSION['preapprovalKey'];
			}
			
			$PDRequest = new PreapprovalDetailsRequest();
			
			$PDRequest->requestEnvelope = new RequestEnvelope();
			$PDRequest->requestEnvelope->errorLanguage = "en_US";
			$PDRequest->preapprovalKey = $preapprovalKey; 
			
			$ap = new AdaptivePayments();
			$response = $ap->PreapprovalDetails($PDRequest);
			
			
			/* Display the API response back to the browser.
			   If the response from PayPal was a success, display the response parameters'
			   If the response was an error, display the errors received using APIError.php.
			*/
				if(strtoupper($ap->isSuccess) == 'FAILURE')
				{
					$_SESSION['FAULTMSG']=$ap->getLastError();
					$location = "APIError.php";
					header("Location: $location");
				
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
	
	$me = getMe();
	$me->set_paypal_pa($preapprovalKey);
	$me->set_paypal_email($_SESSION['paypalEmail']);
	$me->save();
	$location = "https://schooldu.com/payment.php";
	header("Location: $location");
?>
