<?php
// Feature: ConnectionLog
class Connection extends AppModel {
	
	var $name = 'Connection';
	
	var $actsAs = array('Containable');
	
	var $validate = array(
		'type' => array('notempty'), // Alphanumeric as well
		'profile_id' => array('notempty'),
		'to_profile_id' => array('notempty'),
		'is_request' => array('boolean'),
		'is_hidden_by_requester' => array('boolean'),
		'is_hidden_by_requestee' => array('boolean'),
		'is_ignored_by_requestee' => array('boolean'), // Users won't notice being ignored at all.
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
		),
		'mutual' => array(
			'friend',
		),
		'respondable' => array(
			'friend',
			'messaging_authentification',
			'shouting_authentification',
		),
		'networkable' => array(
			'friend', // TODO: for friend of friend and friend of friend of friend
		),
	);
	
	var $responseMethods = array(
		'accept',
		'deny',
		'hide',
		'ignore',
	);
	
	var $return = array( // Default method return values
		'success' => false,
		'message' => 'Connection Error.',
		'status' => 0,
	);
	
	function __construct($id = false, $table = null, $ds = null) {
		$this->return['message'] = ___('Generic Connection Error.');
		parent::__construct($id, $table, $ds);
	}
	
	function findPossibleConnections($profileId, $toProfileId) {
		if ($profileId == $toProfileId) {
			return false;
		}
		// Filter established Connections
		$fields = array(
			'Connection.type',
		);
		$conditions = array(
			'Connection.profile_id' => $profileId,
			'Connection.to_profile_id' => $toProfileId,
			'Connection.is_request' => 0, // A request is anot 
		);
		$establishedConnections = $this->find('list', compact('fields', 'conditions'));
		$unestablishedConnections = array_diff($this->types['all'], $establishedConnections);
		
		// Filter connection types globally allowed by the target profile
		$possibleConnections = array_diff($unestablishedConnections,
			$this->_getTypesAuthedByProfile($toProfileId));
		
		return $possibleConnections;
	}
	
	function request($type, $profileId, $toProfileData) {
		$return = $this->return;
		if (in_array($type, $this->_getTypesAuthedByProfile($toProfileData['Profile']['id']))) {
			return $return;
		}
		$fields = array('id', 'type', 'is_request');
		$conditions = array(
			'type' => $type,
			'profile_id' => $profileId,
			'to_profile_id' => $toProfileData['Profile']['id'],
		);
		$existingData = $this->find('first', compact('fields', 'conditions'));
		if ($existingData === false) {
			return $this->_createRequest($type, $profileId, $toProfileData);
		} else {
			return $this->_renewRequest($existingData, $toProfileData);
		}
	}
	
	function respond($connectionId, $responseMethod) {
		$return = $this->return;
		$fields = array(
			'Connection.id',
			'Connection.type',
			'Connection.is_request',
			'Profile.nickname',
		);
		$conditions = array('Connection.id' => $connectionId);
		$contain = array('Profile');
		$connectionData = $this->find('first', compact('fields', 'conditions', 'contain'));
		$funcName = '_' . $responseMethod . 'Response';
		if ($connectionData['Connection']['is_request'] == 1) {
			if (in_array($responseMethod, $this->responseMethods)
				and method_exists($this, $funcName)
			) {
				$return = call_user_func(array($this->name, $funcName), $connectionData);
			} else {
				$this->log('Connection Model, respond(): Method called, does not exist.', 'error');
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
		$fields = array(
			'Connection.id',
			'Connection.type',
			'Profile.nickname',
		);
		$conditions = array('Connection.id' => $connectionId);
		$contain = array('Profile');
		$connectionData = $this->find('first', compact('fields', 'conditions', 'contain'));
		if ($this->delete($connectionData['Connection']['id'])) {
			$return['success'] = true;
			$return['message'] = sprintf(___('%s connection with %s canceled.'), 
				ucfirst(___d($connectionData['Connection']['type'])),
				$connectionData['Profile']['nickname']);
		} else {
			$return['message'] = sprintf(___('Could not cancel connection.'),
				ucfirst(___d($connectionData['Connection']['type'])),
				$connectionData['Profile']['nickname']);
		}
		return $return;
	}
	
	function _getTypesAuthedByProfile($profileId) {
		$typesAuthedByProfile = array();
		$fields = array();
		$conditions = array('id' => $profileId);
		foreach ($this->types['all'] as $type) {
			if (in_array('is_required_' . $type, array_keys($this->Profile->_schema))) {
				$types['is_required_' . $type] = 0;
				$fields[] = 'is_required_' . $type;
			}
		}
		$conditions[] = array('or' => $types);
		$profileData = $this->Profile->find('first', compact('fields', 'conditions'));
		if (!empty($profileData)) {
			foreach ($profileData['Profile'] as $type => $flag) {
				if ($flag == 0) { // is_required_?_authentification = 0
					$type = explode('is_required_', $type);
					$typesAuthedByProfile[] = $type[1];
				}
			}
		}
		return $typesAuthedByProfile;
	}

	function _acceptResponse($connectionData) {
		$return = $this->return;
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
			$return['message'] = sprintf(___('Could not accept %s request by %s.'),
				$connectionData['Profile']['nickname']);
		}
		return $return;
	}
	
	function _denyResponse($connectionData) {
		$return = $this->return;
		if ($this->delete($connectionData['Connection']['id'])) {
			$return['success'] = true;
			$return['message'] = sprintf(___('Rejected %s request by %s.'), 
				___d($connectionData['Connection']['type']),
				$connectionData['Profile']['nickname']);
		} else {
			$return['message'] = sprintf(___('Could not reject %s request by %s.'),
				$connectionData['Profile']['nickname']);
		}
		return $return;
	}
	
	function _hideResponse($connectionData) {
		$return = $this->return;
		if ($this->_store(array(
			'id' => $connectionData['Connection']['id'],
			'modified' => date('Y-m-d H:i:s'),
			'is_hidden_by_requestee' => 1,
		))) {
			$return['success'] = true;
			$return['message'] = sprintf(___('Hid %s request by %s.'), 
				___d($connectionData['Connection']['type']),
				$connectionData['Profile']['nickname']);
		} else {
			$return['message'] = sprintf(___('Could not hide %s request by %s.'),
				$connectionData['Profile']['nickname']);
		}
		return $return;
	}
	
	function _ignoreResponse($connectionData) {
		$return = $this->return;
		if ($this->_store(array(
			'id' => $connectionData['Connection']['id'],
			'modified' => date('Y-m-d H:i:s'),
			'is_ignored_by_requestee' => 1,
		))) {
			$return['success'] = true;
			$return['message'] = sprintf(___('Ignored %s request by %s.'), 
				___d($connectionData['Connection']['type']),
				$connectionData['Profile']['nickname']);
		} else {
			$return['message'] = sprintf(___('Could not ignore %s request by %s.'),
				$connectionData['Profile']['nickname']);
		}
		return $return;
	}
	
	function _createRequest($type, $profileId, $toProfileData) {
		$return = $this->return;
		$requestResponseRequired = true;
		if (!in_array($type, $this->types['respondable']) or ( // No response required by connection
			 	// ...or: not a required flag that is set to 0 (not required) 
				in_array('is_required_' . $type, array_keys($this->ToProfile->_schema))
				and $toProfileData['Profile']['is_required_' . $type] == 0)
		) {
				$requestResponseRequired = false;
		}
		// If response required (disableable by Profile::is_required_$type = 0)
		if ($requestResponseRequired) {
			$connectionData = array(
				'profile_id' => $profileId,
				'to_profile_id' => $toProfileData['Profile']['id'],
				'type' => $type,
				'is_request' => 1,
			);
			// If there is a mutual request of the same type
			// do not create a new connection
			// but update the given one.
			$fields = array('id');
			$conditions = $connectionData;
			$conditions['profile_id'] = $connectionData['to_profile_id'];
			$conditions['to_profile_id'] = $connectionData['profile_id'];
			$existingData = $this->find('first', compact('conditions'));
			if($existingData !== false) {
				$this->id = $existingData['Connection']['id'];
				$existingData['is_request'] = 0;
				if ($this->save($existingData)) {
					$return['success'] = true;
					$return['message'] = sprintf(___('%s with %s established.'), 
						ucfirst(___d($type)), $toProfileData['Profile']['nickname']);
					
				} else {
					$return['message'] = sprintf(___('Could not establish %s with %s.'),
						___d($type), $toProfileData['Profile']['nickname']);
				}
			}
			// Else store the connection
			else if ($this->_store($connectionData)) {
				$return['success'] = true;
				$return['message'] = sprintf(___('%s requested from %s.'),
					ucfirst(___d($type)), $toProfileData['Profile']['nickname']);
				$return['status'] = 2;
			} else {
				$return['message'] = sprintf(___('Could not request %s from %s.'),
					___d($type), $toProfileData['Profile']['nickname']);
			}
		} else { // If no response required (either because of type, or because of profile setting)
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
	
	function check($type, $fromProfileId, $toProfileId) {
		// No point connecting to one self
		if ($toProfileId == $fromProfileId) {
			return false;
		}
		// Check auth by connection...
		$conditions = array(
			'type' => $type,
			'is_request' => 0,
		);
		if (in_array($type, $this->types['mutual'])) { // Mutual type = twisted IDs
			$conditions['Connection.profile_id'] = $toProfileId;
			$conditions['Connection.to_profile_id'] = $fromProfileId;
		} else { // Non mutual type
			$conditions['Connection.profile_id'] = $fromProfileId;
			$conditions['Connection.to_profile_id'] = $toProfileId;
		}
		$authed = (boolean) $this->find('count', compact('fields', 'conditions'));
		// If not authed by Connection, check if there is an authentification by profile defaults
		if ($authed == false) {
			if (in_array('is_required_' . $type, array_keys($this->Profile->_schema))) {
				$conditions = array(
					'id' => $toProfileId,
					'is_required_' . $type => 0,
				);
				if ((boolean) $this->Profile->find('count', compact('conditions'))) {
					return true;
				}
			}
		}
		return $authed;
	}
	
}
?>