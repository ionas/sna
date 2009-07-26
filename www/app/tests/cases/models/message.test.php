<?php 
/* SVN FILE: $Id$ */
/* Message Test cases generated on: 2009-07-26 13:07:58 : 1248609418*/
App::import('Model', 'Message');

class MessageTestCase extends CakeTestCase {
	var $Message = null;
	var $fixtures = array('app.message', 'app.user', 'app.form_user');

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
			'user_id'  => 'Lorem ipsum dolor sit amet',
			'form_user_id'  => 'Lorem ipsum dolor sit amet',
			'subject'  => 'Lorem ipsum dolor sit amet',
			'body'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>