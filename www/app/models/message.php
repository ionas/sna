<?php
class Message extends AppModel {

	var $name = 'Message';
	var $validate = array(
		'user_id' => array('notempty'),
		'form_user_id' => array('notempty'),
		'subject' => array('notempty'),
		'body' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'FormUser' => array(
			'className' => 'User',
			'foreignKey' => 'form_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>