<?php
class Profile extends AppModel {
	
	var $name = 'Profile';
	
	// TODO: switch/change Avatarable to Gravatar
	var $actsAs = array('Containable', 'Avatarable');
	
	var $displayField = 'nickname';
	
	var $validate = array();
	
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
		'Connection' => array(
			'className' => 'Connection',
			'foreignKey' => 'profile_id',
		),
		'ToConnection' => array(
			'className' => 'Connection',
			'foreignKey' => 'to_profile',
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
	
	var $_authedId = null; // Holds the profile id authed user's current profile
	
	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct();
		$this->validate = array(
			'user_id' => array(
				'isUnique' => array(
					'rule' => 'isUnique',
					'required' => true,
					'message' => ___('This nickname is already in use.'),
				),
			),
			'nickname' => array(
				'isUnique' => array(
					'rule' => 'isUnique',
					'required' => true,
					'message' => __('This nickname is already in use.', true),
				),
				'alphaNumeric' => array(
					'rule' => 'alphaNumeric',
					'message' => __('Use letters from A to Z or numbers from 0 to 9 only.', true),
				),
				'minLength' => array(
					'rule' => array('minLength', '3'),
					'message' => __('Minimum length of 3 characters.', true),
				),
			),
			'location' => array(
				'minLength' => array(
					'rule' => array('minLength', '2'),
					'message' => __('Minimum length of 2 characters.', true),
					'allowEmpty' => true,
				),
			),
			'is_hidden' => array('boolean'),
			'is_required_messaging_authentification' => array('boolean'),
			'is_required_shouting_authentification' => array('boolean'),
		);
	}
	
	function getAuthedId($authInfo = array()) {
		if ($this->_authedId == null) {
			$data = $this->find('first', array(
				'fields' => array('id'),
				'conditions' => array('user_id' => $authInfo['User']['id'])));
			if (empty($data)) {
				return false;
			} else {
				$this->_authedId = $data['Profile']['id'];
			}
		}
		return $this->_authedId;
	}
	
}
?>