<?php
class ConnectionsController extends AppController {
	
	var $name = 'Connections';
	
	var $paginationLimit = 1;
	
	function beforeFilter() {
		parent::beforeFilter();
		// SecurityComponent setup
		// $this->Security->requirePost('request', 'respond');
	}
	
	function index() {
		$toProfileId = null;
		if (!empty($this->params['named']['profile'])) {
			$toProfileId = $this->params['named']['profile'];
		}
		$authedProfileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
		$fields = array(
			'Connection.id',
			'Connection.created',
			'Connection.modified',
			'Connection.type',
			'Connection.profile_id',
			'Connection.to_profile_id',
			'Connection.is_request',
			'Connection.is_hidden_by_requestee',
			'Connection.is_hidden_by_requester',
			'Connection.is_ignored_by_requestee',
			'Connection.is_deleted_by_requestee',
			'Profile.id',
			'Profile.nickname',
			'ToProfile.id',
			'ToProfile.nickname',
		);
		$conditions = array(
			'Connection.is_request' => 0,
			'or' => array(
				// If on this side of a (mutual?) connection
				array(
					'Connection.profile_id' => $authedProfileId,
				),
				array(
					'Connection.to_profile_id' => $authedProfileId,
				),
			)
		);
		// If filtered by target profile, add some conditions
		if ($toProfileId != null) {
			$conditions[] = array(
				'Connection.to_profile_id' => $toProfileId,
			);
		}
		$contain = array(
			'Profile',
			'ToProfile',
		);
		$order = array(
			'Connection.modified',
		);
		$limit = $this->paginationLimit;
		$this->paginate = compact('fields', 'conditions', 'contain', 'order', 'limit');
		$this->set('connections', $this->paginate());
		$this->set('viewTitle', ___('Established connections'));
	}
	
	function incoming_requests($profileId = null) {
		$authedProfileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
		$fields = array(
			'Connection.id',
			'Connection.created',
			'Connection.modified',
			'Connection.type',
			'Connection.profile_id',
			'Connection.to_profile_id',
			'Connection.is_request',
			'Connection.is_hidden_by_requestee',
			'Connection.is_hidden_by_requester',
			'Connection.is_ignored_by_requestee',
			'Connection.is_deleted_by_requestee',
			'Profile.id',
			'Profile.nickname',
		);
		$conditions = array(
			'Connection.is_request' => 1,
			'Connection.to_profile_id' => $authedProfileId,
		);
		if ($profileId != null) {
			$conditions['Connection.profile_id'] = $profileId;
		}
		$contain = array(
			'Profile',
		);
		$order = array(
			'Connection.modified',
		);
		$limit = $this->paginationLimit;
		$this->paginate = compact('fields', 'conditions', 'contain', 'order', 'limit');
		$this->set('connections', $this->paginate());
		$this->set('viewTitle', ___('Pending requests'));
		$this->render('index');
	}
	
	function outgoing_requests($profileId = null) {
		$authedProfileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
		$fields = array(
			'Connection.id',
			'Connection.created',
			'Connection.modified',
			'Connection.type',
			'Connection.profile_id',
			'Connection.to_profile_id',
			'Connection.is_request',
			'Connection.is_hidden_by_requestee',
			'Connection.is_hidden_by_requester',
			'Connection.is_ignored_by_requestee',
			'Connection.is_deleted_by_requestee',
			'Profile.id',
			'Profile.nickname',
			'ToProfile.id',
			'ToProfile.nickname',
		);
		$conditions = array(
			'Connection.is_request' => 1,
			'Connection.profile_id' => $authedProfileId,
		);
		if ($profileId != null) {
			$conditions['Connection.to_profile_id'] = $profileId;
		}
		$contain = array(
			'Profile',
			'ToProfile',
		);
		$order = array(
			'Connection.modified',
		);
		$limit = $this->paginationLimit;
		$this->paginate = compact('fields', 'conditions', 'contain', 'order', 'limit');
		$this->set('connections', $this->paginate());
		$this->set('viewTitle', ___('Outgoing requests'));
		$this->render('index');
	}
	
	function request($type = null, $toProfileId = null) {
		$authedProfileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
		$toProfileData = $this->Connection->ToProfile->read(null, $toProfileId);
		$error = false;
		if ($type == null or !in_array($type, $this->Connection->types['all'])) {
			$error = ___('Invalid connection type.');
		} else if ($toProfileData === false) {
			$error = ___('Invalid profile id.');
		} else if ($authedProfileId == $toProfileId) {
			$error = sprintf(___('You establish %s to yourself.'), ___d($type));
		}
		if ($error !== false) {
			$this->Session->setFlash($error);
		} else {
			$return = $this->Connection->request($type, $authedProfileId, $toProfileData);
			if ($return['success'] == true) {
				$this->Session->setFlash($return['message'], 'flashes/success');
			} else {
				$this->Session->setFlash($return['message']);
			}
		}
		$this->redirect(array('controller' => 'connections', 'action' => 'outgoing_requests'));
	}
	
	function respond($responseMethod = null, $id = null) {
		$connectionData = $this->Connection->read('to_profile_id', $id);
		$authedProfileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
		$error = false;
		if ($connectionData === false) {
			$error = ___('Invalid connection.');
		} else if ($authedProfileId != $connectionData['Connection']['to_profile_id']) {
			$error = ___('You can only respond to requests made to you.');
		} else if (!in_array($responseMethod, $this->Connection->responseMethods)) {
			$error = ___('Invalid response.');
		}
		if ($error !== false) {
			$this->Session->setFlash($error);
		} else {
			$return = $this->Connection->respond($id, $responseMethod);
			if ($return['success'] == true) {
				$this->Session->setFlash($return['message'], 'flashes/success');
			} else {
				$this->Session->setFlash($return['message']);
			}
		}
		$this->redirect(array('controller' => 'connections', 'action' => 'incoming_requests'));
	}
	
	function cancel($connectionId = null) {
		// TODO
		$this->Connection->cancel($connectionId);
	}
	
}
?>