<?php 
/* SVN FILE: $Id$ */
/* OptionsController Test cases generated on: 2009-07-28 17:07:13 : 1248795613*/
App::import('Controller', 'Options');

class TestOptions extends OptionsController {
	var $autoRender = false;
}

class OptionsControllerTest extends CakeTestCase {
	var $Options = null;

	function setUp() {
		$this->Options = new TestOptions();
		$this->Options->constructClasses();
	}

	function testOptionsControllerInstance() {
		$this->assertTrue(is_a($this->Options, 'OptionsController'));
	}

	function tearDown() {
		unset($this->Options);
	}
}
?>