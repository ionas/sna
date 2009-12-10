<?php
class ConnectionsController extends AppController {
	
	var $name = 'Connections';
	
	var $paginationLimit = 1;
	
	function request($type = null, $toProfileId = null) {
		$authedProfileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
		$error = false;
		// TODO fetch $toProfileId from profiles, check if it actually exists
		if ($type == null) {
			$error = ___('No type specified.');
		} else if ($toProfileId == null) {
			$error = ___('Invalid profile id.');
		} else if ($authedProfileId == $toProfileId) {
			$error = sprintf(___('You request connection %s to yourself.'),
				__d('additions', $type, true));
		}
		if ($error !== false) {
			$this->Session->setFlash($errorMsg);
		} else {
			$info = $this->Connection->saveOrRenewRequest($type, $authedProfileId, $toProfileId);
			if ($info['success'] == true) {
				$this->Session->setFlash($info['message'], 'flashes/success');
			} else {
				$this->Session->setFlash($info['message']);
			}
		}
		$this->redirect(array('controller' => 'connections', 'action' => 'outgoing_requests'));
	}
	
	function respond($answer, $id) {
		
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
			'Connection.is_hidden',
			'Connection.is_request',
			'Connection.is_ignored',
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
				'or' => array(
					'Connection.to_profile_id' => $toProfileId,
					// If on the other side of a (mutual) connection
					array(
						'Connection.profile_id' => $toProfileId,
//						'Connection.type' => $this->Connection->types['mutual'],
					),
				),
			);
		}
		$contain = array(
			'Profile',
			'ToProfile',
		);
		$order = array(
			'Connection.is_hidden',
			'Connection.is_request',
			'Connection.is_ignored',
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
			'Connection.is_hidden',
			'Connection.is_request',
			'Connection.is_ignored',
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
			'Connection.is_hidden',
			'Connection.is_request',
			'Connection.is_ignored',
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
			'Connection.is_hidden',
			'Connection.is_request',
			'Connection.is_ignored',
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
			'Connection.is_hidden',
			'Connection.is_request',
			'Connection.is_ignored',
			'Connection.modified',
		);
		$limit = $this->paginationLimit;
		$this->paginate = compact('fields', 'conditions', 'contain', 'order', 'limit');
		$this->set('connections', $this->paginate());
		$this->set('viewTitle', ___('Outgoing requests'));
		$this->render('index');
	}
	
}
?>