<?php
$title="- HELP?!";
$description="SCHOOLD U has generated a list of common questions. If you have any questions not listed here please contact us at support@shooldu.com";

require_once("page_framework/header.php");
?>
  <body>
    <div class="container">
		<? include_once( 'page_framework/nav.php' ); ?>
		<div class="well well-large">
			<div class="row-fluid">
				<div class="offset1">
					<div class="tabbable"> <!-- Only required for left/right tabs -->
					  <ul class="nav nav-pills">
						<li class="active"><a href="#qa" data-toggle="tab">Q & A</a></li>
						<li><a href="#contact" data-toggle="tab">Contact Us</a></li>
						<li><a href="#about" data-toggle="tab">About Us</a></li>
						<li><a href="#tc" data-toggle="tab">Terms And Conditions</a></li>
					  </ul>
					  <div class="tab-content">
						<div class="tab-pane active" id="qa">
							<?include_once("faq.php");?>
						</div>
						<div class="tab-pane" id="contact">
							<?include_once("contact_us.php");?>
						</div>
						<div class="tab-pane" id="about">
							<?include('bio.php');?>
						</div>
						<div class="tab-pane" id="tc">
							<?include('terms_conditions.php');?>
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>	
		<?include_once('page_framework/footer.php');?>		
	</div>

  </body>
</html>
