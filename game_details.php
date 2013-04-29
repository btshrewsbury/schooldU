<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/game.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/head2head.php");

if($_SERVER['REQUEST_METHOD'] == 'GET' )
{
	if(isset($_GET["gid"]))
	{
		$gid = $_GET["gid"];
		$theGame = Game::getGameById($gid);

		if(!isset($theGame))
		{
			header( 'Location: games.php' ) ;
		} else {
			$isChallengeView = false;
		}
	} else if (isset($_GET["cid"])){
		$cid = $_GET["cid"];
		$theChallenge = Head2Head::getChallengeById($cid);

		if(!isset($theChallenge))
		{
			header( 'Location: games.php' ) ;
		} else if($theChallenge->is_paired()) {
			$isChallengeView = true;
			$isOpenChallengeView = false;
		
		} else {
			$isChallengeView = true;
			$isOpenChallengeView = true;
		}
		$theGame = $theChallenge->get_game();
	}
	
	$homeTeam = $theGame->get_home_team();
	$awayTeam = $theGame->get_away_team();
	$date = $theGame->get_date();
	$awayTeamName = $awayTeam->get_name();		
	$homeTeamName = $homeTeam->get_name();	
	$title="- $homeTeamName vs $awayTeamName: $date";
	$description="SCHOOLD U's donation challenge:  $homeTeamName vs $awayTeamName on $date. Schoold U allows users to create donation challenges over the outcome of collegiate sporting events";
	
} else {
	header( 'Location: games.php' ) ;
}

require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/banner.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/createChallenge.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/game_stats.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/head2head_view.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/unmatched_challenges.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/charity_breakdown.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/scoreboard.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/game_over.php");
require_once("page_framework/header.php");

?>
  <body>
    <div class="container">
		<? include_once( 'page_framework/nav.php' ); ?>
		<div class="well well-large">
			<div class="row-fluid">
				<div class="span3">
					<?showColumn($theGame);?>
				</div>
				<div class="span9" style="padding-left: 12px;">
					<div class="row-fluid">
						<?showBanner($theGame);?>
					</div>
					<div class="row-fluid">
						<div class="well well-small" style="background-color:rgb(240, 240, 240)">
							<div id ="challenge_alert"></div>
							<div style="padding-left:20px" >
								<div class="row" id="challengeContainer">
									<?if($theGame->is_finished()){
										displayGameOver($theGame);
									} else if(!$isChallengeView) {
										showCreateChallenge($theGame);
									} else if(!$isOpenChallengeView){
										displayClosedChallenge($theChallenge);
									} else {
										displayChallenge($theChallenge);
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="row-fluid">		
						<div class="well well-small span6 ">
							<h5 class="text-info">Unmatched Challenges</h5>
								<?showUnmatchedChallenges($theGame);?>
						</div>
						<div class="well well-small span6">
							<h5 class="text-info">Charity Breakdown</h5>
								<?showCharityBreakdown($theGame);?>
						</div>
					</div>
				</div>
			</div>	
		</div>	
		<?include_once('page_framework/footer.php');?>
	</div>

  </body>
</html>