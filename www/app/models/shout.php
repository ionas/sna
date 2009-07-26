<?php
class Shout extends AppModel {
	
	var $name = 'Shout';
	var $validate = array(
		'user_id' => array('notempty'),
		'from_user_id' => array('notempty'),
		'text' => array('notempty'),
	);
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'FromUser' => array(
			'className' => 'User',
			'foreignKey' => 'from_user_id',
		),
	);
	
}
?>