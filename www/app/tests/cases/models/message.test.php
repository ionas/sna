<?php 
/* SVN FILE: $Id$ */
/* Message Test cases generated on: 2009-08-21 20:08:45 : 1250879445*/
App::import('Model', 'Message');

class MessageTestCase extends CakeTestCase {
	var $Message = null;
	var $fixtures = array('app.message', 'app.profile', 'app.from_profile');

	function startTest() {
		$this->Message =& ClassRegistry::init('Message');
	}

	function testMessageInstance() {
		$this->assertTrue(is_a($this->Message, 'Message'));
	}

	function testMessageFind() {
		$this->Message->recursive = -1;
		$results = $this->Message->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Message' => array(
			'id'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-08-21 20:30:45',
			'modified'  => '2009-08-21 20:30:45',
			'owner_id'  => 'Lorem ipsum dolor sit amet',
			'profile_id'  => 'Lorem ipsum dolor sit amet',
			'from_profile_id'  => 'Lorem ipsum dolor sit amet',
			'subject'  => 'Lorem ipsum dolor sit amet',
			'body'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'is_read'  => 1,
			'is_replied'  => 1,
			'is_trashed'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>