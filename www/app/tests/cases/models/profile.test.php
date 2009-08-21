<?php 
/* SVN FILE: $Id$ */
/* Profile Test cases generated on: 2009-08-21 20:08:21 : 1250879241*/
App::import('Model', 'Profile');

class ProfileTestCase extends CakeTestCase {
	var $Profile = null;
	var $fixtures = array('app.profile', 'app.user', 'app.message', 'app.shout');

	function startTest() {
		$this->Profile =& ClassRegistry::init('Profile');
	}

	function testProfileInstance() {
		$this->assertTrue(is_a($this->Profile, 'Profile'));
	}

	function testProfileFind() {
		$this->Profile->recursive = -1;
		$results = $this->Profile->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Profile' => array(
			'id'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-08-21 20:27:21',
			'modified'  => '2009-08-21 20:27:21',
			'user_id'  => 'Lorem ipsum dolor sit amet',
			'is_hidden'  => 1,
			'nickname'  => 'Lorem ipsum dolor ',
			'birthday'  => '2009-08-21 20:27:21',
			'location'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>