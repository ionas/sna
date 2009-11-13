<?php
class ConnectionsController extends AppController {
	
	var $name = 'Connections';
	var $helpers = array('Html', 'Form');
	
	function index() {
		$this->Connection->recursive = 0;
		$this->set('connections', $this->paginate());
	}
	
	function establish($toProfileId = null) {
		$profileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
		if (!$toProfileId or $profileId == $toProfileId) {
			$this->Session->setFlash(__('Invalid Profile for Connection', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('toProfile', $this->Connection->Profile->read('nickname', $toProfileId));
		if (empty($this->data)) {
			$this->data = $this->Connection->find('first', array(
				'conditions' => array(
					'Connection.profile_id' => $profileId,
					'Connection.to_profile_id' => $toProfileId)));
		}
		/*
		if (!empty($this->data)) {
			$this->Connection->create();
			if ($this->Connection->set($profileId, $targetProfileId, $this->data)) {
				$this->Session->setFlash(__('The Connection has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Connection could not be saved. Please, try again.', true));
			}
		}
		$profiles = $this->Connection->Profile->find('list');
		$profileTargets = $this->Connection->ToProfile->find('list');
		$this->set(compact('profiles', 'profileTargets'));
		*/
	}
	
	// http://www.domain.tld/connections/setup/friends/123
	function setup($type, $id) {
		// Form with OK button
	}
	
	// http://www.domain.tld/connections/accept_request/friends/123
	function accept_request($type, $id) {
		// Form with OK button
	}
	
	// http://www.domain.tld/connections/deny_request/friends/123
	function deny_request($type, $id) {
		// Form with OK button
	}
	
	// http://www.domain.tld/connections/ignore_request/friends/123
	function ignore_request($type, $id) {
		// Form with OK button
	}
	
}
?>