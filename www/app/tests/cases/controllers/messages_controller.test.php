<?php 
/* SVN FILE: $Id$ */
/* MessagesController Test cases generated on: 2009-07-26 13:07:19 : 1248609499*/
App::import('Controller', 'Messages');

class TestMessages extends MessagesController {
	var $autoRender = false;
}

class MessagesControllerTest extends CakeTestCase {
	var $Messages = null;

	function setUp() {
		$this->Messages = new TestMessages();
		$this->Messages->constructClasses();
	}

	function testMessagesControllerInstance() {
		$this->assertTrue(is_a($this->Messages, 'MessagesController'));
	}

	function tearDown() {
		unset($this->Messages);
	}
}
?>