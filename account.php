
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>School'd</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/schoold.css" rel="stylesheet">
	
	
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
    <div class="container">
		<? include 'nav.php'; ?>
			<div class="well well-large">
				<div class="tabbable tabs-left">
				  <ul class="nav nav-tabs" id="anchorInit">
					<li class=""><a href="#profile" data-toggle="tab">Manage Profile</a></li>
					<li class=""><a href="#friends" data-toggle="tab">Manage Friends</a></li>
					<li class="active"><a href="#payment" data-toggle="tab">Manage Payment</a></li>
					<li class=""><a href="#history" data-toggle="tab">Account History</a></li>
					<li class=""><a href="#statement" data-toggle="tab">Donation Statement</a></li>
					
				  </ul>
				  <div  class="tab-content">
					<div class="tab-pane" id="profile">
					  <h3>My Profile Settings</h3>
					</div>
					
					<div class="tab-pane" id="friends">
					  <h3>My Friends</h3>
					</div>
					
					<div class="tab-pane active" id="payment">
					<h3>My Payment Information</h3>
					</div>
					
					<div class="tab-pane" id="history">
					  <h3>My account History</h3>
					</div>
					
					<div class="tab-pane" id="statement">
					  <h3>Donations Statement</h3>
					</div>
					
				  </div>
				</div> <!-- /tabbable -->
			</div>
    </div>

    <? include 'js.php'; ?>
    
	<script type="text/javascript">
		$(window).load(function() {
			console.log("test");
			url = document.location.href.split('#');
			if(url[1] != undefined) {
				
				$("#anchorInit a[href='#"+url[1]+"']").tab("show");
			}
		});
	</script>
	
  </body>
</html>
