<?php
class ConnectionsController extends AppController {
	
	var $name = 'Connections';
	var $helpers = array('Html', 'Form');
	
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
			// $this->redirect()
		} else {
			$info = $this->Connection->saveOrRenewRequest($type, $profileId, $toProfileId);
			debug($info);
		}
	}
	
	function respond($answer, $id) {
		
	}
	
	function summary($toProfileId = null) {
		$fields = array(
			'Connection.id',
			'Connection.created',
			'Connection.modified',
			'Connection.type',
			'Connection.to_profile_id',
			'Connection.is_hidden',
			'Connection.is_request',
			'Connection.is_mutual',
			'ToProfile.nickname',
		);
		$conditions = array(
			'Connection.is_request' => 0,
			'Connection.profile_id' => $this->Connection->Profile->getAuthedId($this->Auth->user()),
		);
		if ($toProfileId != null) {
			$conditions['Connection.to_profile_id'] = $toProfileId;
		}
		$contain = array(
			'ToProfile',
		);
		$order = array(
			'Connection.is_hidden',
			'Connection.is_request',
			'Connection.is_mutual',
			'Connection.modified',
		);
		$this->paginate = compact('fields', 'conditions', 'contain', 'order');
		$this->set('connections', $this->paginate());
	}
	
	function requests($profileId = null) {
		$fields = array(
			'Connection.id',
			'Connection.created',
			'Connection.modified',
			'Connection.type',
			'Connection.profile_id',
			'Connection.is_hidden',
			'Connection.is_request',
			'Connection.is_mutual',
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
			'Connection.is_mutual',
			'Connection.modified',
		);
		$this->paginate = compact('fields', 'conditions', 'contain', 'order');
		$this->set('connections', $this->paginate());
	}
}
?>