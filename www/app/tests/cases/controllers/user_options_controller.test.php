<?php 
/* SVN FILE: $Id$ */
/* UserOptionsController Test cases generated on: 2009-07-28 17:07:13 : 1248795613*/
App::import('Controller', 'UserOptions');

class TestUserOptions extends UserOptionsController {
	var $autoRender = false;
}

class UserOptionsControllerTest extends CakeTestCase {
	var $UserOptions = null;

	function setUp() {
		$this->UserOptions = new TestUserOptions();
		$this->UserOptions->constructClasses();
	}

	function testUserOptionsControllerInstance() {
		$this->assertTrue(is_a($this->UserOptions, 'UserOptionsController'));
	}

	function tearDown() {
		unset($this->UserOptions);
	}
}
?>