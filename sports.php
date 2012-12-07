<?php
require_once("mock/createMockSchools.php");
require_once('leaderboard/display.php');

$mockSchools = new MockSchools();
?>

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

				<div class="tabbable ">
				  <ul class="nav nav-tabs">
					<li class="active" class=""><a href="#lA" data-toggle="tab">Football</a></li>				
					<li><a href="#">Basketball</a></li>
				  </ul>
				  <div class="tab-content">
					<div class="tab-pane active" id="lA">
					  
						<div class="tabbable tabs-left">
						  <ul class="nav nav-tabs">
							<li class="active"><a href="#football_school" data-toggle="tab">By School</a></li>
							<li><a href="#football_date" data-toggle="tab">By Date</a></li>
							<li><a href="#">By Division</a></li>
						  </ul>
						  
						  <div class="tab-content">
							<div class="tab-pane active" id="football_school">
							  <h4>Search By School</h4>
							  <? displayTopSchools(); ?>
							</div>
							
							<div class="tab-pane" id="football_date">
							<h4>Search By Date</h4>
							  <? include 'sports/display.php'; ?>
							</div>
							
							<div class="tab-pane" id="football_division">
							<h4>Search By Division</h4>
							  
							</div>
						  </div>
						</div>
					</div>
					
					
				  </div>
				</div>



    </div>

    <? include 'js.php'; ?>
    
	<script type="text/javascript">
			$(window).load(function() {
				$('.carousel').carousel({
					interval: 5000
				});
			});
	</script>
	
  </body>
</html>
