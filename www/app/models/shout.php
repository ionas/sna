<?php
class Shout extends AppModel {
	
	var $name = 'Shout';
	
	var $actsAs = array('Containable');
	
	var $validate = array();
	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'profile_id',
		),
		'FromProfile' => array(
			'className' => 'Profile',
			'foreignKey' => 'from_profile_id',
		),
	);
	
	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct();
		$this->validate = array(
			'user_id' => array(
				'notempty' => array(
					'rule' => 'notempty',
					'message' => __('User id is required.', true),
				),
				'validateUuid' => array(
					'rule' => array('validateUuid', 'user_id'),
					'message' => __('Must be a valid UUID.', true),
				),
			),
			'profile_id' => array(
				'notempty' => array(
					'rule' => 'notempty',
					'message' => __('Profile id is required.', true),
				),
				'validateUuid' => array(
					'rule' => array('validateUuid', 'profile_id'),
					'message' => __('Must be a valid UUID.', true),
				),
			),
			'from_profile_id' => array(
				'notempty' => array(
					'rule' => 'notempty',
					'message' => __('The message subject is required.', true),
				),
				'validateUuid' => array(
					'rule' => array('validateUuid', 'from_profile_id'),
					'message' => __('Must be a valid UUID.', true),
				),
			),
			'is_deleted' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __('Is Read? must be boolean', true),
				),
			),
			'is_hidden' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __('Is Read? must be boolean', true),
				),
			),
			'is_deleted_by_shouter' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __('Is Read? must be boolean', true),
				),
			),
			'body' => array(
				'notempty' => array(
					'rule' => 'notempty',
					'message' => __('The shout message is required.', true),
				),
				'maxLength' => array(
					'rule' => array('maxLength', '1000'),
					'message' => __('Maximum length of 1000 characters.', true),
				),
			),
		);
	}
	
	function save($data = null, $validate = true, $fieldList = array()) {
		// You may shout to yourself:
		if ($this->data['Shout']['from_profile_id'] != $this->data['Shout']['profile_id']) {
			// But for others you probably need authentification, so check it:
			if ($this->auth($this->data['Shout']['from_profile_id'],
				$this->data['Shout']['profile_id']) === false
			) {
				return false;
			}
		}
		// Everything fine it seems, save it
		return parent::save($data, $validate, $fieldList);
	}
	
	function auth($fromProfileId, $toProfileId) {
		return ClassRegistry::init('Connection')->check(
			'shouting_authentification', $fromProfileId, $toProfileId);
	}
	
}
?>