<?php
class Connection extends AppModel {

	var $name = 'Connection';
	var $validate = array(
		'profile_id' => array('notempty'),
		'profile_target_id' => array('notempty'),
		'profile_is_ignore' => array('numeric'),
		'profile_is_ignore_requested' => array('numeric'),
		'profile_is_friend' => array('numeric'),
		'profile_is_friend_requested' => array('numeric'),
		'profile_is_authed_for_messages' => array('numeric'),
		'profile_is_authed_for_messages_requested' => array('numeric'),
		'profile_is_authed_for_shouts' => array('numeric'),
		'profile_is_authed_for_shouts_requested' => array('numeric')
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
	
	function set($profileId, $targetProfileId, $data) {
		$foo = $this->find('count', array('fields' => array('Connection.id'),
			'conditions' => array(
				'Connection.profile_id' => $profileId,
				'Connection.to_profile_id' => $targetProfileId)));
		var_dump($foo);
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