<?php

/********************************************
CreateAccountdetail.php
Calls CreateAccount API of CreateAccounts webservices.

Called by CreateAccount_____receipt.php
Calls  AdaptiveAccounts.php,and APIError.php.
********************************************/

require_once '../../../lib/AdaptiveAccounts.php';
require_once '../../../lib/Stub/AA/AdaptiveAccountsProxy.php' ;

session_start();
$response = $_SESSION['createdAccount'];       
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
<h3><b>Account Creation Confirmation</b></h3> <br>
<br>
<center>
<h5>Account Created!</h5><br>
</center>
<br>
<table align="center" width="60%">
    <tr>
        <td class="thinfield">CorrelationId:</td>
        <td class="thinfield"><?php echo $response->responseEnvelope->correlationId ?></td>
    </tr>
    <tr>
        <td class="thinfield">CreatedAccountKey:</td>
        <td class="thinfield"><?php echo $response->createAccountKey ?></td>
    </tr>
    <tr>
        <td class="thinfield">Status:</td>
        <td class="thinfield"><?php echo $response->execStatus ?></td>
    </tr>
   <?php  if(!empty($response->accountId))
    {
    ?>	
   
    <tr>
        <td class="thinfield">Account Id:</td>
        <td class="thinfield"><?php echo $response->accountId ?></td>
    </tr>
    <?php }?>
</table>


</div>
</div>
</body>
</html>