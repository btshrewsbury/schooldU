<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");


$myName = getMe()->get_name();

?>
  <div class="well well-small span4" style="padding:0px; min-height:420px;">
    <div class="row-fluid cc_header">
      <h4 class="text-info" style="margin:18px 0 0 12px;"><img style="margin-right:8px;" src="img/StripeLogo.png"/>Credit Card Processing</h4>
      <h5 style="margin:0 0 18px 12px ;">Use a Credit Card for Donations</h5>
    </div>
    <div class="row-fluid">
      
      <form method="post" action="payment/processStripe.php" onsubmit="return validateForm()" id="stripe_submit">
		<span class="payment-errors"></span>
        <div class="payment">
          <br />
          <div class="offset1 span6">
            <span class="">Card number</span>
            <br />
            <input type="text" class="span12" id="paymentNumber" placeholder="xxxx-xxxx-xxxx-xxxx" data-stripe="number"/>
          </div>
          <div class="span3 offset1">
            <span class="">Exp</span>
            <br />
            <input type="text" class="span4" id="exp-month" data-stripe="exp-month" placeholder="M" autocompletetype="cc-exp" maxlength="2"/>
			
			<input type="text" class="span7" id="exp-year" data-stripe="exp-year" placeholder="YYYY" autocompletetype="cc-exp" maxlength="4"/>
          </div>
          <div class="offset1 span6">
            <span class="">Name on card</span>
            <br />
            <input type="text" class="span12" id="paymentName" data-stripe="name" value="<?echo($myName);?>"/>
          </div>
          <div class="span3 offset1">
            <span class="">CVC</span>
            <br />
            <input type="text" class="span12" id="cvc" data-stripe="cvc" placeholder="xxx"/>
          </div>
          <div class="offset1 span10">
            <span class="">Billing address</span>
            <br />
            <input type="text" class="span12" id="address" placeholder="1234 Donation Lane" data-stripe="address_line1"/>
          </div>
          <div class="offset1 span6">
            <span class="">City</span>
            <br />
            <input type="text" class="span12" id="city" data-stripe="address_city"/>
          </div>
          <div class="span3 offset1">
            <span class="">State</span>
            <br />
            <select name="state" class="span12" placeholder="State" data-stripe="address_state">
              <option value="">State:</option>
              <option value="AL">AL</option>
              <option value="AK">AK</option>
              <option value="AS">AS</option>
              <option value="AZ">AZ</option>
              <option value="CA">CA</option>
              <option value="CO">CO</option>
              <option value="CT">CT</option>
              <option value="DE">DE</option>
              <option value="DC">DC</option>
              <option value="FM">FM</option>
              <option value="FL">FL</option>
              <option value="AR">AR</option>
              <option value="GA">GA</option>
              <option value="GU">GU</option>
              <option value="HI">HI</option>
              <option value="ID">ID</option>
              <option value="IL">IL</option>
              <option value="IN">IN</option>
              <option value="IA">IA</option>
              <option value="KS">KS</option>
              <option value="KY">KY</option>
              <option value="LA">LA</option>
              <option value="ME">ME</option>
              <option value="MH">MH</option>
              <option value="MD">MD</option>
              <option value="MA">MA</option>
              <option value="MI">MI</option>
              <option value="MN">MN</option>
              <option value="MS">MS</option>
              <option value="MO">MO</option>
              <option value="MT">MT</option>
              <option value="NE">NE</option>
              <option value="NV">NV</option>
              <option value="NH">NH</option>
              <option value="NJ">NJ</option>
              <option value="NM">NM</option>
              <option value="NY">NY</option>
              <option value="NC">NC</option>
              <option value="ND">ND</option>
              <option value="MP">MP</option>
              <option value="OH">OH</option>
              <option value="OK">OK</option>
              <option value="OR">OR</option>
              <option value="PW">PW</option>
              <option value="PA">PA</option>
              <option value="PR">PR</option>
              <option value="RI">RI</option>
              <option value="SC">SC</option>
              <option value="SD">SD</option>
              <option value="TN">TN</option>
              <option value="TX">TX</option>
              <option value="UT">UT</option>
              <option value="VT">VT</option>
              <option value="VI">VI</option>
              <option value="VA">VA</option>
              <option value="WA">WA</option>
              <option value="WV">WV</option>
              <option value="WI">WI</option>
              <option value="WY">WY</option>
            </select>
          </div>
          <div class="offset1 span3">
            <span class="">Zip</span>
            <br />
            <input type="text" class="span12" id="zip"  data-stripe="address_zip" />
          </div>
          <div class=" offset1 span6">
            <br />
            <button type="submit" class="btn btn-primary span12">
              <span>Add Credit Card</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
