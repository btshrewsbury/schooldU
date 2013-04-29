<?php

/********************************************
AddPaymentCard.php

Called by index.html
Calls  AddPaymentCardReceipt.php,and APIError.php.
********************************************/
require_once 'web_constants.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>PayPal Platform SDK - Adaptive Accounts</title>
<link href="common/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
	function generateCC(){
		var cc_number = new Array(16);
		var cc_len = 16;
		var start = 0;
		var rand_number = Math.random();

		switch(document.Form1.creditCardType.value)
        {
			case "Visa":
				cc_number[start++] = 4;
				break;
			case "Discover":
				cc_number[start++] = 6;
				cc_number[start++] = 0;
				cc_number[start++] = 1;
				cc_number[start++] = 1;
				break;
			case "MasterCard":
				cc_number[start++] = 5;
				cc_number[start++] = Math.floor(Math.random() * 5) + 1;
				break;
			case "Amex":
				cc_number[start++] = 3;
				cc_number[start++] = Math.round(Math.random()) ? 7 : 4 ;
				cc_len = 15;
				break;
        }

        for (var i = start; i < (cc_len - 1); i++) {
			cc_number[i] = Math.floor(Math.random() * 10);
        }

		var sum = 0;
		for (var j = 0; j < (cc_len - 1); j++) {
			var digit = cc_number[j];
			if ((j & 1) == (cc_len & 1)) digit *= 2;
			if (digit > 9) digit -= 9;
			sum += digit;
		}

		var check_digit = new Array(0, 9, 8, 7, 6, 5, 4, 3, 2, 1);
		cc_number[cc_len - 1] = check_digit[sum % 10];

		document.Form1.cardNumber.value = "";
		for (var k = 0; k < cc_len; k++) {
			document.Form1.cardNumber.value += cc_number[k];
		}
	}
</script>

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
<form id="Form1"  method="post" action="AddPaymentCardReceipt.php" name ="Form1">

 
        <h3>Adaptive Accounts - Add Payment Card</h3>
   
           
       
  <table align="center" >  
 
  <tr>
        <td class="field"> email Id:</td>
        <td><input type="text" size="30" maxlength="50" name=" emailid"
            value="platfo_1255611349_biz@gmail.com" /></td>
    </tr>
     <tr>
		<td width="200" class="field">Card Type:</td>
		<td align=left>
			<select name=creditCardType onChange="javascript:generateCC(); return false;">
				<option value=Visa>Visa</option>
				<option value=MasterCard>MasterCard</option>
				<option value=Discover>Discover</option>
				<option value=Amex>American Express</option>
			</select>
		</td>
	</tr>
     <tr>
        <td class="field">Credit Card Number:</td>
        <td><input type="text" size="30" maxlength="20" name="cardNumber"
             /></td>
    </tr>
   
    <tr>
        <td class="field">First Name:</td>
        <td><input type="text" size="30" maxlength="32"
            name="firstName" value="John" /></td>
    </tr>
    <tr>
        <td class="field">Last Name:</td>
        <td><input type="text" size="30" maxlength="32"
            name="lastName" value="Deo" /></td>
    </tr>
    <tr>
		<td class="field">Expiration Date:</td>
		<td align=left>
			<select class="smalltext" name=expDateMonth>
				<option value=1>01</option>
				<option value=2>02</option>
				<option value=3>03</option>
				<option value=4>04</option>
				<option value=5>05</option>
				<option value=6>06</option>
				<option value=7>07</option>
				<option value=8>08</option>
				<option value=9>09</option>
				<option value=10>10</option>
				<option value=11>11</option>
				<option value=12>12</option>
			</select></td>
			<td  align=left>
			<select class="smalltext" name=expDateYear>
				<option value=2005>2005</option>
				<option value=2006>2006</option>
				<option value=2007>2007</option>
				<option value=2008>2008</option>
				<option value=2009>2009</option>
				<option value=2010 >2010</option>
				<option value=2011 >2011</option>
				<option value=2012 selected>2012</option>
				<option value=2013>2013</option>
				<option value=2014>2014</option>
				<option value=2015>2015</option>
			</select>
		</td>
	</tr>
    <tr>
        <td class="field">confirmationType:</td>
      <td> <select name="confirmationType">
        <option  value="WEB">WEB</option>
         <option  value="MOBILE">MOBILE</option>
          </select></td> 
     </tr>
  <tr>
		<td class="field"><br><b>Billing Address:</b></td>
	</tr>
	<tr>

		<td class="field">Address 1:</td>
		<td align=left><input type=text size=25 maxlength=100 name=address1 value="1 Main St"></td>
	</tr>
	<tr>
		<td class="field">Address 2:</td>
		<td align=left><input type=text  size=25 maxlength=100 name=address2 value="2nd cross"></td>
	</tr>

	<tr>
		<td class="field">City:</td>
		<td align=left><input type=text size=25 maxlength=40 name=city value="San Jose"></td>
	</tr>
	<tr>
		<td class="field">State:</td>
		<td  align=left>
			<select id=state name=state>

				<option value=></option>
				<option value=AK>AK</option>
				<option value=AL>AL</option>
				<option value=AR>AR</option>
				<option value=AZ>AZ</option>
				<option value=CA selected>CA</option>

				<option value=CO>CO</option>
				<option value=CT>CT</option>
				<option value=DC>DC</option>
				<option value=DE>DE</option>
				<option value=FL>FL</option>
				<option value=GA>GA</option>

				<option value=HI>HI</option>
				<option value=IA>IA</option>
				<option value=ID>ID</option>
				<option value=IL>IL</option>
				<option value=IN>IN</option>
				<option value=KS>KS</option>

				<option value=KY>KY</option>
				<option value=LA>LA</option>
				<option value=MA>MA</option>
				<option value=MD>MD</option>
				<option value=ME>ME</option>
				<option value=MI>MI</option>

				<option value=MN>MN</option>
				<option value=MO>MO</option>
				<option value=MS>MS</option>
				<option value=MT>MT</option>
				<option value=NC>NC</option>
				<option value=ND>ND</option>

				<option value=NE>NE</option>
				<option value=NH>NH</option>
				<option value=NJ>NJ</option>
				<option value=NM>NM</option>
				<option value=NV>NV</option>
				<option value=NY>NY</option>

				<option value=OH>OH</option>
				<option value=OK>OK</option>
				<option value=OR>OR</option>
				<option value=PA>PA</option>
				<option value=RI>RI</option>
				<option value=SC>SC</option>

				<option value=SD>SD</option>
				<option value=TN>TN</option>
				<option value=TX>TX</option>
				<option value=UT>UT</option>
				<option value=VA>VA</option>
				<option value=VT>VT</option>

				<option value=WA>WA</option>
				<option value=WI>WI</option>
				<option value=WV>WV</option>
				<option value=WY>WY</option>
				<option value=AA>AA</option>
				<option value=AE>AE</option>

				<option value=AP>AP</option>
				<option value=AS>AS</option>
				<option value=FM>FM</option>
				<option value=GU>GU</option>
				<option value=MH>MH</option>
				<option value=MP>MP</option>

				<option value=PR>PR</option>
				<option value=PW>PW</option>
				<option value=VI>VI</option>
			</select>
		</td>
	</tr>
	<tr>

		<td class="field">ZIP Code:</td>
		<td class="thinfield"><input type=text size=10 maxlength=10 name=zip value=95131>(5 or 9 digits)</td>
	</tr>
	<tr>
		<td class="field">Country:</td>
		<td align=left><input type=text size=10 maxlength=10 name=countryCode value=US></td>
	
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
<script language="javascript">
	generateCC();
</script>
</div>
</div>
</body>
</html>

