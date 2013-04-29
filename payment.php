<?php
require_once('page_framework/header.php');
require_once('utility/account.php');

if(!isLoggedIn())
{
	header("index_working.php");
}
?>
<html>
  <head>
    <title></title>
  </head>
  <body>
    <div class="container">
      <? include 'page_framework/nav.php'; ?>
      <div class="well well-large">
        <div class="tabbable">
          <!-- Only required for left/right tabs -->
          <ul class="nav nav-pills">
            <!-- <li>
              <a href="#">Profile Settings</a>
            </li>-->
            <li class="active">
              <a href="#payment" data-toggle="tab">Payment</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane" id="profile">
              <h4 class="text-info">Profile</h4>
              <div class="well well-small">
                <?include_once('widget/profile_settings.php');?>
              </div>
            </div>
            <div class="tab-pane active" id="payment">
              <div class="row-fluid">
				<?include_once('widget/payment_ability.php');?>
				<?include_once('widget/paypal.php');?>
				<?include_once('widget/stripe.php');?>
              </div>
            </div>
          </div>
		</div>
      </div><?include_once('page_framework/footer.php');?>
     </div>
  </body>
</html>
