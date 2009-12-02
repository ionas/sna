<?php
class AppModel extends Model {
	
	var $recursive = -1; // Default setting for all Model::find() calls, better use containable
	
	/**
	* TODO: should be moved into a behavior
	* Usage: var $displayField = array("%s %s", "{n}.User.name", "{n}.User.secondname");
	* Based on: http://bakery.cakephp.org/articles/view/multiple-display-field-3#3875
	* by Arialdo Martini
	*/
	function find($conditions = null, $fields = array(), $order = null, $recursive = null) {
		if ($conditions == 'list' && is_array($this->displayField)) {
			$data = $this->find('all', $fields, $order, $recursive);
			$list = Set::combine($data, '{n}.' . $this->name . '.' . $this->primaryKey,
				$this->displayField);
			foreach ($list as &$element) {
				// TODO if $this->displayFieldDoTranslate == true
				$element = ucfirst($element);
			}
			return $list;
		} else {
			return parent::find($conditions, $fields, $order, $recursive);
		}
	}
	
	/**
	* TODO all validations should be moved into a behavior like "extendedValidationable"
	* including pause and unpause validation
	*/
	function validateEqualData($data, $comparisonField, $message = null) {
		if (is_array($data)) {
			foreach ($data as $value) {
				if (isset($this->data[$this->alias][$comparisonField])) {
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
			$re = "/^[12][0-9]{3}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01]) ([01][0-9]|[2][0-4]):"
				. "([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/";
			if (preg_match($re, $data[$fieldname])) {
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
	
	function validateUuid($data = null, $fieldname) {
		if (is_array($data)) {
			$re = "/[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}/";
			if (preg_match($re, $data[$fieldname])) {
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
	
	function unpauseValidation($fieldname, $rulename) {
		$this->pauseValidation($fieldname, $rulename, false);
	}
	
	// TODO: Should be moved into a MailBehavior
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
	
	// TODO: is this used anyway?
	// this is bad design
	function purge($id) {
		if (!isset($this->skipOnPurge)) {
			$this->skipOnPurge = array('id', 'created', 'modified');
		}
		if ($id != null) {
			$purgeData = array_diff(array_keys($this->_schema), $this->skipOnPurge);
			$purgeData = Set::normalize($purgeData);
			$purgeData[$this->alias] = array_fill_keys(array_keys($purgeData), null);
			$purgeData[$this->alias]['is_deleted'] = '1';
			$purgeData[$this->alias][$this->primaryKey] = $this->id;
			if ($this->save($purgeData, null, false) !== false) {
				return true;
			}
		}
		return false;
	}
	
	// TODO: move this into extendedDebuggable
	function validates($options = array()) {
		// Debug validation
		$errors = $this->invalidFields($options);
		if (is_array($errors) && !empty($errors)) {
			$this->log($errors, 'debug');
		}
		// Validate
		return parent::validates($options);
	}
	
	// TODO: Move to extendedOperationable
	// Saves a field, if the object exists
	function saveFieldIfExists($id = null, $fieldname, $value, $validate = false) {
		if ($this->find('count', array('conditions' => array($this->primaryKey => $id))) < 1) {
			return false;
		}
		$backupThisId = $this->id;
		$this->id = $id;
		$return = $this->saveField($fieldname, $value , $validate);
		$this->id = $backupThisId;
		return $return;
	}
	
	// TODO: Move to extendedOperationable
	// Gets a single field value, if the object exists
	// Todo add cache and cache clean, on save, saveFieldIfExists and saveField
	// if the row (or in case of saveField the row+field) is touched, unvalidate cache
	function getFieldIfExists($id = null, $fieldname) {
		$data = $this->find('first', array(
			'conditions' => array($this->primaryKey => $id),
			'fields' => array($fieldname)));
		if ($data == false) {
			return false;
		} else {
			return $data[$this->alias][$fieldname];
		}
	}
	
	
}
?>