<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/head2head.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/pool.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utility/account.php");


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$cid = $_POST['cid']; 
	$type = $_POST['type']; 
	echo("cid: $cid, type= $type");
	
	if($type == "head2headOpen")	{
		$challenge = Head2Head::getChallengeById($cid);
		if($challenge->get_user_id() == getMe()->get_user_id())
		{
			$challenge->delete();
		}
		
	} elseif($type == "activePool")	{
		$challenge = Pool::getChallengeById($cid);
		if($challenge->get_user_id() == getMe()->get_user_id())
		{
			$challenge->delete();
		}
		
	}
}
?>
