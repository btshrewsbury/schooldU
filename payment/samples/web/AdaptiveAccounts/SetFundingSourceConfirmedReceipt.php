<?php

/********************************************
SetFundingSourceConfirmedReceipt.php

Called by SetFundingSourceConfirmed.php
Calls  AdaptiveAccounts.php,and APIError.php.
********************************************/

require_once '../../../lib/AdaptiveAccounts.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php' ;
require_once 'web_constants.php';
session_start();

		try {
		     	
		     	$emailid = $_REQUEST["emailid"]; 
		      
		        $fundingSourceKey = $_REQUEST["fundingSourceKey"];
				$SFSCRequest = new SetFundingSourceConfirmedRequest();
	
		        $SFSCRequest->fundingSourceKey = $fundingSourceKey;
		        $SFSCRequest->emailAddress = $emailid;
		       
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$SFSCRequest->requestEnvelope = $rEnvelope ;
		           
		        $aa = new AdaptiveAccounts();
		       	//$aa->sandBoxEmailAddress = $sandboxEmail;
				$response=$aa->SetFundingSourceConfirmed($SFSCRequest);
				
				if(strtoupper($aa->isSuccess) == 'FAILURE')
				{
					$_SESSION['FAULTMSG']=$aa->getLastError();
					$location = "APIError.php";
					header("Location: $location");
				
				}
				else {
					
										
					$location = "SetFundingSourceConfirmedDetails.php";
			
						$_SESSION['FundingSourceConfirmed'] = $response;
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
