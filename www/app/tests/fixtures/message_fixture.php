<?php 
/* SVN FILE: $Id$ */
/* Message Fixture generated on: 2009-08-21 20:08:45 : 1250879445*/

class MessageFixture extends CakeTestFixture {
	var $name = 'Message';
	var $table = 'messages';
	var $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'owner_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'profile_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'from_profile_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'subject' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'body' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'is_read' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'is_replied' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'is_trashed' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
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
}
?>