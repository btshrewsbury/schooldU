<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . "/simpletest/autorun.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/sport.php");

class TestOfSportStruct extends UnitTestCase {
    function __construct() {
        parent::__construct('Sport Test');
    }

	function testSportCreationStoreAndDelete() {	
		$aSport = new Sport(null);
		$this->assertNull($aSport->get_sport_id());
		$this->assertNull($aSport->get_type());
		
		$aSport->set_type("test_sport");
		
		$this->assertNull($aSport->get_sport_id());
		$this->assertEqual($aSport->get_type(),"test_sport");
		
		$aSport->save();
		$this->assertNotNull($aSport->get_sport_id());

		$sameSport = Sport::getSportById($aSport->get_sport_id());
		$this->assertEqual($sameSport->get_type(),"test_sport");

		$sameSport->delete();
		$sameSport = Sport::getSportById($aSport->get_sport_id());
		$this->assertEqual(count($sameSport), 0);
		
    }
}
?>