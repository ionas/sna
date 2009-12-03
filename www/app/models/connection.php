<?php
class Connection extends AppModel {

	var $name = 'Connection';
	var $validate = array(
		'profile_id' => array('notempty'),
		'to_profile_id' => array('notempty'),
		'type' => array('notempty'),
		'is_request' => array('numeric'),
		'is_mutual' => array('numeric'),
		'is_hidden' => array('numeric'),
	);
	
	var $types = array(
		'all' => array(
			'ignore',
			'follow',
			'friend',
			'messaging_authentification',
			'shouting_authentification',
		),
		'mutual' => array(
			'friend',
		),
		'requestable' => array(
			'friend',
			'messaging_authentification',
			'shouting_authentification',
		),
	);

	var $belongsTo = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'profile_id',
		),
		'ToProfile' => array(
			'className' => 'Profile',
			'foreignKey' => 'to_profile_id',
		)
	);

}
?>