<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/social/fb/facebook.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/user.php");

$facebook = new Facebook(array(
  'appId'  => '184934348318098',
  'secret' => '80652ff76449dfd44c5bb4a9e8af9ea4',
));

$sid = session_id();
if(!isset($sid)) {
    session_start();
}

function isLoggedIn() {
	if(isset($_SESSION['me']))
	{
		return TRUE;
	}
	return FALSE;
}

function getMe() {
	if(isset($_SESSION['me']))
	{
		return $_SESSION['me'];
	}
	return null;
}

?>
