<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
GetPaymentDetails.html

This is the main page for GetCancelPreapproval sample.
This page displays a text box where the user enters a
PayKey and a Submit button. Upon clicking submit button
CancelPreapprovalReceipt.php is called.  Called by index.html.

Calls PaymentDetails.php.

-->
<html>
<head>
    <title>PayPal Platform SDK - AdaptivePayments API</title>
   <link href="common/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
 <br/>
        <div id="jive-wrapper">
            <div id="jive-header">
                <div id="logo">
                    
                    <a title="Paypal X Home" href="#"><div id="titlex"></div></a>
                </div>
            </div>

<div id="main">
<?php include 'menu.html'?>
<div id="request_form">   
    <h3>Cancel Preapproval</h3> 
     <br><br>
    <form id="Form1" name="Form1" action="CancelPreapprovalReceipt.php?cs=s" method="post">
        <table align="center">
            <tr>
                <td class="thinfield">
                    PreapprovalKey:
                </td>
                <td class="thinfield">
                    <input type="text" name="preapprovalKey" value="" />
                    </td>
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