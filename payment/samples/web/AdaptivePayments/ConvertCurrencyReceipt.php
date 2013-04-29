<?php

/******************************************************
ConvertCurrencyReceipt.php
Displays the Currency conversion details after calling the
ConvertCurrency API.
Called by SetConvertCurrency.php 
Calls  AdaptivePayments.php,and APIError.php.
******************************************************/

require_once '../../../lib/AdaptivePayments.php';
require_once '../../../lib/Stub/AP/AdaptivePaymentsProxy.php';

session_start();

	try {
		$fromCurrencyCode = $_REQUEST['fromcode'];
		$toCurrencyCode = $_REQUEST['tocode'];
		$amountItems = $_REQUEST['baseamount'];
		
		$CCRequest = new ConvertCurrencyRequest();
		$list = new CurrencyList();
		
		for($i = 0; $i<count($_POST['baseamount']);$i++)
		{	
			$ccType = new CurrencyType();
			$ccType->amount = $_REQUEST['baseamount'][$i];
			$ccType->code = $_REQUEST['fromcode'][$i];
			$list->currency[] = $ccType;
			
		}
		
		$clist =new CurrencyCodeList();
		for($i = 0; $i<count($_POST['tocode']);$i++)
		{
			$clist->currencyCode[] =  $_REQUEST['tocode'][$i];
		}
		
		$CCRequest->baseAmountList = $list;
		$CCRequest->convertToCurrencyList = $clist;
		
		$CCRequest->requestEnvelope = new RequestEnvelope();
		$CCRequest->requestEnvelope->errorLanguage = "en_US";
		
		$ap = new AdaptivePayments();
		$response = $ap->ConvertCurrency($CCRequest,$SerializeOption='simplexml');
		
		
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		*/
		if(empty($response->estimatedAmountTable))
		{
			echo "<center><br><br><b>Invalid response from server</b><br></center>";
			echo"<center><a  href='Calls.html'>Home</a></center>";
			exit();
		}
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
    <h3><b>Currency Conversion
    Details</b></h3><br>
    <br>

    <table width="70%" align="center">
	
		<?php 
			foreach($response->estimatedAmountTable->currencyConversionList as $CC) {
				
				echo "<tr><td class=\"thinfield\">";

				foreach($CC->currencyList->currency as $C) {
					echo $C->code . ' ' . $C->amount . ' ' ;
				}
				
				echo "</td></tr>";
			}
			
		?>
	</table>
</div>
</div>
</body>
</html>