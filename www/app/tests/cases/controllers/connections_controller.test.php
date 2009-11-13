<?php 
/* SVN FILE: $Id$ */
/* ConnectionsController Test cases generated on: 2009-11-04 16:11:26 : 1257350126*/
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