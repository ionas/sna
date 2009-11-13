<?php
class ConnectionsController extends AppController {
	
	var $name = 'Connections';
	var $helpers = array('Html', 'Form');
	
	function summary($toProfileId = null) {
		$this->set('toProfileData',
			$toProfileData = $this->Connection->ToProfile->find('first', array(
				'fields' => array('ToProfile.nickname'),
				'conditions' => array('ToProfile.id' => $toProfileId))));
		if (!$toProfileId or $toProfileData === false or
			$toProfileId == $this->Connection->Profile->getAuthedId($this->Auth->user())) {
			$this->Session->setFlash(__('Invalid profile.', true));
			$this->Breadcrume->redirectBack();
		}
		$this->paginate = array(
			'fields' => array(
				'Connection.id',
				'Connection.profile_id',
				'Connection.to_profile_id',
				'Connection.created',
				'Connection.type',
				'Connection.value',
				'ToProfile.nickname',
			),
			'contain' => array(
				'Profile',
				'ToProfile',
			),
			'conditions' => array(
				'Connection.profile_id' => $this->Connection->Profile->getAuthedId($this->Auth->user()),
				'Connection.to_profile_id' => $toProfileId,
			),
			'order' => 'created DESC',
			'limit' => 10,
		);
		$this->set('connections', $this->paginate());
	}
	
	// list stuff
	function friends() {
		
	}
	
	// list stuff
	function ignores() {
		
	}
	
	// http://www.domain.tld/connections/setup/friends/123
	function setup($type = null, $id = null) {
		// Form with OK button
	}
	
	// http://www.domain.tld/connections/accept_reaction/friends/123
	function accept_request($type = null, $toProfileId = null) {
		$type = 'shouting_authentication';
		$profileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
		// fetch and set request profile
		$toProfileData = $this->Connection->ToProfile->find('first', array(
				'fields' => array('nickname'),
				'conditions' => array('id' => $toProfileId)));
		// fetch and set request data
		$connectionData = $this->Connection->find('first', array(
			'fields' => array('created'),
			'conditions' => array('type' => $type . '_request', 'profile_id' => $profileId,
		)));
		// check connection type GET param
		if (!$type or !in_array($type, $this->Connection->types)) {
				$this->Session->setFlash(__('Invalid connection type.', true));
				$this->Breadcrume->redirectBack();
		}
		// check toProfileId GET param
		if (!$toProfileId or $toProfileData === false or $toProfileId == $profileId) {
				$this->Session->setFlash(__('Invalid profile.', true));
				$this->Breadcrume->redirectBack();
		}
		if(!empty($this->params['form']['cancel'])) {
			$this->Session->setFlash(__('Canceled', true));
		}
		if(!empty($this->params['form']['ok'])) {
			$this->Connection->establish(array(
				array(
					'profile_id' => $profileId,
					'to_profile_id' => $toProfileId,
					'type' => $type,
					'value' => 1,
				),
				array(
					'profile_id' => $toProfileId,
					'to_profile_id' => $profileId,
					'type' => $type,
					'value' => 1,
				),
				array(
					'profile_id' => $profileId,
					'to_profile_id' => $toProfileId,
					'type' => $type . '_request',
					'value' => 1,
				),
				array(
					'profile_id' => $toProfileId,
					'to_profile_id' => $profileId,
					'type' => $type . '_request',
					'value' => 1,
				),
			));
		}
		$this->set(compact('toProfileData', 'connectionData'));
		$this->render('_reaction');
	}
	
	// http://www.domain.tld/connections/deny_reaction/friends/123
	function deny_request($type = null, $id = null) {
		$this->render('_reaction');
	}
	
	// http://www.domain.tld/connections/ignore_reaction/friends/123
	function ignore_request($type = null, $id = null) {
		$this->render('_reaction');
	}
	
}
?>