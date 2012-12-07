<?php

function display_random_Head2Head($personName,$thumbName,$response,$editor) 
{
	$thumbUrl = "img/profile_thumb/" . $thumbName;
	$rand_x1 = rand(0, 4)  * 76+15;
	$rand_y1 = rand(0, 13) * 114+4;
	$rand_x2 = rand(0, 4)  * 76+15;
	$rand_y2 = rand(0, 13) * 114+4;
?>
  <div class="media">
	<div class="pull-left" style="position:relative; width:64px; height:64px; overflow:hidden;">
		  <a href="#">
			<img src ="<?echo($thumbUrl);?>" width="64" height="64" />
		  </a>
	  </div>
	  
	  <div class="pull-right" style="cursor: pointer;" onclick="window.location ='game.php?<?echo("x1=" . $rand_x1 . "&y1=" . $rand_y1 ."&x2=" . $rand_x2 . "&y2=" . $rand_y2);?>';"style="width:128px;">

		<div style="float:left; position:relative; width:64px; height:64px; background:url(img/football_thumbs.jpg) -<?echo($rand_x1 );?>px -<?echo($rand_y1);?>px; overflow:hidden;">
		  <a href="#">
		  </a>
		</div>
		<div style="float:left; position:relative; width:64px; height:64px; background:url(img/football_thumbs.jpg) -<?echo($rand_x2 );?>px -<?echo($rand_y2);?>px; overflow:hidden;">
		  <a href="#">
		  </a>
		</div>
		
	  </div>
	  
	  <div class="media-body">
		<h4>
			You vs. <?echo($personName);?>
			<strong style="color:red;">$<? echo(5 + rand(0, 20) ); ?> </strong>
		</h4>
		<?
		if($viewOnly != true)
		{?>	
		<div class="media">
			<a href="#"> 
				<? if($response == -1) {echo("Raise The Stakes"); }
					else {echo($response); }
				?>
			</a>
		   <a href="#"> Cancel Challenge</a>
		   <a href="#"> Send Message</a>
		</div>
		<?}?>
	  </div>
	</div>
<?
}

function display_random_pool() 
{
	
	$rand_x = rand(0, 4);
	$rand_y = rand(0, 13);
	$rand_x2 = rand(0, 4);
	$rand_y2 = rand(0, 13);
	$bet = 5 + rand(0, 8);
	$totalInPool = 5 * rand(0, 20) + rand(0, 5) + bet;
?>
  <div class="media">
	<div class="pull-left" style="position:relative; width:64px; height:64px; overflow:hidden;">
		  <a href="#">
			<img src ="img/chips.jpg" width="64" height="64" />
		  </a>
	  </div>
	  
	  <div class="pull-right" style="width:128px;">
		<div style="float:left; position:relative; width:64px; height:64px; background:url(img/football_thumbs.jpg) -<?echo($rand_x * 76+15 );?>px -<?echo($rand_y * 114+4);?>px; overflow:hidden;">
		  <a href="#">
		  </a>
		</div>
		<div style="float:left; position:relative; width:64px; height:64px; background:url(img/football_thumbs.jpg) -<?echo($rand_x2 * 76+15 );?>px -<?echo($rand_y2 * 114+4);?>px; overflow:hidden;">
		  <a href="#">
		  </a>
		</div>
	  </div>
	  
	  <div class="media-body">
		<h4>
			Pooled Bet. Your Contribution: <strong style="color:red;">$<? echo($bet); ?> </strong> Total Size: <strong style="color:red;">$<? echo($totalInPool); ?> </strong> 
		</h4>
		<div class="media">
			<a href="#"> Raise The Stakes</a>
		    <a href="#"> Cancel Challenge</a>
		   
		</div>
	  </div>
	</div>
<?
}

function display_random_Challenges() 
{
	$people = array("Brandon Shrewsbury","Natalie Attaya","Taylor Stanley","Shelly Brenckman","Jesus Morales","Travis Crawford");
	$pic = array("Brandon_Shrewsbury.jpg","Natalie_Attaya.jpg","Taylor_Stanley.jpg","Shelly_Brenckman.jpg","Jesus_Morales.jpg","Travis_Crawford.jpg");
	$category = array("Pending Approval","Active","Completed");
	$challenege_type = array("head2head","pool","open","special");
	$response_type = array("Accept","Pending");
	$numbers = range(0, sizeof($people) - 1);
	shuffle($numbers);
	for ($i = 0; $i < 3; $i++) {
		$peopleIndex = 0;
		$numberOfEntries = rand(2, 8);
		?>
		<br/>
		<h4><? echo($category[$i]); ?></h4>
		<?for ($j = 0; $j < $numberOfEntries; $j++) {?>
			<hr />
			<?
			 if($category[$i] == "Pending Approval")
			 {
				 display_random_Head2Head($people[$numbers[$peopleIndex]],$pic[$numbers[$peopleIndex]],$response_type[rand(0, 1)],false);
				 $peopleIndex++;
			 }
			 if($category[$i] == "Active")
			 {
				switch (rand(0, 1)) {
				case 0:
					display_random_Head2Head($people[$numbers[$peopleIndex]],$pic[$numbers[$peopleIndex]],-1,false);
					$peopleIndex++;
					break;
				case 1:
					display_random_pool();
					break;
				}		 
			 }
			 if($category[$i] == "Completed")
			 {
				switch (rand(0, 1)) {
				case 0:
					display_random_Head2Head($people[$numbers[$peopleIndex]],$pic[$numbers[$peopleIndex]],-1,false);
					$peopleIndex++;
					break;
				case 1:
					display_random_pool();
					break;
				}		 
			 }
			?> 
		<?}
	}
}

function display_random_open($p1,$picP1,$p2,$picP2,$x1,$y1,$x2,$y2,$hasOpponent)
{
	$picP1 = "img/profile_thumb/" . $picP1;
	if($p2 == -1)
		$picP2 = "img/empty.jpg";
	else
		$picP2 = "img/profile_thumb/" . $picP2;
	
?>
	<hr />
  <div class="media">
		
	  <div class="pull-left" style="position:relative; width:64px; height:64px; overflow:hidden;">
		  <a href="#">
			<img src ="<?echo($picP1);?>" width="64" height="64" />
		  </a>
	  </div>
	  <? if($p2 != -1)
	  {echo("test");?>
	  <div class="pull-left" style="position:relative; width:64px; height:64px; overflow:hidden;">
		  <a href="#">
			<img src ="<?echo($picP2);?>" width="64" height="64" />
		  </a>
	  </div>
	  <?}?>
	  <div class="pull-right" style="width:128px;">

		<div style="float:left; position:relative; width:64px; height:64px; background:url(img/football_thumbs.jpg) -<?echo($x1 );?>px -<?echo($y1);?>px; overflow:hidden;">
		  <a href="#">
		  </a>
		</div>
		<div style="float:left; position:relative; width:64px; height:64px; background:url(img/football_thumbs.jpg) -<?echo($x2 );?>px -<?echo($y2);?>px; overflow:hidden;">
		  <a href="#">
		  </a>
		</div>
		
	  </div>
	  
	  <div class="media-body">
		<h4>
			<?echo($p1);
			if($p2 != -1)
				echo(' ' . $p2);
			?> 
			<strong style="color:red;">$<? echo(5 + rand(0, 20) ); ?> </strong>
		</h4>
		

		<div class="media">
			<? if($hasOpponent == false)
			{?>
				<a href="#"> Take Challenge |</a>
			<?}?>
		   <a href="#"> Send Message </a>
		   
		   <? if($hasOpponent == true)
			{?>
				<a href="#">| Ask to join</a>
			<?}?>
		   
		</div>
	
	  </div>
	</div>
<?
}


function display_random_Head2Head_other_players($p1,$picP1,$p2,$picP2,$x1,$y1,$x2,$y2)
{
	$picP1 = "img/profile_thumb/" . $picP1;
	$picP2 = "img/profile_thumb/" . $picP2;
?>
  <div class="media">
	<div class="pull-left" style="position:relative; width:64px; height:64px; overflow:hidden;">
		  
		   <a href="#">
			<img src ="<?echo($picP2);?>" width="64" height="64" />
		  </a>
	  </div>
	  <div class="pull-left" style="position:relative; width:64px; height:64px; overflow:hidden;">
		  <a href="#">
			<img src ="<?echo($picP1);?>" width="64" height="64" />
		  </a>
	  </div>
	  
	  
	  <div class="pull-right" "style="width:128px;">

		<div style="float:left; position:relative; width:64px; height:64px; background:url(img/football_thumbs.jpg) -<?echo($x1 );?>px -<?echo($y1);?>px; overflow:hidden;">
		  <a href="#">
		  </a>
		</div>
		<div style="float:left; position:relative; width:64px; height:64px; background:url(img/football_thumbs.jpg) -<?echo($x2 );?>px -<?echo($y2);?>px; overflow:hidden;">
		  <a href="#">
		  </a>
		</div>
		
	  </div>
	  
	  <div class="media-body">
		<h4>
			<?echo($p1);?> vs. <?echo($p2);?>
			<strong style="color:red;">$<? echo(5 + rand(0, 20) ); ?> </strong>
		</h4>
		<?
		if($viewOnly != true)
		{?>	
		<div class="media">
			
		   <a href="#"> Send Message |</a>
		   <a href="#"> Accept Challenge</a>
		</div>
		<?}?>
	  </div>
	</div>
<?
}

function display_random_Challenges_viewOnly($x1,$y1,$x2,$y2) 
{
	$people = array("Brandon Shrewsbury","Natalie Attaya","Taylor Stanley","Shelly Brenckman","Jesus Morales","Travis Crawford");
	$pic = array("Brandon_Shrewsbury.jpg","Natalie_Attaya.jpg","Taylor_Stanley.jpg","Shelly_Brenckman.jpg","Jesus_Morales.jpg","Travis_Crawford.jpg");
	$numberOfEntries = rand(4, 16);
	for ($j = 0; $j < $numberOfEntries; $j++) {
		$p1 = rand(0, sizeof($people) - 1);
		$p2 = rand(0, sizeof($people) - 1);
		while($p2 == $p1)
		{
			$p2 = rand(0, sizeof($people) - 1);
		}	
		display_random_Head2Head_other_players($people[$p1],$pic[$p1],$people[$p2],$pic[$p2],$x1,$y1,$x2,$y2);
	}
}


function display_random_open_Challenges($x1,$y1,$x2,$y2,$hasOpponent) 
{
	$people = array("Brandon Shrewsbury","Natalie Attaya","Taylor Stanley","Shelly Brenckman","Jesus Morales","Travis Crawford");
	$pic = array("Brandon_Shrewsbury.jpg","Natalie_Attaya.jpg","Taylor_Stanley.jpg","Shelly_Brenckman.jpg","Jesus_Morales.jpg","Travis_Crawford.jpg");
	$numberOfEntries = rand(4, 16);
	for ($j = 0; $j < $numberOfEntries; $j++) {
		$p1 = rand(0, sizeof($people) - 1);
		if($x1 == -1)
		{
			$x1 = rand(0, 4)  * 76+15;
			$y1 = rand(0, 13) * 114+4;
			$x2 = rand(0, 4)  * 76+15;
			$y2 = rand(0, 13) * 114+4;
		}
		if($hasOpponent == false)
		{		
			display_random_open($people[$p1],$pic[$p1],-1,-1,$x1,$y1,$x2,$y2,false);
		} else {
			$p2 = rand(0, sizeof($people) - 1);
			display_random_open($people[$p1],$pic[$p1],$people[$p2],$pic[$p2],$x1,$y1,$x2,$y2,true);
		}
	}
}




?>