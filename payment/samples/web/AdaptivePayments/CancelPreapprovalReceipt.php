<?php

/******************************************************
CancelPreapprovalReceipt.php

Page get the preapprovalKey either stored
in the session or passed in the Request.

******************************************************/

require_once '../../../lib/AdaptivePayments.php';
require_once '../../../lib/Stub/AP/AdaptivePaymentsProxy.php';

session_start();

	if(isset($_GET['cs'])) {
		$_SESSION['preapprovalKey'] = '';
	}
	try {
		
		$preapprovalKey = $_REQUEST["preapprovalKey"];
		if(empty($preapprovalKey))
		{
			$preapprovalKey = $_SESSION['preapprovalKey'];
		}
		
		$CPRequest = new CancelPreapprovalRequest();
		
		$CPRequest->requestEnvelope = new RequestEnvelope();
		$CPRequest->requestEnvelope->errorLanguage = "en_US";
		$CPRequest->preapprovalKey = $preapprovalKey; 
		
		$ap = new AdaptivePayments();
		$response = $ap->CancelPreapproval($CPRequest);
		
		
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
<table align="center" width="50%">
<tr>
		<h3><b>Cancel Preapproval
    </b></h3>
</tr>
   
		
		<tr>
        <td class="thinfield">Transaction Status:</td>
        <td class="thinfield"><?php echo $response->responseEnvelope->ack ; ?></td>
    </tr> 	
      <tr>
        <td class="thinfield">CorrelationId:</td>
        <td class="thinfield"><?php echo $response->responseEnvelope->correlationId ; ?></td>
    </tr>
    </table>
 </div>
</body>
</html>