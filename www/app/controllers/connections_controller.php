<?php
class ConnectionsController extends AppController {
	
	var $name = 'Connections';
	
	function request($type = null, $toProfileId = null) {
		$profileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
		$error = false;
		// TODO fetch $toProfileId from profiles, check if it actually exists
		if ($type == null) {
			$error = ___('No type specified.');
		} else if ($toProfileId == null) {
			$error = ___('Invalid profile id.');
		} else if ($profileId == $toProfileId) {
			$error = sprintf(___('You request connection %s to yourself.'),
				__d('additions', $type, true));
		}
		if ($error !== false) {
			$this->Session->setFlash($errorMsg);
		} else {
			$info = $this->Connection->saveOrRenewRequest($type, $profileId, $toProfileId);
			if ($info['success'] == true) {
				$this->Session->setFlash($info['message'], 'flashes/success');
			} else {
				$this->Session->setFlash($info['message']);
			}
		}
		$this->redirect(array('controller' => 'connections', 'action' => 'summary'));
	}
	
	function respond($answer, $id) {
		
	}
	
	function summary($toProfileId = null) {
		$profileId = $this->Connection->Profile->getAuthedId($this->Auth->user());
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
			'Profile.nickname',
			'ToProfile.nickname',
		);
		$conditions = array(
			'or' => array(
				'Connection.profile_id' => $profileId,
				// If on the other side of a mutual connection
				array(
					'Connection.to_profile_id' => $profileId,
					'Connection.type' => $this->Connection->types['mutual'],
				),
			)
		);
		// If filtered by target profile, add some conditions
		if ($toProfileId != null) {
			$conditions[] = array(
				'or' => array(
					'Connection.to_profile_id' => $toProfileId,
					// If on the other side of a mutual connection
					array(
						'Connection.profile_id' => $toProfileId,
						'Connection.type' => $this->Connection->types['mutual'],
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
		$this->paginate = compact('fields', 'conditions', 'contain', 'order');
		$this->set('connections', $this->paginate());
	}
	
	function incoming_requests($profileId = null) {
		$fields = array(
			'Connection.id',
			'Connection.created',
			'Connection.modified',
			'Connection.type',
			'Connection.profile_id',
			'Connection.is_hidden',
			'Connection.is_request',
			'Connection.is_ignored',
			'Profile.nickname',
		);
		$conditions = array(
			'Connection.is_request' => 1,
			'Connection.to_profile_id' => $this->Connection->Profile->getAuthedId($this->Auth->user()),
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
		$this->paginate = compact('fields', 'conditions', 'contain', 'order');
		$this->set('connections', $this->paginate());
	}
	
}
?>