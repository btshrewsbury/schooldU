<?php
require_once("mock/createMockUsers.php");
require_once("mock/createMockSchools.php");
require_once('leaderboard/display.php');

$mockUsers = new MockUsers();
$mockSchools = new MockSchools();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SCHOOLDU - Leaderboards</title>
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
				
				  <ul class="nav nav-tabs">
				    <li class="active"><a href="#contributors" data-toggle="tab">Top Contributors</a></li>
					<li class=""><a href="#competitors" data-toggle="tab">Top Competitors</a></li>
					<li class=""><a href="#schools" data-toggle="tab">Top Schools</a></li>
				  </ul>
				  
				  <div class="tab-content">
					<div class="tab-pane active" id="contributors">
					  <h4>Top Contributors</h4>
					  <? displayTopContributors(); ?>
					</div>
					
					<div class="tab-pane" id="competitors">
					<h4>Top Competitors</h4>
						<? displayTopCompetitors(); ?>
					
					</div>
					
					<div class="tab-pane" id="schools">
					  <h4>Top Schools</h4>
						<? displayTopSchools(); ?>

					</div>
				  </div>
				</div> 
			</div>
    </div>

    <? include 'js.php'; ?>
	
  </body>
</html>
