<?php 
/* SVN FILE: $Id$ */
/* Shout Test cases generated on: 2009-07-26 16:07:11 : 1248619151*/
App::import('Model', 'Shout');

class ShoutTestCase extends CakeTestCase {
	var $Shout = null;
	var $fixtures = array('app.shout', 'app.user', 'app.from_user');

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
			'created'  => '2009-07-26 16:39:10',
			'modified'  => '2009-07-26 16:39:10',
			'user_id'  => 'Lorem ipsum dolor sit amet',
			'from_user_id'  => 'Lorem ipsum dolor sit amet',
			'text'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>