<?php
class Profile extends AppModel {
	
	var $name = 'Profile';
	
	var $actsAs = array('Containable', 'Avatarable');
	
	var $displayField = 'nickname';
	
	var $validate = array(
		'user_id' => array('notempty'),
		'is_hidden' => array('numeric'),
		'nickname' => array('notempty'),
	);
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
	);
	
	var $hasMany = array(
		'Message' => array(
			'className' => 'Message',
			'foreignKey' => 'profile_id',
			'dependent' => true,
		),
		'Shout' => array(
			'className' => 'Shout',
			'foreignKey' => 'profile_id',
			'dependent' => true,
		),
	);
	
	function getAuthedId($authInfo = null) {
		$data = $this->find('first', array(
			'fields' => array('id'),
			'conditions' => array('user_id' => $authInfo['User']['id'])));
		if (empty($data)) {
			return false;
		} else {
			return $data['Profile']['id'];
			
		}
	}
	
}
?>