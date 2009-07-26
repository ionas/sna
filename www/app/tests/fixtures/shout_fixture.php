<?php 
/* SVN FILE: $Id$ */
/* Shout Fixture generated on: 2009-07-26 16:07:10 : 1248619150*/

class ShoutFixture extends CakeTestFixture {
	var $name = 'Shout';
	var $table = 'shouts';
	var $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'from_user_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'text' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'indexes' => array()
	);
	var $records = array(array(
		'id'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-07-26 16:39:10',
		'modified'  => '2009-07-26 16:39:10',
		'user_id'  => 'Lorem ipsum dolor sit amet',
		'from_user_id'  => 'Lorem ipsum dolor sit amet',
		'text'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
	));
}
?>