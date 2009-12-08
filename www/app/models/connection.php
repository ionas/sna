<?php
class Connection extends AppModel {

	var $name = 'Connection';
	
	var $actsAs = array('Containable');
	
	var $validate = array(
		'type' => array('notempty'),
		'profile_id' => array('notempty'),
		'to_profile_id' => array('notempty'),
		'is_request' => array('boolean'),
		'is_hidden' => array('boolean'),
		'is_ignored' => array('boolean'),
	);
	
	var $types = array(
		'all' => array(
			'ignore',
			'follow',
			'friend',
			'partner',
			'messaging_authentification',
			'shouting_authentification',
		),
		'mutual' => array(
			'friend',
			'partner', // just for testing
		),
		'respondable' => array(
			'friend',
			'partner',
			'messaging_authentification',
			'shouting_authentification',
		),
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
	
	function saveOrRenewRequest($type, $profileId, $toProfileId) {
		// Check for existing connection requests
		$return = array('success' => false);
		$fields = array('id', 'is_request', 'profile_id');
		$conditions = array(
			'type' => $type,
			'is_ignored' => 0,
			'or' => array(
				array(
					'profile_id' => $profileId,
					'to_profile_id' => $toProfileId,
				),
				array(
					'profile_id' => $toProfileId,
					'to_profile_id' => $profileId,
				),
			),
		);
		$existingData = $this->find('first', compact('fields', 'conditions'));
		// Connection already exists?
		if ($existingData !== false) {
			// Connection is still a request and requestee is requester again
			if ($existingData['Connection']['is_request'] == 1
			and $existingData['Connection']['profile_id'] == $profileId) {
				$this->id = $existingData['Connection']['id'];
				$saveData = array('Connection' => array(
					'modified' => date('Y-m-d H:i:s'),
					'is_hidden' => 0,
				));
				// Renew Request
				if ($this->save($saveData, false, array('modified', 'is_hidden'))) {
					// Successful...
					$return['success'] = true;
					$return['message'] = ___('Connection request renewed.');
				} else {
					// Failed...
					$return['message'] = ___('Connection could not be refreshed.');
				}
			// Connection is no request and already existing
			} else {
				$return['message'] = ___('Connection already existing.');
			}
		// Connection does not exist yet
		} else {
			// Check for valid types?
			if (!in_array($type, $this->types['all'])) {
				$return['message'] = ___('Connection type invalid.');
			// Else check if the connection requires a response
			} else if (in_array($type, $this->types['respondable'])) {
				$this->id = $existingData['Connection']['id'];
				$saveData = array('Connection' => array(
					'profile_id' => $profileId,
					'to_profile_id' => $toProfileId,
					'type' => $type,
					'is_request' => 1,
				));
				if ($this->save($saveData, false, 
						array('profile_id', 'to_profile_id', 'type', 'is_request'))) {
					$return['success'] = true;
					$return['message'] = ___('Connection request send, waiting for response.');
				} else {
					$return['message'] = ___('Connection request could not be established.');
				}
			// Else setup connection
			} else {
				$this->id = $existingData['Connection']['id'];
				$saveData = array('Connection' => array(
					'profile_id' => $profileId,
					'to_profile_id' => $toProfileId,
					'type' => $type,
				));
				if ($this->save($saveData, false, array('profile_id', 'to_profile_id', 'type'))) {
					$return['success'] = true;
					$return['message'] = sprintf(___('%s established.'), ucfirst(
						__d('additions', $type, true)));
				} else {
					$return['message'] = sprintf(___('%s not established.'), ucfirst(
						__d('additions', $type, true)));
				}
			}
		}
		return $return;
	}
	
	// OLD TODO:
	// 
	// 1. On Read, check given ProfileID in ProfileA and ProfileB fields
	//    Return either of them
	//
	// 2. On Save, check if profileA or profileB have been inserted already
	//    If that is the case, load these models data, and apply the data to those.
	//    Also: ProfileA and ProfileB cannot be of the same ID (no self reference)
	//
	// 3. If someone is ignored, filter them from returned friend data
	// 4. If someone is ignored, filter them from authed (messages or shouts) data
	//
	// 5. Beforevalidate: If all zero -> do not save at all (validation error)
	//
	// 6. If all bools are zero, remove the whole data record alltogther (afterSave)
	//
	// 7. Do not forget to treat "Requests" in a clean way (e.g. set them to zero)
	
}
?>