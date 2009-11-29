<?php
class ConnectionsController extends AppController {
	
	var $name = 'Connections';
	
	/*
	* Handels:
	* 
	* friends (mutual)
	* followers
	* messaging_authentification
	* shouting_authentification
	* requests for all of that
	* ignores
	* 
	**/
	
	function beforeFilter() {
		parent::beforeFilter();
		// SecurityComponent setup
		if(!empty($this->data)) {
			// $this->Security->requirePost();
			// $this->Security->requirePut();
		}
		
	}
	
	function summary($toProfileId = null) {
		$this->set('toProfileData',
			$toProfileData = $this->Connection->ToProfile->find('first', array(
				'fields' => array('ToProfile.nickname'),
				'conditions' => array('ToProfile.id' => $toProfileId))));
		if (!$toProfileId or $toProfileData === false or
			$toProfileId == $this->Connection->Profile->getAuthedId($this->Auth->user())) {
			$this->Session->setFlash(__('Invalid profile.', true));
			$this->redirect($this->here);
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
	function ignores() {}
	function friends() {}
	function messaging_authentications() { }
	function shouting_authentications() { }
	
	// http://www.domain.tld/connections/request/ignore/123
	function request($type = null, $toProfileId = null) {
		// Form with OK button
	}
	
	// http://www.domain.tld/connections/accept/messaging_authentification/123
	function accept($type = null, $toProfileId = null) {
		$this->_processRequest($type, $toProfileId, true);
	}
	
	// http://www.domain.tld/connections/deny/friendship/123
	function cancel($type = null, $toProfileId = null) {
		$this->_processRequest($type, $toProfileId, false);
	}
	
	function ignore_request() {
		
	}
	
	// TODO NEXT
	// TODO NEXT  =>  Starting Screen, Profile, Summary
	// TODO NEXT
	function _processRequest($type = null, $toProfileId = null, $doAccept = true) {
		$requestOk = true;
		// check connection type GET param
		if (!$type or (!in_array($type, $this->Connection->validTypes)
				and !in_array($type, $this->Connection->validRequestTypes))) {
			$this->Session->setFlash(__('Invalid connection type.', true));
			$requestOk = false;
		}
		$profileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
		// Fetch and set request profile
		$toProfileData = $this->Connection->ToProfile->find('first', array(
				'fields' => array('nickname'),
				'conditions' => array('id' => $toProfileId)));
		// Check toProfileId GET param
		if (!$toProfileId or $toProfileData === false or $toProfileId == $profileId) {
			$this->Session->setFlash(__('Invalid profile.', true));
			$requestOk = false;
		}
		// Fetch request data
		$connectionData = $this->Connection->find('first', array(
			'fields' => array('created', 'value'),
			'conditions' => array(
				'profile_id' => $profileId,
				'to_profile_id' => $toProfileId,
				'type' => $type,
		)));
		// Check $connectionData for connection requests
		if (empty($connectionData)) {
			$this->Session->setFlash(__('Invalid request.', true));
			$requestOk = false;
		}
		if ($requestOk) {
			// user prestted button
			if(!empty($this->params['form']['yes'])) {
				// deny or accept
				if ($doAccept) {
					$value = $connectionData['Connection']['value'];
				} else {
					$value = null;
				}
				$establishData = array(
					array(
						'profile_id' => $profileId,
						'to_profile_id' => $toProfileId,
						'type' => $type,
						'value' => $connectionData['Connection']['value'],
					),
					array(
						'profile_id' => $profileId,
						'to_profile_id' => $toProfileId,
						'type' => $type . '_request',
						'value' => 0,
					),
				);
				if (in_array($type, $this->Connection->validMutualTypes)) {
					$establishData = array_merge($establishData, array(
						array(
							'profile_id' => $toProfileId,
							'to_profile_id' => $profileId,
							'type' => $type,
							'value' => $connectionData['Connection']['value'],
						),
						array(
							'profile_id' => $toProfileId,
							'to_profile_id' => $profileId,
							'type' => $type . '_request',
							'value' => 0,
						),
					));
				}
				$this->Connection->establish($establishData);
				$this->Session->setFlash(__('You have accepted the', true)
					. ' ' . Inflector::humanize($type) . ' ' . __('request.', true));
				$this->render('_process_request_empty');
			}
			if(!empty($this->params['form']['later'])) {
				$this->render('_process_request_empty');
			} else {
				$this->set(compact('toProfileData', 'connectionData'));
				$this->render('_process_request_form');
			}
		} else {
			$this->render('_process_request_empty');
		}
	}
	
	
}
?>