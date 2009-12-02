<?php
class Connection extends AppModel {

	var $name = 'Connection';
	var $validate = array(
		'profile_id' => array('notempty'),
		'to_profile_id' => array('notempty'),
		'type' => array('notempty'),
		'mutual' => array('numeric'),
		'hidden' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'profile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ToProfile' => array(
			'className' => 'Profile',
			'foreignKey' => 'to_profile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>