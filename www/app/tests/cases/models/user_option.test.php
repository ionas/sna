<?php 
/* SVN FILE: $Id$ */
/* Option Test cases generated on: 2009-07-28 17:07:16 : 1248795796*/
App::import('Model', 'Option');

class OptionTestCase extends CakeTestCase {
	var $Option = null;
	var $fixtures = array('app.user_option', 'app.user');

	function startTest() {
		$this->Option =& ClassRegistry::init('Option');
	}

	function testOptionInstance() {
		$this->assertTrue(is_a($this->Option, 'Option'));
	}

	function testOptionFind() {
		$this->Option->recursive = -1;
		$results = $this->Option->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Option' => array(
			'id'  => 1,
			'modified'  => '2009-07-28 17:43:15',
			'user_id'  => 'Lorem ipsum dolor sit amet',
			'key'  => 'Lorem ipsum dolor sit amet',
			'value'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>