<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/charity.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/simpletest/autorun.php");
class TestOfCharityStruct extends UnitTestCase {
    function __construct() {
        parent::__construct('Charity Test');
    }

	function testCharityCreationStoreAndDelete() {	
		$aCharity = new Charity(null);
		$this->assertNull($aCharity->get_charity_id());
		$this->assertNull($aCharity->get_name());
		
		$aCharity->set_name("test_charity");
		
		$this->assertNull($aCharity->get_charity_id());
		$this->assertEqual($aCharity->get_name(),"test_charity");
		
		$aCharity->save();
		$this->assertNotNull($aCharity->get_charity_id());
		
		$sameCharity = Charity::getCharityById($aCharity->get_charity_id());
		$this->assertEqual($sameCharity->get_name(),"test_charity");
		
		$sameCharity->delete();
		$sameCharity = Charity::getCharityById($aCharity->get_charity_id());
		$this->assertEqual(count($sameCharity), 0);
		
    }
}
?>