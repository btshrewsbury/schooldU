<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . "/simpletest/autorun.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/structs/user.php");

class TestOfUserStruct extends UnitTestCase {
    function __construct() {
        parent::__construct('User Test');
    }

	function testUserCreationStoreAndDelete() {	
		$aUser = new User(null);
		$this->assertNull($aUser->get_user_id());
		
		
		$this->assertNull($aUser->get_user_id());
		$this->assertNull($aUser->get_email());
		$this->assertNull($aUser->get_fb_id());
		$this->assertNull($aUser->get_fb_access_token());
		$this->assertNull($aUser->get_profile_pic());
		$this->assertNull($aUser->get_first_name());	
		$this->assertNull($aUser->get_last_name());
		$this->assertNull($aUser->get_cc_oauth());
		$this->assertNull($aUser->get_cc_refresh());
		$this->assertNull($aUser->get_school_id());
		$this->assertNull($aUser->get_school());

		$aUser->set_email("test_email@yahoo.com");
		$aUser->set_fb_id(9123456879);
		$aUser->set_fb_access_token(9876543210);
		$aUser->set_profile_pic("test_pic.jpg");
		$aUser->set_first_name("test");	
		$aUser->set_last_name("user");
		$aUser->set_cc_oauth(123456789);
		$aUser->set_cc_refresh(987654321);
		$aUser->set_school_id(9);
		
		$this->assertNull($aUser->get_user_id());
		$this->assertEqual($aUser->get_email(),"test_email@yahoo.com");
		$this->assertEqual($aUser->get_fb_id(),9123456879);
		$this->assertEqual($aUser->get_fb_access_token(),9876543210);
		$this->assertEqual($aUser->get_profile_pic(),"test_pic.jpg");
		$this->assertEqual($aUser->get_first_name(),"test");	
		$this->assertEqual($aUser->get_last_name(),"user");
		$this->assertEqual($aUser->get_cc_oauth(),123456789);
		$this->assertEqual($aUser->get_cc_refresh(),987654321);
		$this->assertEqual($aUser->get_school_id(),9);
		$this->assertEqual($aUser->get_school()->get_name(),"Texas A&M");

		$aUser->save();
		$this->assertNotNull($aUser->get_user_id());
		$sameUser = User::getUserById($aUser->get_user_id());
		
		$this->assertEqual($sameUser->get_user_id(),$aUser->get_user_id());
		$this->assertEqual($sameUser->get_email(),"test_email@yahoo.com");
		$this->assertEqual($sameUser->get_fb_id(),9123456879);
		$this->assertEqual($sameUser->get_fb_access_token(),9876543210);
		$this->assertEqual($sameUser->get_profile_pic(),"test_pic.jpg");
		$this->assertEqual($sameUser->get_first_name(),"test");	
		$this->assertEqual($sameUser->get_last_name(),"user");
		$this->assertEqual($sameUser->get_cc_oauth(),123456789);
		$this->assertEqual($sameUser->get_cc_refresh(),987654321);
		$this->assertEqual($sameUser->get_school_id(),9);
		$this->assertEqual($sameUser->get_school()->get_name(),"Texas A&M");
	
		$sameUser->delete();
		$sameUser = User::getUserById($aUser->get_user_id());
		$this->assertNull($sameUser);
		
    }
}
?>