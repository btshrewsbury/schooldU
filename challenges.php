<?php
 include 'my_challenges_mock.php'; 
 include 'challenge/display.php'; 
 require_once("mock/createMockUsers.php");



$mockUsers = new MockUsers();


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SCHOOLDU Challenge</title>
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
					<li class=""><a href="#lA" data-toggle="tab">My Challenges</a></li>
					<li class="active"><a href="#head2head" data-toggle="tab">Head 2 Head</a></li>
					<li class=""><a href="#lB" data-toggle="tab">Open</a></li>
					<li class=""><a href="#lC" data-toggle="tab">Pool</a></li>
					<li class=""><a href="#lD" data-toggle="tab">Special Open</a></li>
				  </ul>
				  <div  class="tab-content">
					<div class="tab-pane" id="lA">
					  <h3>My Challenges</h3>
					  
					  <?display_random_Challenges();?>
					</div>
					<div class="tab-pane active" id="head2head">
					  <h3>Create Head 2 Head Challenge</h3>
					  <div class="alert alert-block alert-error fade in">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>Notice!</strong> Logging in will allow you to find friends via Social Media.
					  </div>
					  <?displayCreateChallenge("head2head");?>
					</div>
					<div class="tab-pane " id="lB">
					<h3>Open</h3>
					<?displayCreateChallenge("open");?>
					</div>
					<div class="tab-pane" id="lC">
					  <h3>Pool</h3>
					<?displayCreateChallenge("pool");?>
					</div>
					<div class="tab-pane" id="lD">
					  <h3>Special Open</h3>
					
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
