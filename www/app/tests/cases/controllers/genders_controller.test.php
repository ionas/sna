<?php 
/* SVN FILE: $Id$ */
/* GendersController Test cases generated on: 2009-12-01 17:12:39 : 1259683239*/
App::import('Controller', 'Genders');

class TestGenders extends GendersController {
	var $autoRender = false;
}

class GendersControllerTest extends CakeTestCase {
	var $Genders = null;

	function setUp() {
		$this->Genders = new TestGenders();
		$this->Genders->constructClasses();
	}

	function testGendersControllerInstance() {
		$this->assertTrue(is_a($this->Genders, 'GendersController'));
	}

	function tearDown() {
		unset($this->Genders);
	}
}
?>