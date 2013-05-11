<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");

function postToWall($message, $link)
{
	global $facebook;
	$msg = array(
	'link' => $link,
	'message' => $message,
	'picture' => 'http://schooldu.com/img/Schooldu_app.png'
	);
	
	try {
		$postResult = $facebook->api('/me/feed', 'POST', $msg );
	} catch (FacebookApiException $e) {

	}

}
?>