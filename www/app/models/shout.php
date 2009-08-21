<?php
class Shout extends AppModel {
	
	var $name = 'Shout';
	
	var $validate = array(
		'user_id' => array('notempty'),
		'profile_id' => array('notempty'),
		'from_profile_id' => array('notempty'),
		'body' => array('notempty'),
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
	);

}
?>