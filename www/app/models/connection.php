<?php
class Connection extends AppModel {
	
	var $name = 'Connection';
	
	var $actsAs = array('Containable');
	
	var $primaryKey = 'id';
	
	var $validate = array(
		'profile_id' => array('notempty'),
		'to_profile_id' => array('notempty'),
		'type' => array('notempty'),
		'value' => array('notempty')
	);
	
	var $belongsTo = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'profile_id',
		),
		'ToProfile' => array(
			'className' => 'Profile',
			'foreignKey' => 'to_profile_id',
		),
	);
	
	var $validTypes = array(
		'friendship',
		'messaging_authentication',
		'shouting_authentication',
		'ignore',
	);
	
	var $validRequestTypes = array(
		'friendship_request',
		'messaging_authentication_request',
		'shouting_authentication_request',
	);
	
	var $validMutualTypes = array(
		'friendship',
		'messaging_authentication',
	);
	
	// runtime storage cache
	var $_cachedStorage = null;
	
	function establish($data = array()) {
		$storedConditions = $data;
		foreach($data as $index => $item) {
			unset($item['value']);
			$storedConditions[$index] = $item;
		}
		$storedData = $this->find('all', array(
			'fields' => array('id', 'profile_id', 'to_profile_id', 'type'),
			'conditions' => array('or' => $storedConditions),
		));
		$storedData = Set::extract($storedData, '{n}.Connection');
		$newData = $data;
		foreach ($newData as $index => $item) {
			foreach ($storedData as $storedIndex => $storedItem) {
				if($storedData[$storedIndex]['profile_id'] == $data[$index]['profile_id']
				and $storedData[$storedIndex]['to_profile_id'] == $data[$index]['to_profile_id']
				and $storedData[$storedIndex]['type'] == $data[$index]['type']) {
					$storedData[$storedIndex]['value'] = $newData[$index]['value'];
					unset($newData[$index]);
				}
			}
		}
		$data = array_merge($newData, $storedData);
		// Insert, Update or Delete Data...
		$deleteIds = array();
		$Ds = $this->getDataSource();
		$Ds->begin($this);
		foreach ($data as $index => $item) {
			unset($this->id);
			// a given record is updated
			if (isset($item['id'])) {
				$this->id = $item['id'];
			}
			// a given dataset is null, remove it
			if ($item['value'] == null) {
				if (isset($this->id)) {
					$this->delete($this->id);
				}
			}
			// else we save it
			else {
				$this->save(array('Connection' => $item));
			}
		}
		$Ds->commit($this); // ... done
		$this->_cachedStorage = null;
		return true;
	}
	
	function get($profileId) {
		if ($this->_cachedStorage == null) {
			$this->_cachedStorage = array();
			$this->_cachedStorage = array_merge($this->_cachedStorage,
				$this->find('all', array(
						'fields' => array('to_profile_id', 'type', 'value'),
						'conditions' => array('profile_id' => $profileId),
					)
				)
			);
		}
		return $this->_cachedStorage;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// MAYBE!
	// check for
	// - new requests
	// - dropped requests
	// - new connections (like ignores, friends, authes)
	// - removed connections (like ignores, friends, authes)
	// modifiy own data records accordingly
	// return some nice notices to the user
	// THIS SHOULD BE FAST as it could be called by using ajax on a short frequency via a controller 
	function changes($profileId, $date) {
		return "foo";
	}
	
	/*
	$this->Connection->create($this->Connection->find('first', array(
		'fields' => array('id'),
		'conditions' => array(
			'profile_id' => $this->Connection->Profile->getAuthedId($this->Auth->user()),
			'to_profile_id' => $toProfileId,
			'type' => $type,
		)
	)));
	$this->Connection->set(array(
		'profile_id' => $this->Connection->Profile->getAuthedId($this->Auth->user()),
		'to_profile_id' => $toProfileId,
		'type' => $type,
		'value' => 1));
	$this->Connection->save();
	
	*/
	
	
	
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