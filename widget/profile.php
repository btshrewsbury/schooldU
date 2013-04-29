<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/widget/login.php");

if(isLoggedIn()) {
	show_profile_widget();
} else {
	show_login_widget(null);
}

function show_profile_widget(){
	$me = getMe();
	$topCharity = $me->getTopCharities(1);
	if(count($topCharity) > 0)
	{
		$charityName = $topCharity->get_name();
	} else {
		$charityName = "None Yet";
	}
	
?>
	<div class="well" style="margin-bottom:6px;height:158px;">
	
		<div class="media">
			  
			<div class="media-body">
					<img class="pull-left" src="<?echo($me->get_profile_pic());?>" style="margin-right:10px;"/>
					<h5 > <?echo($me->get_name());?></h5>	<br/>
					<div class="clearfix">
						
						<span class="label ">Favorite Charity:</span> <?echo($charityName);?><br/>
						<span class="label label-success">Donated:</span> $<?echo($me->getAmountDonated());?><br/>
						<span class="label label-info">Games Won:</span> <?echo($me->getNumberWon());?><br/>
						<span class="label label-important">Games Lost:</span> <?echo($me->getNumberLost());?><br/>
					</div>
			</div>
		</div>
	
		
		
		
	</div>
<?}?>
