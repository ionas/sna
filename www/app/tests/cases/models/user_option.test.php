<?php 
/* SVN FILE: $Id$ */
/* UserOption Test cases generated on: 2009-07-28 17:07:16 : 1248795796*/
App::import('Model', 'UserOption');

class UserOptionTestCase extends CakeTestCase {
	var $UserOption = null;
	var $fixtures = array('app.user_option', 'app.user');

	function startTest() {
		$this->UserOption =& ClassRegistry::init('UserOption');
	}

	function testUserOptionInstance() {
		$this->assertTrue(is_a($this->UserOption, 'UserOption'));
	}

	function testUserOptionFind() {
		$this->UserOption->recursive = -1;
		$results = $this->UserOption->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('UserOption' => array(
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