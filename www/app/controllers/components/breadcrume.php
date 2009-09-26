<?php
class BreadcrumeComponent extends Object {
	
	var $settings = array(
		'max' => 20, // Max breadcrume history size
	);
	
	var $history = array();
	
	function initialize(&$Controller, $settings = array()) {
		$this->settings = array_merge($this->settings, $settings);
		$this->Controller = $Controller;
		$history = $Controller->Session->read('Breadcrume');
		if (is_array($history)) {
			$this->history = $history;
		}
	}
	
	function beforeRender(&$Controller) {
		if (!empty($Controller->here)) {
			$request = $Controller->here;
			$lastRequest = end($this->history);
			if ($request != $lastRequest[0]) {
				$this->history[] = array($request);
				if (count($this->history) >= $this->settings['max']) {
					$this->history = array_slice($this->history, 0, $this->settings['max']);
				}
				$Controller->Session->write('Breadcrume', $this->history);
			}
		}
	}
	
	function redirectBack($by = 1, $status = null, $exit = true) {
		if (!empty($this->history)) {
			if (count($this->history) > $by) {
				$by = ($by) * -1;
				$this->history = array_slice($this->history, $by, 1);
				$lastRequest = end($this->history);
			} else {
				$lastRequest = reset($this->history);
			}
			$this->Controller->redirect($lastRequest[0], $status, $exit);
		} else {
			return false;
		}
	}
	
}
?>
