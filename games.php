<?php
$sid = session_id();
if(!isset($sid)) {
    session_start();
}

$title="- March Madness!";
$description="SCHOOLD U allows users to create donation challenges over the outcome of individual games during March Madness";

require_once($_SERVER["DOCUMENT_ROOT"] . "/sports/college_basketball.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/sports/nba.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/sports/march_madness.php");
require_once("page_framework/header.php");
?>
  <body>
    <div class="container">
		<? include_once( 'page_framework/nav.php' ); ?>
		<div class="well well-large">
			<div class="row-fluid">
				<div class="span2">
					<ul class="nav nav-list" style="padding-right:20px">
						<li class="nav-header">Sports</li>
						<li class="divider"></li>
						<!--<li class="nav-header">NBA</li>-->
						<li class="active"><a href="#nba" data-toggle="tab">NBA</a></li>
						<!--<li class="nav-header">College Basketball</li>-->
						<!--<li class=""><a href="#cb" data-toggle="tab">College Basketball</a></li>
						<li class=""><a href="#mm" data-toggle="tab">March Madness</a></li>-->
						<!--<li class="nav-header">College Football</li>
						<li class=""><a href="#" data-toggle="tab">Starts in August</a></li>-->
						
					</ul>
				</div>
			
				<div class="tab-content">
					<div class="tab-pane" id="cb">
						<div class="row-fluid" style="border-top: 4px #243E45 solid">
							<? CB::displayYearSpan(); ?>
						</div>
					</div>
					<div class="tab-pane active" id="nba">
						<div class="row-fluid" style="border-top: 4px #243E45 solid">
							<? NBA::displayYearSpan(); ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>	
		<?include_once('page_framework/footer.php');?>		
	</div>

  </body>
</html>
