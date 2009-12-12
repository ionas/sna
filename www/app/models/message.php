<?php
class Message extends AppModel {
	
	var $name = 'Message';
	
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
		'ToProfile' => array(
			'className' => 'Profile',
			'foreignKey' => 'to_profile_id',
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
			'to_profile_id' => array(
				'notempty' => array(
					'rule' => 'notempty',
					'message' => __('The message subject is required.', true),
				),
				'validateUuid' => array(
					'rule' => array('validateUuid', 'to_profile_id'),
					'message' => __('Must be a valid UUID.', true),
				),
			),
			'subject' => array(
				'notempty' => array(
					'rule' => 'notempty',
					'message' => __('The message subject is required.', true),
				),
				'maxLength' => array(
					'rule' => array('maxLength', '100'),
					'message' => __('Maximum length of 100 characters.', true),
				),
			),
			'body' => array(
				'notempty' => array(
					'rule' => 'notempty',
					'message' => __('The message body is required.', true),
				),
				'maxLength' => array(
					'rule' => array('maxLength', '5000'),
					'message' => __('Maximum length of 5000 characters.', true),
				),
			),
			'is_read' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __('Is Read? must be boolean', true),
				),
			),
			'is_replied' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __('Is Replied? must be boolean', true),
				),
			),
			'is_trashed' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __('Is Trashed? must be boolean', true),
				),
			),
		);
	}
	
	function send($fromProfileId, $toProfileId) {
		return $this->_send($fromProfileId, $toProfileId, 'send');
	}
	
	function reply($fromProfileId, $toProfileId) {
		return $this->_send($fromProfileId, $toProfileId, 'reply');
	}
	
	function _send($fromProfileId, $toProfileId, $type) { // type can be send or reply
		// data[0] is what is saved at the sender, data[1] what the receiver gets.
		$data[0] = $this->data;
		$fromProfileData = $this->Profile->find('first', array(
				'fields' => array('user_id'),
				'conditions' => array('Profile.id' => $fromProfileId)));
		$data[0]['Message']['user_id'] = $fromProfileData['Profile']['user_id'];
		$data[0]['Message']['profile_id'] = $fromProfileId;
		$data[0]['Message']['from_profile_id'] = $fromProfileId;
		$data[0]['Message']['to_profile_id'] = $toProfileId;
		$data[1] = $data[0];
		// TODO: Check if the receiving user and profile are alive
		if ($toProfileData = $this->Profile->find('first', array(
				'fields' => array('user_id', 'is_hidden'),
				'conditions' => array('Profile.id' => $toProfileId)))) {
			if (!$toUserData = $this->Profile->User->find('first', array(
					'fields' => array('is_deleted', 'is_disabled'),
					'conditions' => array('User.id' => $toProfileData['Profile']['user_id'])))) {
				return false;
			}
			if ($type == 'send' and $toProfileData['Profile']['is_hidden'] == 1) {
				// Cannot send new messages to hidden Profiles
				return false;
			}
			if ($toUserData['User']['is_deleted'] == 1 or $toUserData['User']['is_disabled'] == 1) {
				// Cannot send to profiles of users who ware deleted or deactivated
				return false;
			}
		}
		$data[1]['Message']['user_id'] = $toProfileData['Profile']['user_id'];
		$data[1]['Message']['profile_id'] = $toProfileId;
		// Validate all, transaction save (for instance on InnoDB)
		if ($this->saveAll($data, array(
				'validate' => 'first',
				'atomic' => true,
				'fieldList' => array('user_id', 'profile_id', 'from_profile_id', 'to_profile_id',
					'subject', 'body')))) {
			return true;
		}
		$this->validates($data);
		/* HACKFIX:
		* Required because of a bug in either app or cake
		* Reason: Validation of saveAll kicks in, BUT it does not trigger front end errors
		*/
		return false;
	}
	
}
?>