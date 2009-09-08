<?php
class AppModel extends Model {
	
	var $recursive = -1; // Default setting for all Model::find() calls, better use containable
	
	function validateEqualData($data, $comparisonField, $message = null) {
		if (is_array($data)) {
			foreach ($data as $value) {
				if(isset($this->data[$this->alias][$comparisonField])) {
					if ($value !== $this->data[$this->alias][$comparisonField]) {
						$this->invalidate($comparisonField, $message);
						return false;
					}
				}
			}
		}
		return true;
	}
	
	function validateDatetime($data = null, $fieldname) {
		if (is_array($data)) {
			if (preg_match("/^[12][0-9]{3}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01]) ([01][0-9]|[2][0-4]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/",
					$data[$fieldname])) {
				return true;
			}
		}
		return false;
	}
	
	function validateAuthKey($data = null, $fieldname) {
		if (is_array($data)) {
			// Matches AB42-KD24-D2JS-24M6 and alike
			if (preg_match("/^[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}$/",
					$data[$fieldname])) {
				return true;
			}
		}
		return false;
	}
	
	function pauseValidation($fieldname, $rulename, $switch = true) {
		if ($switch) {
			$this->pausedValidate[$fieldname][$rulename] = $this->validate[$fieldname][$rulename];
			unset($this->validate[$fieldname][$rulename]);
		} else {
			$this->validate[$fieldname][$rulename] = $this->pausedValidate[$fieldname][$rulename];
			unset($this->pausedValidate[$fieldname]);
		}
	}
	
	function unpauseValidation($fieldname, $rulename, $switch = true) {
		$this->pauseValidation($fieldname, $rulename, false);
	}
	
	// Wrapper around EMailComponent (and possibly SMSGatewayComponent in future)
	function _sendMessage($viewData, $template, $gateway) {
		if (isset($gateway['email'])) {
			App::import('Core', 'Controller');
			App::import('Component', 'Email');
			// We need this fake controller
			$Controller = new Controller();
			$Email = new EmailComponent(null);
			$Email->initialize($Controller);
			$Email->to = $gateway['email']['to'];
			$Email->subject = $gateway['email']['subject'];
			$Email->template = $template;
			$EMail->sendAs = 'both';
			$domainName = env('SERVER_NAME');
			if (strpos($domainName, 'www.') === 0) {
				$domainName = substr($domainName, 4);
			}
			$Email->from = 'noreply@' . $domainName;
			$Controller->set($viewData);
			$isSend = $Email->send();
			if ($isSend == false) {
				$this->log('Sending mail not successful.', 'error');
				$this->invalidate('could_not_send');
			}
			unset($Email);
			unset($Controller);
			return $isSend;
		}
		// ENH: SMS-Gateway
	}
	
	function purge($id) {
		if(!isset($this->skipOnPurge)) {
			$this->skipOnPurge = array('id', 'created', 'modified');
		}
		if ($id != null) {
			$purgeData = array_diff(array_keys($this->_schema), $this->skipOnPurge);
			$purgeData = Set::normalize($purgeData);
			$purgeData[$this->alias] = array_fill_keys(array_keys($purgeData), null);
			$purgeData[$this->alias]['is_deleted'] = '1';
			$purgeData[$this->alias][$this->primaryKey] = $this->id;
			if($this->save($purgeData, null, false) !== false) {
				return true;
			}
		}
		return false;
	}
	
	function validates($options = array()) {
		// Debug validation
		$errors = $this->invalidFields($options);
		if (is_array($errors) && !empty($errors)) {
			$this->log($errors, 'debug');
		}
		// Validate
		return parent::validates($options);
	}
	
}
?>