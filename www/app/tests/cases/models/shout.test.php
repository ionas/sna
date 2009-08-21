<?php 
/* SVN FILE: $Id$ */
/* Shout Test cases generated on: 2009-08-21 20:08:13 : 1250879353*/
App::import('Model', 'Shout');

class ShoutTestCase extends CakeTestCase {
	var $Shout = null;
	var $fixtures = array('app.shout', 'app.profile', 'app.from_profile');

	function startTest() {
		$this->Shout =& ClassRegistry::init('Shout');
	}

	function testShoutInstance() {
		$this->assertTrue(is_a($this->Shout, 'Shout'));
	}

	function testShoutFind() {
		$this->Shout->recursive = -1;
		$results = $this->Shout->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Shout' => array(
			'id'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-08-21 20:29:12',
			'modified'  => '2009-08-21 20:29:12',
			'owner_id'  => 'Lorem ipsum dolor sit amet',
			'profile_id'  => 'Lorem ipsum dolor sit amet',
			'from_profile_id'  => 'Lorem ipsum dolor sit amet',
			'text'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>