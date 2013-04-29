<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
SetConvertCurrency.php

This is the main page for ConvertCurrency sample.
This page displays a text box where the user enters currency conversion details
and a Submit button. Upon clicking submit button
ConvertCurrencyReceipt.php is called.  Called by index.html.


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
                    <span >You must be Logged in to <a href="<?php echo DEVELOPER_PORTAL;?>" target="_blank">PayPal sandbox</a></span>
                    <a title="Paypal X Home" href="#"><div id="titlex"></div></a>
                </div>
            </div>

<div id="main">
<?php include 'menu.html'?>
 <div id="request_form">    
  <form id="Form1" name="Form1" method="post" action="ConvertCurrencyReceipt.php">
	
	<table align="center">
		<tr>
			<h3>Adaptive Payments - ConvertCurrency</h3>
		</tr>	
		<tr>
			<td class="thinfield" width="52">ConversionDetails</td>
			<td class="thinfield">Amount(Required):</td>
			<td class="thinfield"> FromCurrencyCode(Required):</td>		
		</tr>
		<tr>
			<td class="thinfield" width="52">
			<P align="right">1</P>
			</td>
			<td class="thinfield"><input type="text" name="baseamount[]" 
				value="1.00"></td>
			<td class="thinfield"><input type="text" name="fromcode[]"  
				value="GBP"></td>
				
		</tr>		
		<tr>
			<td class="thinfield" width="52">
			<P align="right">2</P>
			</td>				
			<td class="thinfield"><input type="text" name="baseamount[]" 
				value="100.00"></td>
			<td class="thinfield"><input type="text" name="fromcode[]"  
				value="EUR"></td>				
		    </tr>
		<tr>
			<td class="thinfield" width="52">convertToCurrencyList</td>		
			<td class="thinfield">ToCurrencyCode(Required):</td>		
		</tr>
		<tr>	
		<td class="thinfield" width="52">
			<P align="right">1</P>
			</td>	
			<td class="thinfield"><input type="text" name="tocode[]"  
				value="USD"></td>			
		</tr>
		<tr>	
		   <td class="thinfield" width="52">
			<P align="right">2</P>
			</td>	
			<td class="thinfield"><input type="text" name="tocode[]"  
				value="CAD"></td>			
		</tr>		
		<tr>	
		   <td class="thinfield" width="52">
			<P align="right">3</P>
			</td>	
			<td class="thinfield"><input type="text" name="tocode[]"  
				value="JPY"></td>			
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
	
	
</body>
</html>