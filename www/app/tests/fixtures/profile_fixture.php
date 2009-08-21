<?php 
/* SVN FILE: $Id$ */
/* Profile Fixture generated on: 2009-08-21 20:08:21 : 1250879241*/

class ProfileFixture extends CakeTestFixture {
	var $name = 'Profile';
	var $table = 'profiles';
	var $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'unique'),
		'is_hidden' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'nickname' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'unique'),
		'birthday' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'location' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'UNIQUE_NICKNAME' => array('column' => 'nickname', 'unique' => 1), 'UNIQUE_PROFILE_PER_USER' => array('column' => 'user_id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-08-21 20:27:21',
		'modified'  => '2009-08-21 20:27:21',
		'user_id'  => 'Lorem ipsum dolor sit amet',
		'is_hidden'  => 1,
		'nickname'  => 'Lorem ipsum dolor ',
		'birthday'  => '2009-08-21 20:27:21',
		'location'  => 'Lorem ipsum dolor sit amet'
	));
}
?>