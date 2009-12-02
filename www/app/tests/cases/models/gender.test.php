<?php 
/* SVN FILE: $Id$ */
/* Gender Test cases generated on: 2009-12-01 17:12:28 : 1259683228*/
App::import('Model', 'Gender');

class GenderTestCase extends CakeTestCase {
	var $Gender = null;
	var $fixtures = array('app.gender', 'app.profile', 'app.user');

	function startTest() {
		$this->Gender =& ClassRegistry::init('Gender');
	}

	function testGenderInstance() {
		$this->assertTrue(is_a($this->Gender, 'Gender'));
	}

	function testGenderFind() {
		$this->Gender->recursive = -1;
		$results = $this->Gender->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Gender' => array(
			'id'  => 1,
			'is_hidden'  => 1,
			'label'  => 'Lorem ipsum dolor '
		));
		$this->assertEqual($results, $expected);
	}
}
?>