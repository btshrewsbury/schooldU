<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/head2head.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/simpletest/autorun.php");

class TestOfHead2HeadStruct extends UnitTestCase {
    function __construct() {
        parent::__construct('challenge struct Test');
    }

	function testHead2HeadCreationStoreAndDelete() {	
		$aHead2Head = new Head2Head(null);
		
		$this->assertNull($aHead2Head->get_challenge_id());
		$this->assertNull($aHead2Head->get_user_id());
		$this->assertNull($aHead2Head->get_user());
		$this->assertNull($aHead2Head->get_team_id());
		$this->assertNull($aHead2Head->get_team());
		$this->assertNull($aHead2Head->get_game_id());
		$this->assertNull($aHead2Head->get_game());
		$this->assertNull($aHead2Head->get_charity_id());
		$this->assertNull($aHead2Head->get_charity());
		$this->assertNull($aHead2Head->get_paired_challenge_id());	
		$this->assertNull($aHead2Head->get_paired_challenge());	
		$this->assertNull($aHead2Head->get_amount());
		$this->assertNull($aHead2Head->get_won());
		
		$aHead2Head->set_user_id(97);
		$aHead2Head->set_team_id(461);
		$aHead2Head->set_game_id(167451);
		$aHead2Head->set_charity_id(9);	
		$aHead2Head->set_amount(5);
		
		$this->assertNull($aHead2Head->get_challenge_id());
		$this->assertEqual($aHead2Head->get_user_id(),97);
		$this->assertNotNull($aHead2Head->get_user());
		$this->assertEqual($aHead2Head->get_team_id(),461);
		$this->assertNotNull($aHead2Head->get_team());
		$this->assertEqual($aHead2Head->get_game_id(),167451);
		$this->assertNotNull($aHead2Head->get_game());
		$this->assertEqual($aHead2Head->get_charity_id(),9);
		$this->assertNotNull($aHead2Head->get_charity());
		$this->assertEqual($aHead2Head->get_paired_challenge_id(),0);	
		$this->assertNull($aHead2Head->get_paired_challenge());	
		$this->assertEqual($aHead2Head->get_amount(),5);
		$this->assertEqual($aHead2Head->get_won(),0);
		
		$aHead2Head->save();
		$this->assertNotNull($aHead2Head->get_challenge_id());
		
		$sameHead2Head = Head2Head::getChallengeById($aHead2Head->get_challenge_id());
		$this->assertEqual($sameHead2Head->get_challenge_id(),$aHead2Head->get_challenge_id());
		$this->assertEqual($sameHead2Head->get_user_id(),97);
		$this->assertNotNull($sameHead2Head->get_user());
		$this->assertEqual($sameHead2Head->get_team_id(),461);
		$this->assertNotNull($sameHead2Head->get_team());
		$this->assertEqual($sameHead2Head->get_game_id(),167451);
		$this->assertNotNull($sameHead2Head->get_game());
		$this->assertEqual($sameHead2Head->get_charity_id(),9);
		$this->assertNotNull($sameHead2Head->get_charity());
		$this->assertEqual($sameHead2Head->get_paired_challenge_id(),0);	
		$this->assertNull($sameHead2Head->get_paired_challenge());	
		$this->assertEqual($sameHead2Head->get_amount(),5);
		$this->assertEqual($sameHead2Head->get_won(),0);
		
		$sameHead2Head->delete();
		$sameHead2Head = Head2Head::getChallengeById($aHead2Head->get_challenge_id());
		$this->assertNull($sameHead2Head);
    }
	
	function testHead2HeadMatchup() {	
		$aHead2Head = new Head2Head(null);
		
		$aHead2Head->set_user_id(97);
		$aHead2Head->set_team_id(461);
		$aHead2Head->set_game_id(167451);
		$aHead2Head->set_charity_id(9);	
		$aHead2Head->set_amount(5);
		$aHead2Head->save();
		
		$bHead2Head = new Head2Head(null);
		
		$bHead2Head->set_user_id(98);
		$bHead2Head->set_team_id(326);
		$bHead2Head->set_game_id(167451);
		$bHead2Head->set_charity_id(9);	
		$bHead2Head->set_amount(5);
		$bHead2Head->set_paired_challenge_id($aHead2Head->get_challenge_id());
		$bHead2Head->save();
		
		$this->assertNotNull($bHead2Head->get_paired_challenge());
		$aHead2Head->set_paired_challenge_id($bHead2Head->get_challenge_id());
		$aHead2Head->save();
		$this->assertNotNull($aHead2Head->get_paired_challenge());

		$aHead2Head->delete();
		$bHead2Head->delete();
    }
	
	
}
?>