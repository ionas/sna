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
		$this->Profile->recursive = 0;
		$this->set('profiles', $this->paginate());
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Profile.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('profile', $this->Profile->read(null, $id));
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
	
}
?>