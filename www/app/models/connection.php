<?php
class Connection extends AppModel {
	
	var $name = 'Connection';
	
	var $validate = array(
		'created' => array('date'),
		'modified' => array('date'),
		'profile_a_id' => array('notempty'),
		'profile_b_id' => array('notempty'),
		'profile_a_is_ignore' => array('boolean'),
		'profile_b_is_ignore' => array('boolean'),
		'profile_a_is_friend' => array('boolean'),
		'profile_b_is_friend' => array('boolean'),
		'profile_a_is_friend_requested' => array('boolean'),
		'profile_b_is_friend_requested' => array('boolean'),
		'profile_a_is_authed_for_messages' => array('boolean'),
		'profile_b_is_authed_for_messages' => array('boolean'),
		'profile_a_is_authed_for_messages_requested' => array('boolean'),
		'profile_b_is_authed_for_messages_requested' => array('boolean'),
		'profile_a_is_authed_for_shouts' => array('boolean'),
		'profile_b_is_authed_for_shouts' => array('boolean'),
		'profile_a_is_authed_for_shouts_requested' => array('boolean'),
		'profile_b_is_authed_for_shouts_requested' => array('boolean'),
	);
	
	var $belongsTo = array(
		'ProfileA' => array(
			'className' => 'Profile',
			'foreignKey' => 'profile_a_id',
		),
		'ProfileB' => array(
			'className' => 'Profile',
			'foreignKey' => 'profile_b_id',
		),
	);
	
	// TODO:
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