<?php
require_once('utility/account.php');
if(!isLoggedIn())
{
	header("index_working.php");
}

require_once('widget/unmatched_challenges.php');
require_once('widget/matched_challenges.php');
require_once('widget/pooled_challenges.php');
require_once('page_framework/header.php');
?>

  <body>
    <div class="container">
		<? include 'page_framework/nav.php'; ?>
		<div class="well well-large">
			<div class="tabbable"> <!-- Only required for left/right tabs -->
			  <ul class="nav nav-pills">
				<li class="active"><a href="#active" data-toggle="tab">Active Challenges</a></li>
				<li><a href="#completed" data-toggle="tab">Completed Challenges</a></li>
			  </ul>
			  <div class="tab-content">
				<div class="tab-pane active" id="active">
					<h4 class="text-info">Active Challenges</h4>
					<div class="well well-small">
					<?
						displayMyUnmatchedChallenges();
						displayMyMatchedChallenges();
						displayMyPooledChallenges();
					?>
					</div>
				</div>
				<div class="tab-pane" id="completed">
					<h4 class="text-info">Completed Challenges</h4>
					<div class="well well-small">
					<?
						displayMyCompletedMatchedChallenges();
						displayMyCompletedPooledChallenges();
					?>
					</div>
				</div>
			  </div>
			</div>
		</div>
		<?include_once('page_framework/footer.php');?>
    </div>
  </body>
</html>