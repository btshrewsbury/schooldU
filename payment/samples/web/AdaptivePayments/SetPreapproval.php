<?php
/***********************************************************
SetPreapproval.php

Begining of the Preapproval web flow

Called by index.html.

***********************************************************/
// clearing the session before starting new API Call
require_once 'web_constants.php';
session_unset();

$currDate = getdate();
$startDate = $currDate['year'].'-'.$currDate['mon'].'-'.$currDate['mday'];
$startDate = strtotime($startDate);
$startDate = date('Y-m-d', mktime(0,0,0,date('m',$startDate),date('d',$startDate),date('Y',$startDate)));
$endDate = add_date($startDate, 1);

function add_date($orgDate,$yr){
	  $cd = strtotime($orgDate);
	  $retDAY = date('Y-m-d', mktime(0,0,0,date('m',$cd),date('d',$cd),date('Y',$cd)+$yr));
	  return $retDAY;
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
  <meta name="generator" content=
  "HTML Tidy for Windows (vers 14 February 2006), see www.w3.org">

  <title>PayPal Platform - Pay Center- Samples</title>
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
 
 <form id="Form1" name="Form1" action="PreapprovalReceipt.php" method="post">
      <table class="api">
        <tr><td>
          <h3>Adaptive Payments -
          Preapproval</h3></td>
        </tr>

       
      </table>

      <table align="center">
       <tr>
        <td class="thinfield">Sender's Email:</td>
        <td><input type="text" size="50" maxlength="64" name="senderEmail"
            value="platfo_1255076101_per@gmail.com" /></td>
    </tr>
   <tr>
        <td class="thinfield">Starting date:</td>
        <td><input type="text" size="50" maxlength="32" name="startingDate"
            value="<?php echo $startDate; ?>" /></td>
    </tr>
    <tr>
        <td class="thinfield">Ending date:</td>
        <td><input type="text" size="50" maxlength="32" name="endingDate"
            value="<?php echo $endDate ;?>" /></td>
    </tr>
    <tr>
        <td class="thinfield">Maximum Number of Payments:</td>
        <td><input type="text" size="50" maxlength="32" name="maxNumberOfPayments"
            value="10" /></td>
    </tr>
    <tr>
        <td class="thinfield">Maximum Total Amount:</td>
        <td><input type="text" size="50" maxlength="32" name="maxTotalAmountOfAllPayments"
            value="50.00" /></td>
    </tr>
    <tr>
        <td class="thinfield" width="52">currencyCode:</td>
        <td><select name="currencyCode">
            <option value="USD" selected>USD</option>
            <option value="GBP">GBP</option>
            <option value="EUR">EUR</option>
            <option value="JPY">JPY</option>
            <option value="CAD">CAD</option>
            <option value="AUD">AUD</option>
        </select></td>
    </tr>

    <tr>
	<td>
	<br />
	</td>
	</tr>

	<tr align="center">
<td colspan="2">
<a class="pop-button primary" onclick="document.Form1.submit();" id="Submit"><span>Submit</span></a>
			</td>
		</tr>
      </table>
    </form>
 </div>
 </div>
</body>
</html>