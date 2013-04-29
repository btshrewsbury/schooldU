<?php

/********************************************
AddBankAccount.php

Called by index.html
Calls  AddBankAccountReceipt.php,and APIError.php.
********************************************/
require_once 'web_constants.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>PayPal Platform SDK - Adaptive Accounts</title>
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

    <form id="Form1" name="Form1" method="post" action="AddBankAccountReceipt.php">

 
        <h3>Adaptive Accounts - Add Bank Account</h3>
   
           
       
  <table align="center" >  
 
  <tr>
        <td class="field"> email Id:</td>
        <td><input type="text" size="30" maxlength="50" name=" emailid"
            value="platfo_1255611349_biz@gmail.com" /></td>
    </tr>
     <tr>
        <td class="field">Bank Country Code:</td>
        <td><input type="text" size="30" maxlength="10" name="bankCountryCode"
            value="US" /></td>
    </tr>
   
    <tr>
        <td class="field">Bank Name:</td>
        <td><input type="text" size="30" maxlength="32"
            name="bankName" value="Huntington Bank" /></td>
    </tr>
    <tr>
        <td class="field">Routing Number:</td>
        <td><input type="text" size="30" maxlength="10" name="routingNumber"
            value="021473030" /></td>
    </tr>
    <tr>
        <td class="field">Bank Account Number:</td>
        <td><input type="text" size="30" maxlength="10" name="bankAccountNumber"
            value="162951" /></td>
     </tr>
     <tr>
        <td class="field">Account type:</td>
      <td> <select   name="accounttype">
        
        <option  value="CHECKING">CHECKING</option>
         <option  value="SAVING">SAVINGS</option>
         <option  value="BUSINESS_CHECKING">BUSINESS_CHECKING</option>
         <option  value="BUSINESS_SAVING">BUSINESS_SAVING</option>
         <option  value="NORMAL">NORMAL</option>
         <option  value="UNKNOWN">UNKNOWN</option>
          </select></td> 
     </tr>
            
   
      <tr>
        <td class="field">confirmationType:</td>
      <td> <select name="confirmationType">
        <option  value="WEB">WEB</option>
         <option  value="MOBILE">MOBILE</option>
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
