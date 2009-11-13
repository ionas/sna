<?php 
/* SVN FILE: $Id$ */
/* Connection Fixture generated on: 2009-11-04 16:11:43 : 1257350083*/

class ConnectionFixture extends CakeTestFixture {
	var $name = 'Connection';
	var $table = 'connections';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'profile_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'to_profile_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'type' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'value' => array('type'=>'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'created'  => '2009-11-04 16:54:43',
		'profile_id'  => 'Lorem ipsum dolor sit amet',
		'to_profile_id'  => 'Lorem ipsum dolor sit amet',
		'type'  => 'Lorem ipsum dolor sit amet',
		'value'  => 1
	));
}
?>