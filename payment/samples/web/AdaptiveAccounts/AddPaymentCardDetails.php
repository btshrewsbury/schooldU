<?php

/******************************************************
AddPaymentCardDetails.php

This page is specified as the ReturnURL for the AddPaymentCard Operation.
When returned from PayPal this page is called.
******************************************************/

require_once '../../../lib/AdaptivePayments.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php';

session_start();
	
	try {	
			$APCdetail = new AddPaymentCardResponse();
			$APCdetail=$_SESSION['CardAdded'];
			
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

  <title>PayPal PHP SDK -Add Payment Card Details</title>
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
  
    <h3><b>Add Payment Card Details</b></h3><br>
    <br>

    <table align="center" width="70%">
		<tr>
        <td class="thinfield2">Status:</td>
        <td class="thinfield3"><?php echo $APCdetail->execStatus ?></td>

   
    </tr>   
		<tr>
        <td class="thinfield2">Funding Source Key:</td>
        <td class="thinfield3"><?php echo $APCdetail->fundingSourceKey  ?></td>

   
    </tr>
    
		  
    
     </table>
 </div>
 </div>
</body>
</html>
