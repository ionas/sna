<?php

App::import('Component', 'Email');

class User extends AppModel {
	
	var $name = 'User';
	
	var $validate = array(
		'username' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This username is already in use.',
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Use letters from A to Z or numbers from 0 to 9 only.',
			),
			'minLength' => array(
				'rule' => array('minLength', '3'),
				'message' => 'Minimum length of 3 characters.',
			),
		),
		'password' => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Use letters from A to Z or numbers from 0 to 9 only.',
			),
			'minLength' => array(
				'rule' => array('minLength', '3'),
				'message' => 'Minimum length of 3 characters.',
			),
			'validateEqualData' => array(
				'rule' => array(
					'validateEqualData',
					'You may have misstyped your Password or your Password Confirmation is wrong.',
					'password_confirmation',
				),
				'message' => 'Your Password does not match with your Password Confirmation.',
			),
		),
		'nickname' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This nickname is already in use.',
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Nickname must only contain letters and numbers.',
			),
			'minLength' => array(
				'rule' => array('minLength', '3'),
				'message' => 'Minimum length of 3 characters.',
			),
		),
		'email' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This email address is already in use.',
			),
			'email' => array(
				'rule' => 'email',
				'message' => 'Must be a valid email address.',
			),
			'validateEqualData' => array(
				'rule' => array(
					'validateEqualData',
					'You may have misstyped your Email or your Email Confirmation is wrong.',
					'email_confirmation',
				),
				'message' => 'Your Email does not match with your Email Confirmation.',
			),
		),
		'has_accepted_tos' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'You may only accept or deny the Terms of Service.',
			),
			'validateTosOnCreate' => array(
				'rule' => array(
					'validateTosOnCreate',
				),
				'message' => 'You must accept the Terms of Service on User Account creation.',
			),
		),
	);
	
	var $displayField = 'nickname';
	
	var $hasMany = array(
		'UserOption' => array(
			'className' => 'UserOption',
			'foreignKey' => 'user_id',
			'dependent' => true,
		),
		'Message' => array(
			'className' => 'Message',
			'foreignKey' => 'user_id',
			'dependent' => true,
		),
		'Shout' => array(
			'className' => 'Shout',
			'foreignKey' => 'user_id',
			'dependent' => true,
		),
	);
	
	function validates() {
		return count($this->invalidFields()) == 0;
	}
	
	function validateTosOnCreate() {
		if ($this->id === false && $this->data['User']['has_accepted_tos'] == 0) {
			return false;
		}
		return true;
	}
	
	function validateEqualData($data, $message, $comparisonField) {
		if (is_array($data)) {
			foreach($data as $value) {
				if ($value !== $this->data[$this->alias][$comparisonField]) {
					$this->invalidate($comparisonField, $message);
					return false;
				}
			}
		}
		return true;
	}
	
	function beforeSave() {
		$this->hashPasswords(null, true);
		if ($this->id === false) { // on new records, clear out some fields, predefine some values
			$this->data['User']['is_hidden'] = 0;
			$this->data['User']['is_disabled'] = 0;
			$this->data['User']['is_deleted'] = 0;
			unset($this->data['User']['email_confirmation']);
			unset($this->data['User']['password_confirmation']);
		}
		return true;
	}
	
	function afterSave($isCreated) {
		if ($isCreated === true) {
			$this->deactivate($this->data);
		}
	}
	
	function hashPasswords($data, $enforce = false) {
		if ($enforce && isset($this->data[$this->alias]['password'])) {
			if (!empty($this->data[$this->alias]['password'])) {
				$this->data[$this->alias]['password'] =
					Security::hash($this->data[$this->alias]['password'], null, true);
			}
		}
		return $data;
	}
	
	function deactivate($data, $doSendEmail = true, $message = '') {
		$activationKey = Security::hash(time() . mt_rand(), 'sha256');
		$this->saveField('activation_key', $activationKey , true);
		// Sending the Email
		$Email = new EmailComponent();
		$serverName = $_SERVER['SERVER_NAME'];
		if (strpos($serverName, 'www.') === 0) {
			$serverName = substr($serverName, 4);
		}
		$Email->to = $data[$this->alias]['email']
		$Email->subject = 'User Account Activation';
		$Email->from = 'noreply@' . $serverName;
		$message = array($message, 'Activation Key: ' . $activationKey);
		if ($Email->send($message)) {
			$this->log('User account activation email send from ' . $EMail->from
				. ' send to: ' . $Email->to, LOG_DEBUG);
		} else {
			$this->log('User account activation email COULD NOT be send from ' . $EMail->from
				. ' send to: ' . $Email->to, LOG_DEBUG);
		}
		unset($Email);
	}
	
	function activate($doSendEmail) {
		// TODO
	}
	
}
?>