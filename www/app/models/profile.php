<?php
class Profile extends AppModel {
	
	var $name = 'Profile';
	
	var $actsAs = array('Containable', 'Avatarable');
	
	var $displayField = 'nickname';
	
	var $validate = array(
		'user_id' => array('notempty'),
		'is_hidden' => array('boolean'),
		'nickname' => array('notempty'),
	);
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'Gender' => array(
			'className' => 'Gender',
			'foreignKey' => 'gender_id',
		),
	);
	
	var $hasMany = array(
		'ConnectionA' => array(
			'className' => 'Connection',
			'foreignKey' => 'profile_id_a',
		),
		'ConnectionB' => array(
			'className' => 'Connection',
			'foreignKey' => 'profile_id_b',
		),
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