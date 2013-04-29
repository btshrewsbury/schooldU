<?php
$title="- Charities!";
$description="SCHOOLD U has decided to pair The Association of Former Students with the Aggies and The University Of Oklahoma Foundation with the Sooners";
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/charitySearch.php");
require_once("page_framework/header.php");
?>
  <body>
    <div class="container">
		<? include_once( 'page_framework/nav.php' ); ?>
		<div class="well well-large">
			<div class="well well-small">
				SchooldU is working hard to continuously update education based charities available for our users. 
				If your desired charity is not on our list please feel free to let us know at help@schooldu.com. 
				We appreciate all your comments and concerns!
			</div>
			<?showCharitySearchNoForm();?>
			
		
		</div>
		<?include_once('page_framework/footer.php');?>		
	</div>

  </body>
</html>
