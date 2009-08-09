<?php
class HoneypottingComponent extends Object {
	
	// Config
	var $settings = array(
		'spawnLikelyHood' => 0.5, // likelyhood of a honypot spawn, between 0 and 1
		'fakeModels' => array(
			'User',
			'Account',
			'Comment',
			'Subscription',
			'Membership',
			'Reply',
			'Pingback',
			'Trackback',
			'Link',
		),
		'fakeFields' => array(
			'nickname',
			'username',
			'nick',
			'name',
			'user',
			'from',
			'email',
			'url',
			'title',
		),
	);
	var $storedHoneypots = array();
	
	function initialize(&$Controller, $settings = array()) {
		$this->settings['fakeModels'] = array_diff($this->settings['fakeModels'], $settings['formModels']);
		$this->Controller =& $Controller;
		$this->settings = array_merge($this->settings, $settings);
		$this->Controller->helpers[] = 'Honeypot';
		foreach ($this->settings['fakeModels'] as $fakeModel) {
			foreach ($this->settings['fakeFields'] as $fakeField) {
				$honey[] = $fakeModel . '.' . $fakeField;
				$this->storedHoneypots[$fakeModel][$fakeField] = null;
			}
		}
		$this->Controller->params['honeypotting']['spawnLikelyhood'] = $this->settings['spawnLikelyHood'];
		$this->Controller->params['honeypotting']['honey'] = $honey;
	}
	
	function startup(&$Controller) {
		$this->Controller =& $Controller;
		if (isset($this->Controller->data)) {
			$captured = false;
			$collectedHoneypots = array_intersect_assoc($this->Controller->data, $this->storedHoneypots);
			foreach ($collectedHoneypots as $fakeModelname => $fakeModel) {
				foreach ($fakeModel as $fakeFieldname => $fakeField) {
					if ($collectedHoneypots[$fakeModelname][$fakeFieldname] != null) {
						$captured = true;
					}
				}
				
			}
			if ($captured) {
				$this->Controller->Session->setFlash(__("You don't seem to be human!", true));
				empty($this->data);
				$this->Controller->redirect($this->Controller->referer());
			}
		}
	}
	
}
?>
