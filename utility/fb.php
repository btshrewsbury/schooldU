<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/user.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");

$user = $facebook->getUser();
if($user && !isLoggedIn())
{
	$aUser = User::getUserByFbId($user);
	if(!isset($aUser))
	{
		registerFbUser($facebook);
		
	} else {
		$_SESSION['me'] = $aUser;
	}
	
}

header( 'Location: https://schooldu.com/' ) ;

function registerFbUser($facebook)
{
	$user_profile = $facebook->api('/me');
	$newUser = new User(null);
	$newUser->set_fb_access_token($facebook->getAccessToken());
	$newUser->set_fb_id($user_profile['id']);
	//$newUser->fb_code($facebook->getAccessToken());
	$newUser->set_profile_pic("https://graph.facebook.com/" . $newUser->get_fb_id() . "/picture");
	$newUser->set_first_name($user_profile['first_name']);
	$newUser->set_last_name($user_profile['last_name']);
	//$newUser->set_email(null);
	$newUser->save();
	$_SESSION['me'] = $newUser;
}

?>
