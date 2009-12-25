<?php
class ExtSessionComponent extends SessionComponent {
	
	var $test = 'foo';
	
	function __read($key) {
		$this->log($key, 'debug');
	}
	
	/**
	 * Helper function called on write for database sessions.
	 *
	 * @param mixed $key The name of the var
	 * @param mixed $value The value of the var
	 * @return boolean Success
	 * @access private
	 */
	function __write($key, $value) {
		$this->log($key . ': ' . $value, 'debug');
		$db =& ConnectionManager::getDataSource(Configure::read('Session.database'));
		$table = $db->fullTableName(Configure::read('Session.table'));
	
		switch (Configure::read('Security.level')) {
			case 'high':
				$factor = 10;
			break;
			case 'medium':
				$factor = 100;
			break;
			case 'low':
				$factor = 300;
			break;
			default:
				$factor = 10;
			break;
		}
		$expires = time() +  Configure::read('Session.timeout') * $factor;
		$row = $db->query("SELECT COUNT(id) AS count FROM " . $db->name($table) . " WHERE "
								 . $db->name('id') . " = "
								 . $db->value($key), false);
	
		if ($row[0][0]['count'] > 0) {
			$db->execute("UPDATE " . $db->name($table) . " SET " . $db->name('data') . " = "
								. $db->value($value) . ", " . $db->name('expires') . " = "
								. $db->value($expires) . " WHERE " . $db->name('id') . " = "
								. $db->value($key));
		} else {
			$db->execute("INSERT INTO " . $db->name($table) . " (" . $db->name('data') . ","
							  	. $db->name('expires') . "," . $db->name('id')
							  	. ") VALUES (" . $db->value($value) . ", " . $db->value($expires) . ", "
							  	. $db->value($key) . ")");
		}
		return true;
	}
	
}
?>