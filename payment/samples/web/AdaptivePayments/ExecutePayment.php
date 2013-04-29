<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>PayPal Platform SDK - ExecutePayment</title>

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
<h3>Pay - Create, Set, Execute API Flow</h3>
	<h3>Adaptive Payments-Execute Payment</h3>
 <form id="Form1" name="Form1"  method="post" action="ExecutePaymentReceipt.php">
<br/>

  <table class="api">
	<tr>
	    <td class="thinfield">Pay Key:</td>
		<td><input type="text" size="30" maxlength="32" name="payKey"
			value="<?php echo $_GET['payKey'];?>" /></td>
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

