<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");


function showFriends($challenge) 
{
	global $facebook;
	$challengeId = $challenge->get_challenge_id();
	$theGame = $challenge->get_game();
	$winTeam = $challenge->get_team();
	$loseTeam = $theGame->get_other_team($winTeam->get_team_id());
	$amount = $challenge->get_amount();
	$date = $theGame->get_date();
	$winTeamName = $winTeam->get_name();		
	$loseTeamName = $loseTeam->get_name();
	$charity = $challenge->get_charity();
	$charityName = $charity->get_name();
	$me = getMe();
	$name = $me->get_name();
	$gameLink = "https://schooldu.com/game_details.php?gid=" . $theGame->get_game_id();
	$head2headMsg = "$name put down $$amount.00 for $charityName and thinks $winTeamName is going to kick $loseTeamName's arse during March Madness. Are you ready to put money up for charity? For glory? For the chance to rub $winTeamName's loss in $name's face?";
	$head2headLink = "https://schooldu.com/game_details.php?cid=" . $challengeId;
	$head2headTitle = "Created a Head 2 Head Donation Challenge";	

	?>
	<div>
		<a href="<?echo($gameLink);?>" class="btn btn-info pull-right"><b>Finish</b></a>
			
		<h5 class="text-info">Challenge Your Friends</h5>
		<blockquote>
		  <p>Yo dawg, We just posted this Head 2 Head challenge to your Facebook Wall. If you know the person you want to challenge you can send them the info Below. If you want to challenge a few people, 
			we reccommend tagging them in the post we made for you.</p>
		  <small>Happy hunting</small>
		</blockquote>
		<div class="well">
			<b class="text-info">Manually Share Challenge Link: </b><a href="https://schooldu.com/game_details.php?cid=<?echo($challengeId);?>">https://schooldu.com/game_details.php?cid=<?echo($challengeId);?></a>
		</div>
		
		<div class="row-fluid">
			<button class="btn btn-info disabled span4" id="postWallButton" style="min-height:40px;"><img src="img/glyphicons_022_fire.png" alt="post" style="margin-right:10px;"/> <b>Post on Friends Wall</b> </button>
			<button class="btn btn-info disabled span4" id="sendMessageButton" style="min-height:40px;" ><img src="img/glyphicons_039_notes.png" alt="send" style="margin-right:10px;"/> <b> Send Message</b> </button>
		</div>
	</div>
	<br/>
	<script>
		var head2headMsgDescription = "<?echo($head2headMsg);?>";
		var head2headMsgLink = "<?echo($head2headLink);?>";
		var head2headMsgTitle = "<?echo($head2headTitle);?>";
		var linkName = "Schoold U Donation Challenge"
		var to = "";
	</script>
	
	<div id="friends_container">
		<div class='row-fluid'>
		
		<?
		$friends = $facebook->api('/me/friends');
		$friends = $friends['data'];
		asort($friends);
		$i = 0;
		foreach($friends as $friend)
		{
			if($i % 3 == 0)
			{
				echo '</div><div class="row-fluid">';
			}
		?>
		
			<div class="btn btn-block friendOption span4 friendButton" name="<?echo($friend['id']);?>">
				<div class="pull-left" style="margin-left:4px;">
					<img src='http://graph.facebook.com/<?echo($friend['id']);?>/picture'></img>
				</div>
				<div class="media-body" style="padding: 15px 0px;">
						<strong><?echo($friend['name']);?></strong><br/>			
				</div>
			</div>
			
			
		<?
			$i++;
		}?>
		</div>
	</div>
	<script>
	
	function parseFriendsIds()
	{
		to = "";
		users = $('.clickedFriend');
		addComma = false;
		for(i = 0; i < users.length; i++)
		{
			if(addComma == true)
				to+= ",";
			to+= users[i].getAttribute("name");
			addComma = true;
		}
		
	}
	$("#postWallButton").click(function() {
		if($(this).hasClass('disabled'))
			return;
		parseFriendsIds();
		postToFbWall(to,head2headMsgLink,head2headMsgTitle,head2headMsgDescription);
	});
	
	$("#sendMessageButton").click(function() {
		if($(this).hasClass('disabled'))
			return;
		parseFriendsIds();
		sendFbMessage(to,head2headMsgLink,head2headMsgTitle,head2headMsgDescription);
	});
	
	$(".friendButton").click(function() {
		$(".friendButton").removeClass('clickedFriend');
		$(".friendButton").removeClass('btn-success');
		
		$(this).addClass('clickedFriend');
		$(this).addClass('btn-success');
		
		$('#sendMessageButton').removeClass('disabled');
		$('#postWallButton').removeClass('disabled');
		
	});
	</script>
	
	
	
<?
}

function showFriendsForPool($challenge) 
{
	global $facebook;
	$challengeId = $challenge->get_challenge_id();
	$theGame = $challenge->get_game();
	$homeTeam = $theGame->get_home_team();
	$awayTeam = $theGame->get_away_team();
	$amount = $challenge->get_amount();
	$date = $theGame->get_date();
	$homeTeamName = $homeTeam->get_name();		
	$awayTeamName = $awayTeam->get_name();
	$gameLink = "https://schooldu.com/game_details.php?gid=" . $theGame->get_game_id();
	//$charity = $challenge->get_charity();
	//$charityName = $charity->get_name();
	$me = getMe();
	$name = $me->get_name();
		
	$msg = "March Madness Schoold U Beta - Pooled Challenge Creation Auto Post";
	$link = "https://schooldu.com";
	$title = "Joined the Schoold U Pooled Donation Challenge";	

	?>
	<div>
		<a href="<?echo($gameLink);?>" class="btn btn-info pull-right"><b>Finish</b></a>
		<h5 class="text-info">Tell Your Friends</h5>
		<blockquote>
		  <p>You have successfully joined the <?echo("$homeTeamName vs. $awayTeamName");?> pool. Schoold U thanks you for your philanthropy! We've posted a message about how awesome you are to your Facebook Wall. Please spread the word, these charities need our help! If you know the person you want to tell you can send them the info Below. If you want to tell a few people, 
			we recommend tagging them in the post we made for you.</p>
		  <small>Happy hunting</small>
		</blockquote>
				
		<div class="row-fluid">
			<button class="btn btn-info disabled span4" id="postWallButton" style="min-height:40px;"><img src="img/glyphicons_022_fire.png" alt="post" style="margin-right:10px;"/> <b>Post on Friends Wall</b> </button>
			<button class="btn btn-info disabled span4" id="sendMessageButton" style="min-height:40px;" ><img src="img/glyphicons_039_notes.png" alt="send" style="margin-right:10px;"/> <b> Send Message</b> </button>
		</div>
	</div>
	<br/>
	<script>
		var descrip = "<?echo($msg);?>";
		var link = "<?echo($link);?>";
		var title = "<?echo($title);?>";
		var linkName = "Schoold U Donation Challenge"
		var to = "";
	</script>
	
	<div id="friends_container">
		<div class='row-fluid'>
		
		<?
		$friends = $facebook->api('/me/friends');
		$friends = $friends['data'];
		asort($friends);
		$i = 0;
		foreach($friends as $friend)
		{
			if($i % 3 == 0)
			{
				echo '</div><div class="row-fluid">';
			}
		?>
		
			<div class="btn btn-block friendOption span4 friendButton" name="<?echo($friend['id']);?>">
				<div class="pull-left" style="margin-left:4px;">
					<img src='http://graph.facebook.com/<?echo($friend['id']);?>/picture'></img>
				</div>
				<div class="media-body" style="padding: 15px 0px;">
						<strong><?echo($friend['name']);?></strong><br/>			
				</div>
			</div>
			
			
		<?
			$i++;
		}?>
		</div>
	</div>
	<script>
	
	function parseFriendsIds()
	{
		to = "";
		users = $('.clickedFriend');
		addComma = false;
		for(i = 0; i < users.length; i++)
		{
			if(addComma == true)
				to+= ",";
			to+= users[i].getAttribute("name");
			addComma = true;
		}
		
	}
	$("#postWallButton").click(function() {
		if($(this).hasClass('disabled'))
			return;
		parseFriendsIds();
		postToFbWall(to,link,title,descrip);
	});
	
	$("#sendMessageButton").click(function() {
		if($(this).hasClass('disabled'))
			return;
		parseFriendsIds();
		sendFbMessage(to,link,title,descrip);
	});
	
	$(".friendButton").click(function() {
		$(".friendButton").removeClass('clickedFriend');
		$(".friendButton").removeClass('btn-success');
		
		$(this).addClass('clickedFriend');
		$(this).addClass('btn-success');
		
		$('#sendMessageButton').removeClass('disabled');
		$('#postWallButton').removeClass('disabled');
		
	});
	</script>
	
	
	
<?
}
?>