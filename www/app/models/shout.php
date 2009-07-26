<?php
class Shout extends AppModel {

	var $name = 'Shout';
	var $validate = array(
		'user_id' => array('notempty')
	);
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'FormUser' => array(
			'className' => 'User',
			'foreignKey' => 'form_user_id',
		),
	);
	
}
?>