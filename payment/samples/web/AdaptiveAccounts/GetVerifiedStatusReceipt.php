<?php

/********************************************
GetVerifiedStatus.php


Called by calls.html
Calls  AdaptiveAccounts.php,and APIError.php.
********************************************/

require_once '../../../lib/AdaptiveAccounts.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php' ;
require_once 'web_constants.php';
session_start();

		try {
		
		       $emailid = $_REQUEST["emailid"];
		       $firstName=$_REQUEST["firstName"];
		       $lastname=$_REQUEST["lastname"];
		       $city=$_REQUEST["city"];
		     		       
		       /* Make the call to PayPal to get the status of an account
		        If an error occured, show the resulting errors
		        */
		       	$VstatusRequest = new GetVerifiedStatusRequest();
		       
		
		       	$VstatusRequest->emailAddress = $emailid;
		       	$VstatusRequest->matchCriteria = $city;
		       	$VstatusRequest->firstName = $firstName;
		       	$VstatusRequest->lastName = $lastname;
		      
		       	$rEnvelope = new RequestEnvelope();
				$rEnvelope->errorLanguage = "en_US";
		       	$VstatusRequest->requestEnvelope = $rEnvelope ;
		     
		       	$serverName = $_SERVER['SERVER_NAME'];
		        $serverPort = $_SERVER['SERVER_PORT'];
		       
		        $aa = new AdaptiveAccounts();
		       	//$aa->sandBoxEmailAddress = $sandboxEmail;
				$response=$aa->GetVerifiedStatus($VstatusRequest);
				
				if(strtoupper($aa->isSuccess) == 'FAILURE')
				{
					$_SESSION['FAULTMSG']=$aa->getLastError();
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
	
       
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
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
<div id="request_form">
<h3>Account Verified Status</h3> <br>
<br>

<br>
<table align="center">
    <tr>
        <td class="field">accountStatus:</td>
        <td class="field"><?php echo $response->accountStatus ?></td>
    </tr>
   
</table>


</div>
</div>
</body>
</html>