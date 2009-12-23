<?php
class Base extends AppModel {
	
	var $name = 'Base';
	var $useTable = false;
	
	/**
	* From controller context:
	* debug(ClassRegistry::init('Base')->dbTime());
	* 
	*/
	function dbTime() {
		$timeData = $this->query('SELECT NOW()');
		return $timeData[0][0]['NOW()'];
	}
	
}
?>