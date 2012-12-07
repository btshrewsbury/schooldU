<?php

class User
{
    public $name;
	public $email;
	public $homeSchool;
	public $pictureUrl;
	public $activeChallenges = array();
	public $pendingChallenges = array();
	public $completedChallenges = array();
	public $moneyDonated;
	public $matchesWon;
	
	public function __construct() {
       
   }
}

function displayFriends($number)
{
	global $mockUsers;
	$mockUsers->resetUniqueIndex();
	for($i = 0; $i < $number; $i++)
	{
		$aUser = $mockUsers->getUniqueUser();
		if(isset($aUser))
			displayFriend($aUser);
	}
}

function displayFriend($user)
{?>
	<div class="pull-left">
		<div style="float:left; position:relative; width:64px; height:64px; overflow:hidden;">
		  <a href="#">
			<img src ="<?echo($user->pictureUrl);?>" width="64" height="64" />
		  </a>
		</div>
		<div style="float:left; padding-left:22px; position:relative; width:200px; height:64px; overflow:hidden;">
			  <strong><?echo($user->name);?></strong>
		</div>
	</div>
<?}

?>