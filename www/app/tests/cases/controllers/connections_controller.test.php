<?php 
/* SVN FILE: $Id$ */
/* ConnectionsController Test cases generated on: 2009-12-08 10:12:32 : 1260263732*/
App::import('Controller', 'Connections');

class TestConnections extends ConnectionsController {
	var $autoRender = false;
}

class ConnectionsControllerTest extends CakeTestCase {
	var $Connections = null;

	function setUp() {
		$this->Connections = new TestConnections();
		$this->Connections->constructClasses();
	}

	function testConnectionsControllerInstance() {
		$this->assertTrue(is_a($this->Connections, 'ConnectionsController'));
	}

	function tearDown() {
		unset($this->Connections);
	}
}
?>