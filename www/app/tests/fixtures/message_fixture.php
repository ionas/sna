<?php 
/* SVN FILE: $Id$ */
/* Message Fixture generated on: 2009-07-26 13:07:58 : 1248609418*/

class MessageFixture extends CakeTestFixture {
	var $name = 'Message';
	var $table = 'messages';
	var $fields = array(
		'id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'form_user_id' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'subject' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'body' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'indexes' => array()
	);
	var $records = array(array(
		'id'  => 'Lorem ipsum dolor sit amet',
		'user_id'  => 'Lorem ipsum dolor sit amet',
		'form_user_id'  => 'Lorem ipsum dolor sit amet',
		'subject'  => 'Lorem ipsum dolor sit amet',
		'body'  => 'Lorem ipsum dolor sit amet'
	));
}
?>