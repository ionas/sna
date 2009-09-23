<?php
class Option extends AppModel {

	var $name = 'Option';
	
	var $validate = array(
		'user_id' => array('notempty'),
		'key' => array('notempty'),
		'value' => array('notempty')
	);

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		)
	);
	
	function get($userData, $keys = null) {
		if (empty($keys)) {
			$mode = 'all';
			$find = 'all';
			$fields = array();
			$conditions = array();
		} else if (is_string($keys) or (is_array($keys) && count($keys) == 1)) {
			$mode = 'one';
			$find = 'first';
			$fields = array('Option.value');
			$conditions = array('Option.key' => $keys);
		} else if (is_array($keys)) {
			$mode = 'some';
			$find = 'all';
			$fields = array('Option.key', 'Option.value');
			$conditions = array('Option.key' => $keys);
		}
		$conditions = array_merge($conditions, array('Option.user_id' =>
			$userData['User']['id']));
		$Options = $this->find($find, array(
				'fields' => $fields,
				'conditions' => $conditions,
			)
		);
		if ($mode == 'one') {
			return $Options['Option']['value'];
		} else {
			return $Options;
		}
	}

}
?>