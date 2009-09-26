<?php
	function redirect($url, $status = null, $exit = true, $doStacking = true) {
		$redirectHistorySize = 20;
		if ($doStacking) {
			$RedirectHistory = $this->Session->read('RedirectHistory');
			if (empty($RedirectHistory)) {
				$RedirectHistory[] =  array('url' => Router::parse('/'), 'status' => null,
					'exit' => true);
			}
			// Cut any redirect call that is already in
			if (($backToIndex = array_search($url, $RedirectHistory)) !== false) {
				$RedirectHistory = array_slice($RedirectHistory, 0, $backToIndex - 1);
			} else { // Append new value
				if(!is_array($url)) {
					$url = Router::parse($url);
				}
				$RedirectHistory[] =  array('url' => $url, 'status' => $status, 'exit' => $exit);
			}
			// Set maximum redirect information to save in the session
			if(count($RedirectHistory) > $redirectHistorySize) {
				$RedirectHistory = array_slice($RedirectHistory, $redirectHistorySize*(-1), 
					$redirectHistorySize);
			}
			$this->log($RedirectHistory, 'debug');
			$this->Session->write('RedirectHistory', $RedirectHistory);
		}
//		return parent::redirect($url, $status = null, $exit = true);
	}
	
	function _redirectBack($to = 1) {
		$url = null;
		$status = null;
		$exit = true;
		// read Session
		$redirectHistory = $this->Session->read('RedirectHistory');
		if (is_int($to)) { // Move back by $target steps
			debug($redirectHistory);
			$redirect = array_slice($redirectHistory, $to*(-1), 0);
			debug($redirect);
			die();
			extract($redirect[0]);
		} else if (is_array($to) or is_string($to)) { // Move back to redirect value $to
			// check if array value exists
			// redirect to that value
		} else {
			return false;
		}
		return parent::redirect($url, $status = null, $exit = true);
	}
?>