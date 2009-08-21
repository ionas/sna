<?php 
/* SVN FILE: $Id$ */
/* Shout Fixture generated on: 2009-08-21 20:08:12 : 1250879352*/

class ShoutFixture extends CakeTestFixture {
	var $name = 'Shout';
	var $table = 'shouts';
	var $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'owner_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'profile_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'from_profile_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'text' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-08-21 20:29:12',
		'modified'  => '2009-08-21 20:29:12',
		'owner_id'  => 'Lorem ipsum dolor sit amet',
		'profile_id'  => 'Lorem ipsum dolor sit amet',
		'from_profile_id'  => 'Lorem ipsum dolor sit amet',
		'text'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
	));
}
?>