<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/school.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/simpletest/autorun.php");

class TestOfSchoolStruct extends UnitTestCase {
    function __construct() {
        parent::__construct('School Test');
    }

	function testSchoolCreationStoreAndDelete() {	
		$aSchool = new School(null);
		$this->assertNull($aSchool->get_school_id());
		$this->assertNull($aSchool->get_name());
		$this->assertNull($aSchool->get_city());
		$this->assertNull($aSchool->get_state());
		$this->assertNull($aSchool->get_charity_id());
		$this->assertNull($aSchool->get_charity());
	
		$aSchool->set_name("test_school");
		$aSchool->set_city("college station");
		$aSchool->set_state("Tx");
		$aSchool->set_charity_id(21);
	
		$this->assertNull($aSchool->get_school_id());
		$this->assertEqual($aSchool->get_name(),"test_school");
		$this->assertEqual($aSchool->get_city(),"college station");
		$this->assertEqual($aSchool->get_state(),"Tx");
		$this->assertEqual($aSchool->get_charity_id(),21);
		$this->assertNotNull($aSchool->get_charity());
		
		$aSchool->save();
		
		$sameSchool = School::getSchoolById($aSchool->get_school_id());
		$this->assertEqual($sameSchool->get_school_id(),$aSchool->get_school_id());
		$this->assertEqual($sameSchool->get_name(),"test_school");
		$this->assertEqual($sameSchool->get_city(),"college station");
		$this->assertEqual($sameSchool->get_state(),"Tx");
		$this->assertEqual($sameSchool->get_charity_id(),21);
		$this->assertEqual($sameSchool->get_charity()->get_charity_id(),21);

		$sameSchool->delete();
		$sameSchool = School::getSchoolById($aSchool->get_school_id());
		$this->assertEqual(count($sameSchool), 0);
    }
}
?>