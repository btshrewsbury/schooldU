<?
require_once('utility/account.php');
$login_link  = $facebook->getLoginUrl(array('redirect_uri' => 'https://schooldu.com/utility/fb.php','scope' => 'publish_stream, email'));
?>

<div class="navbar ">
  <div class="navbar-inner">

	  <!-- Logo -->
	  <a class="brand span3" href="index.php"><img src="img/smallLogoFlat.png" alt="SchooldU Home Page"/></a>

	  <!--Mobile collapse button-->
	  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		<span class="icon-bar"></span>

	  </a>

	  <!-- Nav Links -->
	  <div class="float_right">
		  <div class="nav-collapse collapse">
			<ul class="nav nav-padding">
				<li class="nav_item"><a href="games.php">Challenge</a>
				<li class="nav_item"><a href="challenges.php">How It Works</a>
				<li class="nav_item"><a href="charities.php">Charities</a></li>
				<li class="nav_item"><a href="help.php">Help</a></li>
				
				<?
				if(!isLoggedIn())
				{?>
				<li id="login_li" class="nav_item"><a href="<? echo($login_link);?>" data-toggle="modal"><img style="position: relative; top: -6px;" src="img/fb_login.png" alt=""/></a></li>
				<?} else {?>
				<li class="dropdown" id="logout_li">
					<a href="#logout_li" class="dropdown-toggle" data-toggle="dropdown" >
						<span id="nav_name">
							<?echo(getMe()->get_name());?>
						</span> 
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
					  <li class="nav_item"><a href="account.php">My Challenges</a></li>
					  <li class="nav_item"><a href="payment.php">Payment Settings</a></li>
					  <li class="nav_item"><a href="logout.php" id="logoutLink" >Logout</a></li>
					</ul>
				</li>
				<?}?>
			</ul>
		  </div>
	  </div>

  </div>
</div>	
