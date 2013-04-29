<?php

/********************************************
AddBankAccountReceipt.php


Called by AddBankAccount.php
Calls  AdaptiveAccounts.php,and APIError.php.
********************************************/

require_once '../../../lib/AdaptiveAccounts.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php' ;
require_once 'web_constants.php';
session_start();

		try {
		
		       $bankCountryCode = $_REQUEST["bankCountryCode"];
		       $bankName=$_REQUEST["bankName"];
		       $routingNumber=$_REQUEST["routingNumber"];
		       $bankAccountNumber=$_REQUEST["bankAccountNumber"];
		     	$confirmationType = $_REQUEST["confirmationType"];	 
		     	$emailid = $_REQUEST["emailid"]; 
		     	$accounttype=$_REQUEST["accounttype"];    
		       /* Make the call to PayPal to Add bank as funding source on behalf of the caller
		        If an error occured, show the resulting errors
		        */
		       	$ABARequest = new AddBankAccountRequest();
		       
		
		       	$ABARequest->bankCountryCode = $bankCountryCode;
		       	$ABARequest->bankName = $bankName;
		       	$ABARequest->routingNumber = $routingNumber;
		       	$ABARequest->bankAccountNumber = $bankAccountNumber;
		        $ABARequest->confirmationType = $confirmationType;
		        $ABARequest->bankAccountType=$accounttype;
		        $ABARequest->emailAddress = $emailid;
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$ABARequest->requestEnvelope = $rEnvelope ;
		      
		       	
		       	$serverName = $_SERVER['SERVER_NAME'];
		        $serverPort = $_SERVER['SERVER_PORT'];
		        $url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);
		        $returnURL = $url."/AddBankAccountDetails.php";
				$cancelURL = $url. "/AddBankAccount.php" ;
				$cancelUrlDescription ="cancelurl";
		 	    $returnUrlDescription ="returnurl";
				$weboptions= new WebOptionsType();
		        $weboptions->returnUrl = $returnURL;
		        $weboptions->cancelUrl = $cancelURL;
		        $weboptions->returnUrlDescription =$returnUrlDescription;
		        $weboptions->cancelUrlDescription =$cancelUrlDescription;
		        $ABARequest->webOptions = $weboptions;
		        
		        $aa = new AdaptiveAccounts();
		       	//$aa->sandBoxEmailAddress = $sandboxEmail;
				$response=$aa->AddBankAccount($ABARequest);
				
				if(strtoupper($aa->isSuccess) == 'FAILURE')
				{
					$_SESSION['FAULTMSG']=$aa->getLastError();
					$location = "APIError.php";
					header("Location: $location");
				
				}
				else {
					
										
					$location = $response->redirectURL;
				if(!empty($location)) {
						$_SESSION['BankAdded'] = $response;
						header("Location: $location");	
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
