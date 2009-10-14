<?php 
/* SVN FILE: $Id$ */
/* Shout Fixture generated on: 2009-10-05 18:10:40 : 1254758680*/

class ShoutFixture extends CakeTestFixture {
	var $name = 'Shout';
	var $table = 'shouts';
	var $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'profile_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'from_profile_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'is_deleted' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'is_hidden' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'is_deleted_by_shouter' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'body' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-10-05 18:04:40',
		'user_id'  => 'Lorem ipsum dolor sit amet',
		'profile_id'  => 'Lorem ipsum dolor sit amet',
		'from_profile_id'  => 'Lorem ipsum dolor sit amet',
		'is_deleted'  => 1,
		'is_hidden'  => 1,
		'is_deleted_by_shouter'  => 1,
		'body'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
	));
}
?>