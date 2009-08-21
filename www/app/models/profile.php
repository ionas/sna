<?php
class Profile extends AppModel {
	
	var $name = 'Profile';
	
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
	
	function profileExists($userId) {
		$data = $this->find('first',
			array('fields' => 'id', 'conditions' => array('user_id' => $userId)));
		if($data === false) {
			return false;
		} else {
			return $data;
		}
	}
	
	function del($id = null, $cascade = true) {
		$this->skipOnPurge = array(
			'id', 'created', 'modified', 'user_id');
		return $this->purge($id);
	}
	
}
?>