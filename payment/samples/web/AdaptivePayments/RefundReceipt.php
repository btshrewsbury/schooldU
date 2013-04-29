<?php

/********************************************
RefundReceipt.php
Displays refund status after calling Refund API
Called by Refund.php
Calls  AdaptivePayments.php,and APIError.php.
********************************************/

require_once '../../../lib/AdaptivePayments.php';
require_once '../../../lib/Stub/AP/AdaptivePaymentsProxy.php';
require_once 'web_constants.php';

session_start();
		try {

			$currencyCode=$_REQUEST["currencyCode"];
	       	$payKey=$_REQUEST["payKey"];
			$email=$_REQUEST["receiveremail"];
			$amount = $_REQUEST["amount"];
			
	       /* Make the call to PayPal to get the Pay token
	        If the API call succeded, then redirect the buyer to PayPal
	        to begin to authorize payment.  If an error occured, show the
	        resulting errors
	        */
	       	$refundRequest = new RefundRequest();
	       	$refundRequest->currencyCode = $currencyCode;
	       	$refundRequest->payKey = $payKey;
			$refundRequest->requestEnvelope = new RequestEnvelope();
	        $refundRequest->requestEnvelope->errorLanguage = "en_US";
	        
	        $refundRequest->receiverList = new ReceiverList();
	        $receiver1 = new Receiver();
	        $receiver1->email = $email;
	        $receiver1->amount = $amount; 
	        $refundRequest->receiverList->receiver = $receiver1 ;
	        
	        $ap = new AdaptivePayments();
	        $response=$ap->Refund($refundRequest);
	           
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
    <title>PayPal PHP SDK - AdaptivePayments Refund</title>
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
    <h3> <b>Refund details!</b></h3>
    <table align="center">
        <tr>
            <td class="thinfield">Refund Status:</td>
            <td class="thinfield"><?php 
            		if(is_array($response->refundInfoList->refundInfo)) {
            			echo $response->refundInfoList->refundInfo[0]->refundStatus ;
            		}else {
            			echo $response->refundInfoList->refundInfo->refundStatus ;	
            		}
            		 
            
            	?></td>
        </tr>
        <tr>
            <td class="thinfield">Receiver:</td>
            <td class="thinfield"><?php  
            		if(is_array($response->refundInfoList->refundInfo)) {
            			echo $response->refundInfoList->refundInfo[0]->receiver->email ;
            		}else {
            			echo $response->refundInfoList->refundInfo->receiver->email ;	
            		}
            	?></td>
        </tr>
        <tr>
            <td class="thinfield">Net Refund Amount:</td>
            <td class="thinfield"><?php   
            		if(is_array($response->refundInfoList->refundInfo)) {
            			echo $response->refundInfoList->refundInfo[0]->refundNetAmount ;
            		}else {
            			echo $response->refundInfoList->refundInfo->refundNetAmount ;	
            		}
            	?></td>
        </tr>

    </table>
    </div>
    </div>
</body>
</html>