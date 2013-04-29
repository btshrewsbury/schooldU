<?php

/********************************************
AddPaymentCardReceipt.php

Called by AddPaymentCard.php
Calls  AdaptiveAccounts.php,and APIError.php.
********************************************/

require_once '../../../lib/AdaptiveAccounts.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php' ;
require_once 'web_constants.php';
session_start();

		try {
		     	
		     	$emailid = $_REQUEST["emailid"]; 
		     	$cardtype=$_REQUEST["creditCardType"];  
		     	$cardNumber =$_REQUEST["cardNumber"];  
		        $confirmationType=$_REQUEST["confirmationType"];
		        $createAccountKey=$_REQUEST["createAccountKey"];
		        $cardVerificationNumber=$_REQUEST["cardVerificationNumber"];
		         
		        $expirationDate= new CardDateType();
		        $expirationDate->month =$_REQUEST["expDateMonth"];
		        $expirationDate->year=$_REQUEST["expDateYear"];
		        
		        $nameOnCard= new NameType();
		        $nameOnCard->firstName=  $_REQUEST["firstName"];
		        $nameOnCard->lastName=   $_REQUEST["lastName"];
		        
		         $bAddress = new AddressType();
		        $bAddress->line1=$_REQUEST["address1"];
		        $bAddress->line2=$_REQUEST["address2"];
		        $bAddress->city=$_REQUEST["city"];
		        $bAddress->state=$_REQUEST["state"];
		        $bAddress->postalCode=$_REQUEST["zip"];
		        $bAddress->countryCode=$_REQUEST["countryCode"];
		       
		        
				$APCRequest = new AddPaymentCardRequest();
		       	$APCRequest->cardNumber = $cardNumber;
		        $APCRequest->confirmationType = $confirmationType;
		        $APCRequest->bankAccountType=$accounttype;
		        $APCRequest->emailAddress = $emailid;
		        $APCRequest->cardType=$cardtype;
		        $APCRequest->expirationDate= $expirationDate;
		       $APCRequest->createAccountKey=$createAccountKey;
		       $APCRequest->cardVerificationNumber=$cardVerificationNumber;
		       
		        
		        $APCRequest->billingAddress=$bAddress;
		        $APCRequest->nameOnCard=$nameOnCard;
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$APCRequest->requestEnvelope = $rEnvelope ;
		      
		       	
		       	$serverName = $_SERVER['SERVER_NAME'];
		        $serverPort = $_SERVER['SERVER_PORT'];
		        $url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);
		        $returnURL = $url."/AddPaymentCardDirectDetails.php";
				$cancelURL = $url. "/AddPaymentCardDirect.php" ;
				$cancelUrlDescription ="cancelurl";
		 	    $returnUrlDescription ="returnurl";
				
		        
		        $aa = new AdaptiveAccounts();
		       	//$aa->sandBoxEmailAddress = $sandboxEmail;
				$response=$aa->AddPaymentCard($APCRequest);
				
				if(strtoupper($aa->isSuccess) == 'FAILURE')
				{
					$_SESSION['FAULTMSG']=$aa->getLastError();
					$location = "APIError.php";
					header("Location: $location");
				
				}
				else {
					
										
					$location = "AddPaymentCardDirectDetails.php";
				
						$_SESSION['CardAdded'] = $response;
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
	
       
?>
