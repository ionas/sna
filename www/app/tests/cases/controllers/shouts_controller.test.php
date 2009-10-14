<?php 
/* SVN FILE: $Id$ */
/* ShoutsController Test cases generated on: 2009-10-05 18:10:11 : 1254758771*/
App::import('Controller', 'Shouts');

class TestShouts extends ShoutsController {
	var $autoRender = false;
}

class ShoutsControllerTest extends CakeTestCase {
	var $Shouts = null;

	function setUp() {
		$this->Shouts = new TestShouts();
		$this->Shouts->constructClasses();
	}

	function testShoutsControllerInstance() {
		$this->assertTrue(is_a($this->Shouts, 'ShoutsController'));
	}

	function tearDown() {
		unset($this->Shouts);
	}
}
?>