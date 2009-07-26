<?php
class User extends AppModel {
	
	var $name = 'User';
	var $validate = array(
		'username' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This nickname is already in use.',
			),
			'minLength' => array(
				'rule' => array('minLength', '8'),
				'message' => 'Minimum length of 8 characters.',
			),
		),
		'password' => array(
			'minLength' => array(
				'rule' => array('minLength', '5'),
				'message' => 'Minimum length of 5 characters.',
			),
		),
		'nickname' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This nickname is already in use.',
			),
			'minLength' => array(
				'rule' => array('minLength', '8'),
				'message' => 'Minimum length of 8 characters.',
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Nickname must only contain letters and numbers.',
			),
		),
	);
	
	var $displayField = 'nickname';
	
	var $hasMany = array(
		'Message' => array(
			'className' => 'Message',
			'foreignKey' => 'user_id',
			'dependent' => true,
		),
		'Shout' => array(
			'className' => 'Shout',
			'foreignKey' => 'user_id',
			'dependent' => true,
		)
	);
	
}
?>