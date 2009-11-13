<?php 
/* SVN FILE: $Id$ */
/* Connection Test cases generated on: 2009-11-04 16:11:43 : 1257350083*/
App::import('Model', 'Connection');

class ConnectionTestCase extends CakeTestCase {
	var $Connection = null;
	var $fixtures = array('app.connection', 'app.profile', 'app.to_profile');

	function startTest() {
		$this->Connection =& ClassRegistry::init('Connection');
	}

	function testConnectionInstance() {
		$this->assertTrue(is_a($this->Connection, 'Connection'));
	}

	function testConnectionFind() {
		$this->Connection->recursive = -1;
		$results = $this->Connection->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Connection' => array(
			'id'  => 1,
			'created'  => '2009-11-04 16:54:43',
			'profile_id'  => 'Lorem ipsum dolor sit amet',
			'to_profile_id'  => 'Lorem ipsum dolor sit amet',
			'type'  => 'Lorem ipsum dolor sit amet',
			'value'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>