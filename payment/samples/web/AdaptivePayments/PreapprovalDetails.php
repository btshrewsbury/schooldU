<?php
/******************************************************
PreapprovalDetails.php

This page is specified as the ReturnURL for the Preapproval Operation.
When returned from PayPal this page is called.
Page get the payment details for the preapprovalKey either stored
in the session or passed in the Request.

******************************************************/

require_once '../../../lib/AdaptivePayments.php';
require_once '../../../lib/Stub/AP/AdaptivePaymentsProxy.php';

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta name="generator" content=
  "HTML Tidy for Windows (vers 14 February 2006), see www.w3.org">

  <title>PayPal PHP SDK -Payment Details</title>
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
 
    <h3><b>Preapproval
    Details</b></h3><br>
    <br>

    <table align="center">
		
		<tr>
        <td class="thinfield" >Preapproval Key:</td>
        <td class="thinfield"><?php echo $preapprovalKey ?></td>
    </tr> 	
      <tr>
        <td class="thinfield">CurPaymentsAmount:</td>
        <td class="thinfield"><?php echo $response->curPaymentsAmount ?></td>
    </tr>
    <tr>
        <td class="thinfield">Status:</td>
        <td class="thinfield"><?php echo $response->status ?></td>
    </tr>
    <tr>
        <td class="thinfield">curPeriodAttempts:</td>
        <td class="thinfield"><?php echo $response->curPeriodAttempts ?></td>
    </tr>
    <tr>
        <td class="thinfield">Approved status:</td>
        <td class="thinfield"><?php echo $response->approved ?></td>
    </tr>
    </table>
 </div>
 </div> 
</body>
</html>