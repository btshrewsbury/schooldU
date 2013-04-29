<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$title="- Make your Rivals Pay!";
$description="SCHOOLD U is a site for creating challenges between collegiate sports fans. The money pledged by both parties is donated to a Charity paired with the winner's University.";
require_once("page_framework/header.php");
?>

  <body>
    <div class="container">
		<? include 'page_framework/nav.php'; ?>
		<div class="row-fluid">
			<? include 'widget/carousel.php'; ?>
			<div class="row span3">
				<div id="profile_widget">
					<? include 'widget/profile.php'; ?>
				</div>
				<? include 'widget/deduction.php'; ?>
			</div>
		</div>

		<div class="row-fluid">
			<? include 'widget/how_it_works.php'; ?>
			<? include 'widget/todays_games.php'; ?>
			<? include 'widget/all_game_stats.php'; ?>
		</div>
		<?include_once('page_framework/footer.php');?>
    </div>

    
    
	<!-- js specific to this page-->
	<script type="text/javascript">
		$(window).load(function() {
			$('.carousel').carousel({
				interval: 0
			});
		});
	</script>
	
  </body>
</html>
