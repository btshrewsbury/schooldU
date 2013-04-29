<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/game.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/simpletest/autorun.php");
class TestOfGameStruct extends UnitTestCase {
    function __construct() {
        parent::__construct('game struct Test');
    }

	function testGameCreationStoreAndDelete() {	
		$aGame = new Game(null);
		
		$this->assertNull($aGame->get_game_id());
		$this->assertNull($aGame->get_date());
		$this->assertNull($aGame->get_time());
		$this->assertNull($aGame->get_home_team_id());
		$this->assertNull($aGame->get_away_team_id());
		$this->assertNull($aGame->get_home_team());
		$this->assertNull($aGame->get_away_team());
		$this->assertNull($aGame->get_stadium());
		$this->assertNull($aGame->get_is_finished());
		$this->assertNull($aGame->get_home_team_score());
		$this->assertNull($aGame->get_away_team_score());
		
		$aGame->set_date(date( 'Y-m-d', 0 ));
		$aGame->set_time(date( 'G:i:s', 0 ));
		$aGame->set_home_team_id(203);
		$aGame->set_away_team_id(39);
		$aGame->set_stadium("test_stadium");
		$aGame->set_is_finished(1);
		$aGame->set_home_team_score(10);
		$aGame->set_away_team_score(8);
		
		$this->assertNull($aGame->get_game_id());
		$this->assertEqual($aGame->get_date(),date( 'Y-m-d', 0));
		$this->assertEqual($aGame->get_time(),date( 'G:i:s', 0));
		$this->assertEqual($aGame->get_home_team_id(),203);
		$this->assertEqual($aGame->get_away_team_id(),39);
		$this->assertNotNull($aGame->get_home_team());
		$this->assertNotNull($aGame->get_away_team());
		$this->assertEqual($aGame->get_stadium(),"test_stadium");
		$this->assertEqual($aGame->get_is_finished(),1);
		$this->assertEqual($aGame->get_home_team_score(),10);
		$this->assertEqual($aGame->get_away_team_score(),8);
		
		$aGame->save();
		$this->assertNotNull($aGame->get_game_id());
		
		$sameGame = Game::getGameById($aGame->get_game_id());
		$this->assertNotNull($sameGame->get_game_id());
		$this->assertEqual($sameGame->get_date(),date( 'Y-m-d', 0));
		$this->assertEqual($sameGame->get_time(),date( 'G:i:s', 0));
		$this->assertEqual($sameGame->get_home_team_id(),203);
		$this->assertEqual($sameGame->get_away_team_id(),39);
		$this->assertNotNull($sameGame->get_home_team());
		$this->assertNotNull($sameGame->get_away_team());
		$this->assertEqual($sameGame->get_stadium(),"test_stadium");
		$this->assertEqual($sameGame->get_is_finished(),1);
		$this->assertEqual($sameGame->get_home_team_score(),10);
		$this->assertEqual($sameGame->get_away_team_score(),8);
		
		$sameGame->delete();
		$sameGame = Game::getGameById($aGame->get_game_id());
		$this->assertNull($sameGame);
		
    }
	
	function testSumOfCharityAmounts()
	{
		$aGame = Game::getGameById(167451);
		$this->assertEqual($aGame->get_pooled_amount(),0);		
		$aGame = Game::getGameById(167434);
		$this->assertEqual($aGame->get_pooled_amount(),0);
		
		$aGame = Game::getGameById(167451);
		$this->assertEqual($aGame->get_head2head_amount(),163);
		$this->assertEqual($aGame->get_head2head_amount_matched(),0);
		$this->assertEqual($aGame->get_head2head_amount_unmatched(),163);
	}

}
?>