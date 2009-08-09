<?php
class HoneypotHelper extends AppHelper {
	
	var $helpers = array('Html', 'Form');
	
	var $honey = array();
	
	function beforeRender() {
		$this->honey = $this->params['honeypotting']['honey'];
		shuffle($this->honey);
	}
	
	function spawn() {
		if(($this->params['honeypotting']['spawnLikelyhood'] * 100) <= mt_rand(0, 100)) {
			// change from Form->hidden to Form->input for debugging
			$honeypot = $this->Form->input(current($this->honey));
			// Generate next random honypot spawn
			next($this->honey);
			if(key($this->honey) === null) {
				shuffle($this->honey);
			}
			return $honeypot;
		} else {
			return null;
		}
	}
	
}
?>
