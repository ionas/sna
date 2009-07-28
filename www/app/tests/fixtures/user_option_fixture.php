<?php 
/* SVN FILE: $Id$ */
/* UserOption Fixture generated on: 2009-07-28 17:07:15 : 1248795795*/

class UserOptionFixture extends CakeTestFixture {
	var $name = 'UserOption';
	var $table = 'user_options';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index'),
		'key' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'value' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 1000),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'UNIQUE_KEY_PER_USER' => array('column' => array('user_id', 'key'), 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'modified'  => '2009-07-28 17:43:15',
		'user_id'  => 'Lorem ipsum dolor sit amet',
		'key'  => 'Lorem ipsum dolor sit amet',
		'value'  => 'Lorem ipsum dolor sit amet'
	));
}
?>