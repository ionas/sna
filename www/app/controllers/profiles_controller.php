<?php
class ProfilesController extends AppController {
	
	var $name = 'Profiles';
	var $helpers = array('Html', 'Form', 'Javascript');
	
	function self() {
		// TODO for redirecting to self profile without supplying ID
	}
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('view'));
	}
	
	function search() {
		// TODO
		$this->set('profiles', $this->paginate());
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Profile.', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->shout_to($id);
		}
		$this->set('profile', $this->Profile->read(null, $id));
		$this->set('shouts', $this->shouts($id));
	}
	
	function edit() {
		$this->layout = 'settings';
		// TODO, on first edit, default $this->data hidden to 0 
		$id = $this->Profile->getAuthedId($this->Auth->user());
		if (!empty($this->data)) {
			$this->data['Profile']['user_id'] = $this->Auth->user('id');
			if ($this->Profile->save($this->data, true, array(
						'is_hidden', 'nickname', 'birthday', 'location'))) {
							debug($this->data);
				// debug('filename: ' . $this->Attachment->upload($this->data['Avatar']['image']));
				$this->Session->setFlash(__('The Profile has been saved', true));
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The Profile could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Profile->read(null, $id);
		}
		$this->set(compact('users'));
	}
	
	function auth_shouts() {
		// TODO
	}
	
	function auth_messages() {
		// TODO
	}
	
	function buddy() {
		// TODO
	}
	
	function ignore() {
		// TODO
	}
	
	// Below: integrated shouts actions, because of integrated views (profile view with shouts)
	function shout_to($toProfileId = null) {
		$shouted = false;
		if($this->Auth->isAuthorized() and $toProfileId != null and !empty($this->data)) {
			$this->Profile->Shout->create();
			$this->Profile->Shout->set(array(
				'user_id' => $this->Auth->user('id'),
				'profile_id' => $toProfileId,
				'from_profile_id' => $this->Profile->getAuthedId($this->Auth->user())));
			if ($this->Profile->Shout->save($this->data, true,
					array('user_id', 'profile_id', 'from_profile_id', 'body'))) {
				$this->Session->setFlash(__('The Shout has been saved', true));
				$shouted = true;
			} else {
				$this->Session->setFlash(__('The Shout could not be saved. Please, try again.',
					true));
			}
		}
		if ($shouted) {
			unset($this->data['Shout']);
			if ($this->action == 'shout_to') {
				$this->redirect(array('action' => 'view', $toProfileId, '#' => 'shouts'));
			}
		}
	}
	
	function shouts($profileId) {
		$numberOfShoutsPerPage = 3;
		if (!$profileId) {
			$this->Session->setFlash(__('Invalid Profile.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->paginate = array(
			'fields' => array(
				'Profile.id',
				'Shout.id',
				'Shout.created',
				'Shout.body',
				'Shout.is_hidden',
				'Shout.is_deleted',
				'Shout.is_deleted_by_shouter',
				'Shout.from_profile_id',
				'FromProfile.id',
				'FromProfile.nickname',
			),
			'joins' => array(
				array(
					'type' => 'LEFT', 
					'table' => $this->Profile->Shout->useTable,
					'alias' => $this->Profile->Shout->alias,
					'foreignKey' => $this->Profile->Shout->primaryKey,
					'conditions' => $this->Profile->escapeField($this->Profile->primaryKey) . ' = '
						. $this->Profile->Shout->escapeField('profile_id'),
				),
				array(
					'type' => 'LEFT', 
					'table' => $this->Profile->Shout->FromProfile->useTable,
					'alias' => $this->Profile->Shout->FromProfile->alias,
					'foreignKey' => $this->Profile->Shout->FromProfile->primaryKey,
					'conditions' => $this->Profile->Shout->escapeField('profile_id') . ' = '
						. $this->Profile->Shout->FromProfile->escapeField(
							$this->Profile->Shout->FromProfile->primaryKey),
				),
			),
			'conditions' => array(
				'Profile.id' => $profileId,
			),
			'order' => 'Shout.created DESC',
			'limit' => $numberOfShoutsPerPage,
		);
		$shouts = $this->paginate();
		$this->set('shouts', $shouts);
		return $shouts;
	}
	
	function toggle_shout() {
		// TODO
	}
	
	function delete_shout() {
		// TODO
	}
	
}
?>