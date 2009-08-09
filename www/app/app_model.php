<?php
class AppModel extends Model {
	
//	var $recursive = 0; // Default setting for all Model::find() calls, better use containable
	
	function validateEqualData($data, $message, $comparisonField) {
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
			if (preg_match("/^[12][0-9]{3}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01]) ([01][0-9]|[2][0-4]):([0-5][0-9]|[0-9]):([0-5][0-9]|[0-9])$/", $data[$fieldname])) {
				return true;
			}
		}
		return false;
	}
	
}
?>