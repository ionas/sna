<?php

// TODO:
// Not sure yet if we should DOUBLE-save mutual connections.
// We probably should? Should not? Which is easier to implement? Which faster?

class Connection extends AppModel {
	
	var $name = 'Connection';
	
	var $actsAs = array('Containable');
	
	var $validate = array(
		'type' => array('notempty'),
		'profile_id' => array('notempty'),
		'to_profile_id' => array('notempty'),
		'is_request' => array('boolean'),
		'is_hidden_by_requester' => array('boolean'),
		'is_hidden_by_requestee' => array('boolean'),
		'is_ignored_by_requestee' => array('boolean'), // Users won't notice if ignored in general
		'is_deleted_by_requestee' => array('boolean'), // Hiding non-mutual connections like follow
	);
	
	var $belongsTo = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'profile_id',
		),
		'ToProfile' => array(
			'className' => 'Profile',
			'foreignKey' => 'to_profile_id',
		)
	);
	
	var $types = array(
		'all' => array(
			'ignore',
			'follow',
			'friend',
			'messaging_authentification',
			'shouting_authentification',
			'partner', // TODO: Just for testing
		),
		'mutual' => array(
			'friend',
			'partner', // TODO: Just for testing
		),
		'respondable' => array(
			'friend',
			'messaging_authentification',
			'shouting_authentification',
			'partner', // TODO: Just for testing
		),
	);
	
	var $responseMethods = array(
		'accept',
		'reject',
		'hide',
		'ignore',
	);
	
	var $return = array( // Default method return values
		'success' => false,
		'message' => 'Error',
	);
	
	function request($type, $profileId, $toProfileData) {
		$fields = array('id', 'type', 'is_request');
		$conditions = array(
			'profile_id' => $profileId,
			'to_profile_id' => $toProfileData['Profile']['id'],
			'type' => $type,
		);
		$existingData = $this->find('first', compact('fields', 'conditions'));
		if ($existingData === false) {
			return $this->_createRequest($type, $profileId, $toProfileData);
		} else {
			return $this->_renewRequest($existingData, $toProfileData);
		}
	}
	
	function respond($connectionId, $reponseMethod) {
		$return = $this->return;
		$connectionData = $this->find('first', array(
			'fields' => array(
				'Connection.id',
				'Connection.type',
				'Connection.is_request',
				'Profile.nickname',
			),
			'conditions' => array('Connection.id' => $connectionId),
			'contain' => array(
				'Profile',
			),
		));
		$funcName = '_' . $reponseMethod . 'Response';
		if ($connectionData['Connection']['is_request'] == 1) {
			if (in_array($reponseMethod, $this->responseMethods)
				and method_exists($this, $funcName)
			) {
				$return = call_user_func(array($this->name, $funcName), $connectionData);
			} else {
				$this->log('Connection Model, respond(): Method called, does not exist.');
			}
		} else {
			$return['message'] = sprintf(___('Connection %s with %s is already established.'),
				___d($connectionData['Connection']['type']),
				$connectionData['Profile']['nickname']);
		}
		return $return;
	}
	
	function cancel($connectionId) {
		$return = $this->return;
		// TODO
		return $return;
	}
	
	function _acceptResponse($connectionData) {
		$return = $this->return;
		// TODO: If mutual?!
		if ($this->_store(array(
			'id' => $connectionData['Connection']['id'],
			'modified' => date('Y-m-d H:i:s'),
			'is_request' => 0,
			'is_hidden_by_requester' => 0,
			'is_hidden_by_requestee' => 0,
		))) {
			$return['success'] = true;
			$return['message'] = sprintf(___('Accepted %s request by %s.'), 
				___d($connectionData['Connection']['type']),
				$connectionData['Profile']['nickname']);
		} else {
			$return['success'] = true;
			$return['message'] = sprintf(___('Could not accept %s request by %s.'),
				$connectionData['Profile']['nickname']);
		}
		return $return;
	}
	
	function _rejectReponse($connectionData) {
		$return = $this->return;
		// TODO
		return $return;
	}
	
	function _hideReponse($connectionData) {
		$return = $this->return;
		// TODO
		return $return;
	}
	function _ignoreReponse($connectionData) {
		$return = $this->return;
		// TODO
		return $return;
	}
	
	function _createRequest($type, $profileId, $toProfileData) {
		$return = $this->return;
		// TODO: Check if there is a mutual request of the same type, if so skip request and store.
		if ((
				!in_array('is_response_required_for_' . $type, array_keys($this->ToProfile->_schema))
				and in_array($type, $this->types['respondable'])
			) or (
				in_array('is_response_required_for_' . $type, array_keys($this->ToProfile->_schema)
				and $toProfileData['Profile']['is_response_required_for_' . $type] == 1
				and in_array($type, $this->types['respondable']))
			)
		) { // If response required (disableable by Profile::is_response_required_for_$type = 0)
			if ($this->_store(array(
				'profile_id' => $profileId,
				'to_profile_id' => $toProfileData['Profile']['id'],
				'type' => $type,
				'is_request' => 1,
			))) {
				$return['success'] = true;
				$return['message'] = sprintf(___('%s requested from %s.'),
					ucfirst(___d($type)), $toProfileData['Profile']['nickname']);
			} else {
				$return['message'] = sprintf(___('Could not request %s from %s.'),
					___d($type), $toProfileData['Profile']['nickname']);
			}
		} else { // If no response required
			if ($this->_store(array(
				'profile_id' => $profileId,
				'to_profile_id' => $toProfileData['Profile']['id'],
				'type' => $type,
			))) {
				$return['success'] = true;
				$return['message'] = sprintf(___('%s with %s established.'), 
					ucfirst(___d($type)), $toProfileData['Profile']['nickname']);
			} else {
				$return['message'] = sprintf(___('Could not establish %s with %s.'),
					___d($type), $toProfileData['Profile']['nickname']);
			}
		}
		return $return;
	}
	
	function _renewRequest($existingData, $toProfileData) {
		$return = $this->return;
		if ($existingData['Connection']['is_request'] == 0) { // Renew requests only (else bollox)
			$return['message'] = sprintf(___('%s for %s already established.'),
				ucfirst(___d($existingData['Connection']['type'])),
				$toProfileData['Profile']['nickname']);
		} else if ($this->_store(array(
				'id' => $existingData['Connection']['id'],
				'modified' => date('Y-m-d H:i:s'),
				'is_hidden_by_requester' => 0,
				'is_hidden_by_requestee' => 0,
		))) { // Successful...
			$return['success'] = true;
			$return['message'] = sprintf(___('%s request for %s renewed.'),
				ucfirst(___d($existingData['Connection']['type'])),
				$toProfileData['Profile']['nickname']);
		} else { // Failed...
			$return['message'] = sprintf(___('%s request for %s could not be renewed.'),
				ucfirst(___d($existingData['Connection']['type'])),
				$toProfileData['Profile']['nickname']);
		}
		return $return;
	}
	
	function _store($set) {
		if (isset($set['type']) and !in_array($set['type'], $this->types['all'])) { // Valid type?
			$this->log('Connection Model, _store(): Incorrect type specified on save.', 'error');
			return false;
		}
		$data = $this->data; // Backup $this->data
		unset($this->data); // Security using $this->set() and $this->save() without 'fieldList'
		$result = $this->save($set);
		$this->data = $data; // Restore $this->data
		// $this->log($result, 'debug'); // Debugging save result
		return $result;
	}
	
}
?>