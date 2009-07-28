<?php
class UserOption extends AppModel {

	var $name = 'UserOption';
	var $validate = array(
		'user_id' => array('notempty'),
		'key' => array('notempty'),
		'value' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function get($userId, $keys = null) {
		if(empty($keys)) {
			$mode = 'all';
			$find = 'all';
			$fields = array();
			$conditions = array();
		} else if(is_string($keys) or (is_array($keys) && count($keys) == 1)) {
			$mode = 'one';
			$find = 'first';
			$fields = array('UserOption.value');
			$conditions = array('UserOption.key' => $keys);
		} else if(is_array($keys)) {
			$mode = 'some';
			$find = 'all';
			$fields = array('UserOption.key', 'UserOption.value');
			$conditions = array('UserOption.key' => $keys);
		}
		$conditions = array_merge($conditions, array('UserOption.user_id' => $userId));
		$userOptions = $this->find($find, array(
				'fields' => $fields,
				'conditions' => $conditions,
			)
		);
		if($mode == 'one') {
			return $userOptions['UserOption']['value'];
		} else {
			return $userOptions;
		}
	}

}
?>