<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>PayPal Platform SDK - Set Payment OPtion</title>
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
<form id="Form1" name="Form1" method="post" action="SetPaymentOptionReceipt.php">

<h3>Pay - Create, Set, Execute API Flow</h3>
	<h3>Set Payment Option</h3>

<br/><br/>
<table align="center">
	<tr>
	    <td class="thinfield">Pay Key:</td>
		<td><input type="text" size="30" maxlength="32" name="payKey"
			value="<?php echo $_GET["payKey"];?>" /></td>
	</tr>
	
	<tr>
	   <td class="thinfield" height="14" colspan="4">

	      <P align="center">Financial Partner Detail:(Optional)</P>
	   </td>
	</tr>
	<tr/>
	<tr>
		<td class="thinfield" colspan="1">Country Code:</td>
		<td><input type="text" size="30" maxlength="32" name="countryCode"
			value="" /></td>
	</tr>

	<tr>
		<td class="thinfield" colspan="1">Name:</td>
		<td><input type="text" size="30" maxlength="32" name="displayName"
			value="" /></td>
	</tr>
	<tr>
		<td class="thinfield" colspan="1">Email:</td>
		<td><input type="text" size="30" maxlength="32" name="email"
			value="" /></td>
	</tr>

	
	<tr>
		<td class="thinfield" colspan="1">FirstName:</td>
		<td><input type="text" size="30" maxlength="32" name="firstName"
			value="" /></td>
	</tr>
	<tr>
		<td class="thinfield" colspan="1">LastName:</td>
		<td><input type="text" size="30" maxlength="32" name="lastName"
			value="" /></td>
	</tr>

	<tr>
		<td class="thinfield" colspan="1">CustomerId:</td>
		<td><input type="text" size="30" maxlength="32" name="institutionCustomerId"
			value="" /></td>
	</tr>
	<tr>
		<td class="thinfield" colspan="1">InstitutionId:</td>
		<td><input type="text" size="30" maxlength="32" name="institutionId"
			value="" /></td>
	</tr>

	<tr/><tr/>
	<tr>
	   <td class="thinfield" height="14" colspan="4">
	      <P align="center">Display Option:(Optional)</P>
	   </td>
	</tr>
	<tr/>
	<tr>

		<td class="thinfield" colspan="1">Email Header Image:</td>
		<td><input type="text" size="60" maxlength="32" name="emailHeaderImageUrl"
			value="http://bankone.com/images/emailHeaderImage.jpg" /></td>
	</tr>
	<tr>
		<td class="thinfield" colspan="1">Email Marketing Image:</td>
		<td><input type="text" size="60" maxlength="32" name="emailMarketingImageUrl"
			value="http://bankone.com/images/emailMarketingImage.jpg" /></td>
	</tr>
	<tr/><tr/><tr/>

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
