<?php
/***********************************************************
Refund.php

This page demonstrates Refund Operation/API.
Called by index.html.       

***********************************************************/
// clearing the session before starting new API Call
session_unset();    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
 
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

      <form id="Form1" name="Form1"action="RefundReceipt.php" method="post">
      <table align="center">
        <tr>
          <h3>Adaptive Payments - Refund</h3>
        </tr>

       <tr>
        <td class="thinfield">Pay Key:</td>
        <td><input type="text" size="50" maxlength="32" name="payKey"
            value="" /></td>
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
    <TR>
        <TD class="thinfield" height="14" colSpan="3">
        <P align="center">Refund Details</P>
        </TD>
    </TR>
    <tr>
        <td class="thinfield"  width="52">Receivers</td>
        <td class="thinfield" >ReceiverEmail (Required):</td>
        <td class="thinfield" >Amount(Required):</td>

    </tr>
    <tr>
        <td width="52">
        <P align="right">1</P>
        </td>
        <td><input type="text" name="receiveremail" size="50"
            value="platfo_1255611349_biz@gmail.com"></td>
        <td><input type="text" name="amount" size="5" maxlength="7"
            value="1.00"></td>   
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