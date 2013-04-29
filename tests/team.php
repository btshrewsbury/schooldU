<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . "/simpletest/autorun.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/team.php");

class TestOfTeamStruct extends UnitTestCase {
    function __construct() {
        parent::__construct('team struct Test');
    }

	function testTeamCreationStoreAndDelete() {	
		$aTeam = new Team(null);
		
		$this->assertNull($aTeam->get_team_id());
		$this->assertNull($aTeam->get_name());
		$this->assertNull($aTeam->get_photo());
		$this->assertNull($aTeam->get_logo());	
		$this->assertNull($aTeam->get_sport_id());
		$this->assertNull($aTeam->get_sport());
		$this->assertNull($aTeam->get_school_id());
		$this->assertNull($aTeam->get_school());
		
		$aTeam->set_name("test_team");
		$aTeam->set_photo("test_photo.jpg");
		$aTeam->set_logo("test_logo.png");	
		$aTeam->set_sport_id(1);
		$aTeam->set_school_id(9);
		
		$this->assertNull($aTeam->get_team_id());
		$this->assertEqual($aTeam->get_name(),"test_team");
		$this->assertEqual($aTeam->get_photo(),"test_photo.jpg");
		$this->assertEqual($aTeam->get_logo(),"test_logo.png");	
		$this->assertEqual($aTeam->get_sport_id(),1);
		$this->assertNotNull($aTeam->get_sport()->get_type(),"test_sport");
		$this->assertEqual($aTeam->get_school_id(),9);
		$this->assertNotNull($aTeam->get_school()->get_name(),"test_school");
		
		$aTeam->save();
		$this->assertNotNull($aTeam->get_team_id());
		
		$sameTeam = Team::getTeamById($aTeam->get_team_id());
		$this->assertEqual($sameTeam->get_team_id(),$aTeam->get_team_id());;
		$this->assertEqual($sameTeam->get_name(),"test_team");
		$this->assertEqual($sameTeam->get_photo(),"test_photo.jpg");
		$this->assertEqual($sameTeam->get_logo(),"test_logo.png");	
		$this->assertEqual($sameTeam->get_sport_id(),1);
		$this->assertNotNull($sameTeam->get_sport()->get_type(),"test_sport");
		$this->assertEqual($sameTeam->get_school_id(),9);
		$this->assertNotNull($sameTeam->get_school()->get_name(),"test_school");

		$sameTeam->delete();
		$sameTeam = Team::getTeamById($aTeam->get_team_id());
		$this->assertNull($sameTeam);
    }	
}

?>