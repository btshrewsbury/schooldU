<?php
 require_once("objects/user.php");
 require_once('my_challenges_mock.php');
 require_once("mock/createMockUsers.php"); 
 require_once("challenge/display.php"); 
  
 $mockUsers = new MockUsers();
$x1 = $_GET['x1'];
$y1 = $_GET['y1'];
$x2 = $_GET['x2'];
$y2 = $_GET['y2'];
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
				<div class="tabbable tabs-left">
				  <ul class="nav nav-tabs" id="anchorInit">
					<li class="active"><a href="#game" data-toggle="tab">The Game</a></li>
					<li class=""><a href="#friends" data-toggle="tab">Friends Challenges</a></li>
					<li class=""><a href="#open" data-toggle="tab">Open Challenges</a></li>
					<li class=""><a href="#messages" data-toggle="tab">Message Board</a></li>
					
				  </ul>
				  <div  class="tab-content">
					<div class="tab-pane active" id="game">
					  <h3>Game Details</h3>
					  <div>
						<div style="width:128px;">
							<div style="float:left; width:64px; height:64px; background:url(img/football_thumbs.jpg) -<?echo($x1 );?>px -<?echo($y1);?>px; overflow:hidden;">
							  <a href="#">
							  </a>
							</div>
							<div style="float:left; width:64px; height:64px; background:url(img/football_thumbs.jpg) -<?echo($x2 );?>px -<?echo($y2);?>px; overflow:hidden;">
							  <a href="#">
							  </a>
							</div>
						</div>
						<div style="clear:left;">
							<img src ="img/charity.png" width="64" height="64" />
							<img src ="img/charity.png" width="64" height="64" />
						</div>
						<ul style="clear:left;">
							<li>Team 1 vs Team 2</li>
							<li>Charity 1 vs Charity 2</li>
							<li>Game Date and Time</li>
							<li>Location</li>
							<li>Total money on the line (head2heads and pools)</li>
						</ul>
						<hr/>
						<div class="row">
							<div class="span5" >
								<h4>Go Head 2 Head</h4>
								Suggested Friends <br />
								<?displayFriends(5);?>
							</div>
							<div class="span4" >
								<h4>Join an Pool</h4>
								<? displayPoolsSmall(5); ?>
							</div>
						</div>
						<ul style="clear:left;">
							
						</ul>
						
						
					  </div>
					</div>
					
					<div class="tab-pane" id="friends">
					  <h3>My Friends Challenges</h3>
					  <?display_random_Challenges_viewOnly($x1,$y1,$x2,$y2); ?>
					</div>
					
					<div class="tab-pane" id="open">
					<h3>Open Challenges</h3>
					<?display_random_open_Challenges($x1,$y1,$x2,$y2,false);?>
					</div>
					
					<div class="tab-pane" id="open">
					  <h3>Open Challenges</h3>
					</div>
					
					<div class="tab-pane" id="messages">
					  <h3>Message Board</h3>
					  Under Construction
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
