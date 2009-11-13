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
	
	var $types = array(
		'ignore',
		'mutual_friendship',
		'messaging_authentication',
		'shouting_authentication',
	);
	
	function establish($data = array()) {
		$conditions = $data;
		foreach($data as $index => $item) {
			unset($item['value']);
			$conditions[$index] = $item;
		}
		$storedData = $this->find('all', array(
			'fields' => array('id', 'profile_id', 'to_profile_id', 'type'),
			'conditions' => array('or' => $conditions),
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
		$deleteIds = array();
		// start transaction
		$Db = $this->getDataSource();
		$Db->begin($this);
		foreach ($data as $index => $item) {
			if (isset($item['id'])) {
				$this->id = $item['id'];
			} else {
				unset($this->id);
			}
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
		$Db->commit($this);
		return true;
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
}
?>