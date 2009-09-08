<?php
class Message extends AppModel {
	
	var $name = 'Message';
	
	var $actsAs = array('Containable');
	
	var $validate = array(
		'user_id' => array('notempty'),
		'profile_id' => array('notempty'),
		'from_profile_id' => array('notempty'),
		'to_profile_id' => array('notempty'),
		'subject' => array('notempty'),
		'body' => array('notempty'),
		'is_read' => array('numeric'),
		'is_replied' => array('numeric'),
		'is_trashed' => array('numeric'),
	);
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'profile_id',
		),
		'FromProfile' => array(
			'className' => 'Profile',
			'foreignKey' => 'from_profile_id',
		),
		'ToProfile' => array(
			'className' => 'Profile',
			'foreignKey' => 'to_profile_id',
		),
		'ParentMessage' => array(
			'className' => 'Message',
			'foreignKey' => 'parent_message_id',
		),
	);
	
	var $hasMany = array(
		'ChildMessages' => array(
			'className' => 'Message',
			'foreignKey' => 'parent_message_id',
			'dependent' => true,
		),
	);
	
}
?>