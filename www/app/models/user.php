<?php

App::import('Component', 'Email');

class User extends AppModel {
	
	var $name = 'User';
	
	var $recursive = 0;
	
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
		)
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
			foreach ($data as $value) {
				if ($value !== $this->data[$this->alias][$comparisonField]) {
					$this->invalidate($comparisonField, $message);
					return false;
				}
			}
		}
		return true;
	}
	
	function beforeSave() {
		if ($this->id === false) { // on new records, clear out some fields, predefine some values
			$this->data[$this->alias]['is_hidden'] = 0;
			$this->data[$this->alias]['is_disabled'] = 0;
			$this->data[$this->alias]['is_deleted'] = 0;
			unset($this->data[$this->alias]['email_confirmation']);
			unset($this->data[$this->alias]['password_confirmation']);
			$this->sendCopyViaEmail = array($this->data['User']['send_copy_via_email'], $this->data[$this->alias]['password']);
		}
		$this->hashPasswords(null, true);
		return true;
	}
	
	function afterSave($isCreated) {
		if ($isCreated === true) {
			$activationKey = substr(strtoupper(String::uuid()), 4, -8);
			$this->deactivate($this->read(), $activationKey);
			$this->sendActivationEmail($this->read(), $activationKey);
		}
	}
	
	function hashPasswords($data, $enforce = false) {
		$this->log('Hashing password');
		if ($enforce && isset($this->data[$this->alias]['password'])) {
			if (!empty($this->data[$this->alias]['password'])) {
				$this->data[$this->alias]['password'] =
					Security::hash($this->data[$this->alias]['password'], null, true);
			}
		}
		return $data;
	}
	
	function deactivate($data, $activationKey) {
		$this->id = $data[$this->alias]['id'];
		$this->saveField('activation_key', $activationKey , true);
	}
	
	function sendActivationEmail($data, $activationKey) {
		// There should be a switch for Activation via Email OR SMS-Gateway!)
		$Email = new EmailComponent();
		$serverName = env('SERVER_NAME');
		if (strpos($serverName, 'www.') === 0) {
			$serverName = substr($serverName, 4);
		}
		$Email->to = $data[$this->alias]['email'];
		$Email->subject = $serverName . ': ' . $data[$this->alias]['username'] . '/'
			. $data[$this->alias]['nickname'] . ' - ' . __('User Account Activation', true);
		$Email->from = 'noreply@' . $serverName;
		$message = array(
			__('Please click on the Activation Link:', true),
			'<a href="http://' . env('SERVER_NAME') . '/users/activate/' . $activationKey,
			' ',
			__('If the Link does not work, copy and paste over this Activation Key', true) . ': ',
			$activationKey,
			__('in the Activation Key field on', true) . ': '
				. ' http://' . env('SERVER_NAME') . '/users/activate ',
		);
		if(is_array($this->sendCopyViaEmail) && $this->sendCopyViaEmail[0] == 1) {
			$message = array_merge($message, array(
					' ',
					__('User Account Details for', true) . ' [' . $data[$this->alias]['nickname'] . ']',
					__('Login name', true) . ':   ' . $data[$this->alias]['username'],
					__('Password', true) . ':     ' . $this->sendCopyViaEmail[1],
					__('EMail Address', true) . ': ' . $data[$this->alias]['email'],
				)
			);
		}
		if ($Email->send($message)) {
			$this->log('User account activation email send from ' . $Email->from
				. ' send to: ' . $Email->to);
		} else {
			$this->log('User account activation email COULD NOT be send from ' . $Email->from
				. ' send to: ' . $Email->to);
		}
		unset($Email);
	}
	
	function activate($data, $doSendEmail = true) {
		if (empty($data['User']['activation_key'])) {
			$this->invalidate('activation_key', __('Enter your Activation Key.', true));
			return false;
		}
		$data = $this->find('first', array(
				'fields' => array('User.id'),
				'conditions' => array('activation_key' => $data['User']['activation_key']),
				'recursive' => 0,
			)
		);
		if (!empty($data['User']['id'])) {
			$this->id = $data['User']['id'];
			if ($this->saveField('activation_key', '')) {
				// TODO doSendEmail
				return true;
			}
		} else {
			$this->invalidate('activation_key', __('The Activation Key you have entered is invalid.', true));
			return false;
		}
	}
	
	function setTos($data, $switch = 0) {
		$this->id = $data['User']['id'];
		$this->saveField('has_accepted_tos', $switch);
	}
	
}
?>