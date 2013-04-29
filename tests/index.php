<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER["DOCUMENT_ROOT"] . "/tests/charity.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/tests/head2head.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/tests/game.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/tests/pool.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/tests/school.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/tests/sport.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/tests/team.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/tests/user.php");

require_once($_SERVER["DOCUMENT_ROOT"] . "/simpletest/autorun.php");
    
class AllTests extends TestSuite {
    function AllTests() {
        parent::__construct();
        
    }
}
?>