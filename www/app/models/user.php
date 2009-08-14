<?php

class User extends AppModel {
	
	var $name = 'User';
	
	var $validate = array(); // See function __construct()
	
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
	
	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct();
		$this->validate = array( 
'username' => array(
	'isUnique' => array(
		'rule' => 'isUnique',
		'message' => __('This username is already in use.', true),
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
'password' => array(
	'alphaNumeric' => array(
		'rule' => 'alphaNumeric',
		'message' => __('Use letters from A to Z or numbers from 0 to 9 only.', true),
	),
	'minLength' => array(
		'rule' => array('minLength', '3'),
		'message' => __('Minimum length of 3 characters.', true),
	),
	'validateEqualData' => array(
		'rule' => array(
			'validateEqualData',
			'password_confirmation',
			__('You may have misstyped your Password or your Password Confirmation is wrong.', true),
		),
		'message' => __('Your Password does not match with your Password Confirmation.', true),
	),
),
'nickname' => array(
	'isUnique' => array(
		'rule' => 'isUnique',
		'message' => __('This nickname is already in use.', true),
	),
	'alphaNumeric' => array(
		'rule' => 'alphaNumeric',
		'message' => __('Nickname must only contain letters and numbers.', true),
	),
	'minLength' => array(
		'rule' => array('minLength', '3'),
		'message' => __('Minimum length of 3 characters.', true),
	),
),
'email' => array(
	'isUnique' => array(
		'rule' => 'isUnique',
		'message' => __('This email address is already in use.', true),
	),
	'email' => array(
		'rule' => 'email',
		'message' => __('Must be a valid email address.', true),
	),
	'validateEqualData' => array(
		'rule' => array(
			'validateEqualData',
			'email_confirmation',
			__('You may have misstyped your Email or your Email Confirmation is wrong.', true),
		),
		'message' => __('Your Email does not match with your Email Confirmation.', true),
	),
),
'has_accepted_tos' => array(
	'boolean' => array(
		'rule' => array('boolean'),
		'message' => __('You may only accept or deny the Terms of Service.', true),
	),
	'equalTo' => array(
		'rule' => array('equalTo', '1'),
		'on' => 'create',
		'message' => __('You must accept the Terms of Service on User Account registration.', true),
	),
),
'last_login' => array(
	'validateDatetime' => array(
		'rule' => array('validateDatetime', 'last_login'),
		'message' => __('Last Login must be a valid datetime (yyyy-mm-dd hh:mm:ss).', true),
	),
),
'activation_key' => array(
	'minLength' => array(
		'rule' => array('minLength', '3'),
		'message' => __('Minimum length of 3 characters.', true),
	),
),
'password_request_key' => array(
	'minLength' => array(
		'rule' => array('minLength', '3'),
		'message' => __('Minimum length of 3 characters.', true),
	),
),
		);
		$this->passwordInClearText = null;
	}
	
	function afterFind(&$results) {
		// Create virtual field nicename out of username and nickname
		foreach ($results as $i => $data) {
			if (!empty($results[$i][$this->alias]['nickname'])) {
				$results[$i][$this->alias]['nicename'] = $results[$i][$this->alias]['nickname'];
			}
			if (!empty($results[$i][$this->alias]['nickname'])
			&& !empty($results[$i][$this->alias]['username'])) {
				if ($results[$i][$this->alias]['nickname'] != $results[$i][$this->alias]['username']) {
					$results[$i][$this->alias]['nicename'] .= ':' . $results[$i][$this->alias]['username'];
				}
			}
		}
		return $results;
	}
	
	function beforeValidate() {
		// Be nice to the user:
		// Starting and trailing whitespaces are ignored and removed before validation and/or save
		if (!empty($this->data[$this->alias]['email'])) {
			$this->data[$this->alias]['email'] = trim($this->data[$this->alias]['email']);
		}
		if (!empty($this->data[$this->alias]['email_confirmation'])) {
			$this->data[$this->alias]['email_confirmation'] =
				trim($this->data[$this->alias]['email_confirmation']);
		}
		if (!empty($this->data[$this->alias]['username'])) {
			$this->data[$this->alias]['username'] = trim($this->data[$this->alias]['username']);
		}
		if (!empty($this->data[$this->alias]['nickname'])) {
			$this->data[$this->alias]['nickname'] = trim($this->data[$this->alias]['nickname']);
		}
	}
	
	function beforeSave() {
		if ($this->id === false) { // on new records, clear out some fields, predefine some values
			$this->data[$this->alias]['is_hidden'] = 0;
			$this->data[$this->alias]['is_disabled'] = 0;
			$this->data[$this->alias]['is_deleted'] = 0;
			unset($this->data[$this->alias]['email_confirmation']);
			unset($this->data[$this->alias]['password_confirmation']);
			if (isset($this->data[$this->alias]['send_copy_via_email'])
			&& $this->data[$this->alias]['send_copy_via_email'] == 1) {
				$this->passwordInClearText = $this->data[$this->alias]['password'];
			}
		}
		$this->hashPasswords(null, true);
		return true;
	}
	
	function afterSave($isCreated) {
		if ($isCreated === true) {
			$this->deactivate($this->passwordInClearText);
			$this->passwordInClearText = null;
			$this->updateLastLogin($this->read());
		}
	}
	
	function hashPasswords($data, $enforce = false) {
		// $this->log('User::hashPasswords()', 'debug');
		if ($enforce && isset($this->data[$this->alias]['password'])) {
			if (!empty($this->data[$this->alias]['password'])) {
				$this->data[$this->alias]['password'] =
					Security::hash($this->data[$this->alias]['password'], null, true);
			}
		}
		return $data;
	}
	
	function deactivate($passwordInClearText, $isNewUser = true) {
		$activationKey = $this->_generateAuthKey('activation_key');
		$data = $this->read();
		if ($activationKey === false) {
			$this->log('No valid Activation Key. Disabling User.', 'error');
			$this->setDisabled($data, 1);
		} else {
			$this->id = $data[$this->alias]['id'];
			$this->saveField('activation_key', $activationKey , true);
			$this->sendActivation($data, $activationKey, $isNewUser, $passwordInClearText);
		}
	}
	
	function activate($data, $doSendEmail = true) {
		// TODO: treat $doSendEmail
		if (empty($data[$this->alias]['activation_key'])) {
			$this->invalidate('activation_key', __('Enter your Activation Key.', true));
			return false;
		}
		$data[$this->alias]['activation_key'] = strtoupper($data[$this->alias]['activation_key']);
		$data = $this->find('first', array(
				'fields' => array('id'),
				'conditions' => array('activation_key' => $data[$this->alias]['activation_key']),
				'recursive' => 0,
			)
		);
		if (!empty($data[$this->alias]['id'])) {
			$this->id = $data[$this->alias]['id'];
			if ($this->saveField('activation_key', null)) {
				return true;
			}
		} else {
			$this->invalidate('activation_key',
				__('The Activation Key you have entered is invalid.', true));
			return false;
		}
	}
	
	function setTos($data, $switch = 0) {
		$this->id = $data[$this->alias]['id'];
		if ($this->saveField('has_accepted_tos', $switch, true)) {
			return true;
		} else {
			return false;
		}
	}
	
	function setDisabled($data, $switch) {
		$this->id = $data[$this->alias]['id'];
		if ($this->saveField('is_disabled', $switch, true)) {
			return true;
		} else {
			return false;
		}
	}
	
	function updateLastLogin($data) {
		$this->id = $data[$this->alias]['id'];
		if ($this->saveField('last_login', date('Y-m-d H:i:s'), true)) {
			return true;
		} else {
			$this->log('Could not update last_login on user ' . $this->id . true);
			return false;
		}
	}
	
	function saveNewPassword($data) {
		$data = $this->find('first', array(
				'fields' => array($this->primaryKey),
				'conditions' => array(
					'username' => $data[$this->alias]['username'],
					'password_request_key' =>
						strtoupper($data[$this->alias]['password_request_key']))));
		$this->id = $data[$this->alias][$this->primaryKey];
		if($this->id == null) {
			$this->invalidate('password_request_key', __('Passwort request keys invalid.', true));
		} else if($this->validates(array('username', 'password'))) {
			if($this->changePassword()) {
				$this->saveField('password_request_key', null);
				return true;
			}
		} else {
			return false;
		}
	}
	
	function changePassword() {
		$isSaved = $this->save(null, true, array('password'));
		if ($isSaved) {
			return true;
		} else {
			return false;
		}
	}
	
	function del($id = null, $cascade = true) {
		$fields = array_keys($this->_schema);
		$keepFields = array('id', 'created', 'modified');
		if ($id != null) {
			$purgeData = array_diff($fields, $keepFields);
			$purgeData = Set::normalize($purgeData);
			$purgeData = array_fill_keys(array_keys($purgeData), null);
			$purgeData['is_deleted'] = '1';
			$this->id = $id;
			// $this->save($purgeData, null, false);
		}
		return true;
	}
	
	function sendActivation($data, $activationKey, $isNewUser, $passwordInClearText) {
		$domainname = env('SERVER_NAME');
		if (strpos($domainname, 'www.') === 0) {
			$domainname = substr($domainname, 4);
		}
		$gateway['email']['to'] = $data[$this->alias]['email'];
		$gateway['email']['subject'] = $domainname . ': ' . $data[$this->alias]['username'] . '/' 
			. $data[$this->alias]['nickname'] . ' - ' . __('Activation', true);
		$viewData = array(
			'domainName' => $domainname,
			'serverName' => env('SERVER_NAME'),
			'title' => $gateway['email']['subject'],
			'activationKey' => $activationKey,
		);
		if ($isNewUser) {
			$template = 'registration';
			$gateway['email']['subject'] .= ' - ' . __('User Account Activation', true);
				
		} else {
			$template = 'activation';
			$gateway['email']['subject'] .= ' - ' . __('User Account Reactivation', true);
		}
		if ($passwordInClearText) {
			$template .= '_details';
			$gateway['email']['subject'] .= ' ' . __('including User Account Details', true);
			$viewData = array_merge($viewData, array(
					'nickname' => $data[$this->alias]['nickname'],
					'username' => $data[$this->alias]['username'],
					'password' => $passwordInClearText,
					'email' => $data[$this->alias]['email'],
				)
			);
		}
		return $this->_sendMessage($viewData, $template, $gateway);
	}
	
	function sendPasswordInstructions($data) {
		$this->data = $data;
		$doSendPasswordInstructionEMail = false;
		$this->pauseValidation('username', 'isUnique');
		$this->pauseValidation('email', 'isUnique');
		if ($this->validates(array('fieldList' => array('username', 'email')))) {
			$userData = $this->find('first', array('conditions' => array(
						'username' => $data[$this->alias]['username'],
						'email' => $data[$this->alias]['email'])));
			if ($userData != false) {
				$forgotPasswordKey = $this->_generateAuthKey('password_request_key');
				if ($forgotPasswordKey === false) {
					$this->log('No valid Forgot Password Key.', 'error');
				} else {
					$this->id = $userData[$this->alias]['id'];
					$this->saveField('password_request_key', $forgotPasswordKey , true);
					$doSendPasswordInstructionEMail = true;
				}
			} else {
				$this->invalidate('forgot_password',
					__('No User Account having that Login name and Email address found.', true));
			}
		}
		$isSend = false;
		if ($doSendPasswordInstructionEMail) {
			$domainname = env('SERVER_NAME');
			if (strpos($domainname, 'www.') === 0) {
				$domainname = substr($domainname, 4);
			}
			$gateway['email']['to'] = $userData[$this->alias]['email'];
			$gateway['email']['subject'] = $domainname . ': '
				. $userData[$this->alias]['username'] . '/' 
				. $userData[$this->alias]['nickname'] . ' - ' . __('Password Request', true);
			$viewData = array(
				'domainName' => $domainname,
				'serverName' => env('SERVER_NAME'),
				'title' => $gateway['email']['subject'],
				'forgotPasswordKey' => $forgotPasswordKey,
			);
			$template = 'forgot_password';
			$isSend = $this->_sendMessage($viewData, $template, $gateway);
		}
		$this->unpauseValidation('username', 'isUnique');
		$this->unpauseValidation('email', 'isUnique');
		return $isSend;
	}
	
	function _generateAuthKey($fieldname, $i = 0) {
		$i++; if ($i > 10) { // Defensive loop stopper.
			$this->log('Issue with User::_generateAuthKey(). Failed at generating a valid key.',
				'error');
			return false;
		} else {
			// Key looks like D7E9-F3E4-479A-838C.
			$authKey = substr(strtoupper(String::uuid()), 4, -13);
			if ($this->find('first', 
					array('conditions' => array($fieldname => $authKey))) !== false) {
				$authKey = $this->_generateAuthKey($i);
			} else {
				return $authKey;
			}
		}
	}
	
	function validates($options = array()) {
		$errors = $this->invalidFields($options);
		if (is_array($errors)) {
			$this->log($errors, 'debug');
			return count($errors) === 0;
		}
		return $errors;
	}
	
}
?>