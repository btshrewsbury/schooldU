<?php

/******************************************************
SetFundingSourceConfirmedDetails.php

This page is specified as the ReturnURL for the SetFundingSourceConfirmed Operation.
When returned from PayPal this page is called.

******************************************************/

require_once '../../../lib/AdaptivePayments.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php';

session_start();
	
	try {	
			$SFSCdetail = new SetFundingSourceConfirmedResponse();
			$SFSCdetail=$_SESSION['FundingSourceConfirmed'];
			
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


  <title>PayPal PHP SDK -SetFundingSourceConfirmed Details</title>
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

    <h3><b>SetFundingSourceConfirmed
    Details</b></h3><br>
    <br>

    <table align="center">
		<tr>
        <td class="thinfield">Status:</td>
        <td class="thinfield" ><?php echo $SFSCdetail->responseEnvelope->ack ?></td>

   
    </tr>   
		<tr>
        <td class="thinfield">timestamp:</td>
        <td class="thinfield"><?php echo $SFSCdetail->responseEnvelope->timestamp  ?></td>

   
    </tr>
   
		<tr>
        <td class="thinfield">correlationId:</td>
        <td class="thinfield"><?php echo $SFSCdetail->responseEnvelope->correlationId ?></td>

   
    </tr>   
 
		<tr>
        <td class="thinfield">build:</td>
        <td class="thinfield"><?php echo $SFSCdetail->responseEnvelope->build ?></td>

   
    </tr>   
		  
    
     </table>
 </div>
 </div>
</body>
</html>