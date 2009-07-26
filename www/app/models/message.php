<?php
class Message extends AppModel {
	
	var $name = 'Message';
	var $validate = array(
		'user_id' => array('notempty'),
		'form_user_id' => array('notempty'),
		'subject' => array('notempty'),
		'body' => array('notempty'),
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