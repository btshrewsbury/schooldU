<?php
$array = array("	Sat., Nov. 10	Northwestern at Michigan	"	,
"	Sat., Nov. 10	Wisconsin at Indiana	"	,
"	Sat., Nov. 10	Miami at Virginia	"	,
"	Sat., Nov. 10	Louisville at Syracuse	"	,
"	Sat., Nov. 10	Army at Rutgers	"	,
"	Sat., Nov. 10	Northern Iowa at South Dakota	"	,
"	Sat., Nov. 10	Gardner-Webb at Charleston Southern	"	,
"	Sat., Nov. 10	Chattanooga at Wofford	"	,
"	Sat., Nov. 10	Maryland at Clemson	"	,
"	Sat., Nov. 10	Penn State at Nebraska	"	,
"	Sat., Nov. 10	West Virginia at Oklahoma State	"	,
"	Sat., Nov. 10	Navy at Troy	"	,
"	Sat., Nov. 10	Georgia at Auburn	"	,
"	Sat., Nov. 10	Mississippi State at LSU	"	,
"	Sat., Nov. 10	Vanderbilt at Mississippi	"	,
"	Sat., Nov. 10	Notre Dame at Boston College	"	,
"	Sat., Nov. 10	 Idaho at BYU	"	,
"	Sat., Nov. 10	Oregon at California	"	,
"	Sat., Nov. 10	UCLA at Washington State	"	,
"	Wed., Nov. 14	Ohio at Ball State	"	,
"	Wed., Nov. 14	Toledo at Northern Illinois	"	,
"	Thurs., Nov. 15	North Carolina at Virginia	"	,
"	Fri., Nov. 16	Hawaii at Air Force	"	,
"	Fri., Nov. 16	FIU at Florida Atlantic	"	,
"	Sat., Nov. 17	Iowa at Michigan	"	,
"	Sat., Nov. 17	Northwestern at Michigan State	"	,
"	Sat., Nov. 17	Rutgers at Cincinnati	"	,
"	Sat., Nov. 17	Kent State at Bowling Green	"	,
"	Sat., Nov. 17	Liberty at VMI	"	,
"	Sat., Nov. 17	The Citadel at Furman	"	,
"	Sat., Nov. 17	Bethune-Cookman at Florida A&M	"	,
"	Sat., Nov. 17	Hampton vs. Morgan State	"	,
"	Sat., Nov. 17	Ohio State at Wisconsin	"	,
"	Sat., Nov. 17	Utah State at Louisiana Tech	"	,
"	Sat., Nov. 17	Tennessee at Vanderbilt	"	,
"	Sat., Nov. 17	Syracuse at Missouri	"	,
"	Sat., Nov. 17	Utah State at Louisiana Tech	"	,
"	Sat., Nov. 17	Western Kentucky at La-Lafayette	"	,
"	Sat., Nov. 17	Kansas State at Baylor	"	,
"	Sat., Nov. 17	BYU at San Jose State	"	,
"	Tues., Nov. 20	Akron at Toledo	"	,
"	Thurs., Nov. 22	Tuskegee at Alabama State	"	,
"	Thurs., Nov. 22	TCU at Texas	"	,
"	Fri., Nov. 23	Nebraska at Iowa	"	,
"	Fri., Nov. 23	West Virginia at Iowa State	"	,
"	Fri., Nov. 23	Arizona State at Arizona	"	,
"	Fri., Nov. 23	South Florida at Cincinnati	"	,
"	Fri., Nov. 23	Syracuse at Temple	"	,
"	Sat., Nov. 24	Idaho at Utah State	"	,
"	Sat., Nov. 24	Michigan at Ohio State	"	,
"	Sat., Nov. 24	Notre Dame at USC	"	,
"	Sat., Nov. 17	BYU at New Mexico State	"	,
"	Thurs., Nov. 29	Louisville at Rutgers	"	,
"	Fri., Nov. 30	MAC Football Championship Game (Ford Field, Detroit)	"	,
"	Sat., Dec. 1	Conference USA Championship Game	"	,
"	Sat., Dec. 1	Dr Pepper ACC Football Championship Game	"	,
"	Sat., Dec. 1	Pittsburgh at South Florida	"	,
"	Sat., Dec. 1	Boise State at Nevada	"	,
"	Sat., Dec. 1	Cincinnati at Connecticut	");

$winner = array("Home","Away");

for ($i = 0; $i <= sizeof($array); $i++) {

	$team1_x = rand(0, 4)  * 76 + 15;
	$team1_y = rand(0, 13) * 114 + 4;
	$team1_imageUrl = "background:url(img/football_thumbs.jpg) -" . $team1_x . "px -" . $team1_y . "px;";
	$team2_x = rand(0, 4) * 76 + 15;
	$team2_y = rand(0, 13)* 114 + 4;
	$team2_imageUrl = "background:url(img/football_thumbs.jpg) -" . $team2_x . "px -" . $team2_y . "px;";
	$gameLink = "game.php?x1=" . $team1_x . "&y1=" . $team1_y . "&x2=" . $team2_x . "&y2=" . $team2_y;
	?>
	<hr />
	<div class="media">
	  <div class="pull-left" style="position:relative; width:64px; height:64px; <?echo($team1_imageUrl);?> overflow:hidden;">
		  <a href="#">
		  </a>
	  </div>
	  <div class="pull-left" style="position:relative; width:64px; height:64px; <?echo($team2_imageUrl);?> overflow:hidden;">
		  <a href="#">
		  </a>
	  </div>
	  
	   <a class="pull-right" href="<?echo($gameLink);?>">
		Challenge<img class="media-object" src="http://placehold.it/64x64">
		
	   </a>
	  
	  <div class="media-body"><h4>
	<?
		echo($array[$i]);
	?>
		</h4>
		<div class="media">
			<?
			   $numOfChallenges = rand(2, 20) * 30 + rand(2, 9);
			   $moneyOnLine = $numOfChallenges * rand(5, 14) + rand(2, 100);
			?>
			TeamA vs TeamB<br />
			Time: TBA<br />
			Number of challenges: <strong style="color:red;"><? echo($numOfChallenges); ?></strong><br/>
		    Money on the line: <strong style="color:red;">$<? echo($moneyOnLine); ?></strong><br/>
		  
		  
		</div>
	  </div>
	</div>
	
	
<?}
?>