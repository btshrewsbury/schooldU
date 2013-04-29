<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");

function postToWall($message, $link)
{
	global $facebook;
	$msg = array(
	'link' => $link,
	'message' => $message
	);
	
	try {
		$postResult = $facebook->api('/me/feed', 'POST', $msg );
	} catch (FacebookApiException $e) {

	}

}
?>