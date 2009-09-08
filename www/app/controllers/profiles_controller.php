<?php
class ProfilesController extends AppController {
	
	var $name = 'Profiles';
	var $helpers = array('Html', 'Form', 'Javascript');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('view'));
	}
	
	function index() {
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
	
	function add() {
		if($profileData = $this->Profile->profileExists($this->Auth->user())) {
			$this->redirect(array('action' => 'edit', $profileData['Profile']['id']));
		}
		if (!empty($this->data)) {
			$this->data['Profile']['user_id'] = $this->Auth->user('id');
			$this->Profile->create();
			if ($this->Profile->save($this->data, true, array(
						'user_id', 'is_hidden', 'nickname', 'birthday', 'location'))) {
				$this->Session->setFlash(__('The Profile has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Profile could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Profile->User->find('list');
		$this->set(compact('users'));
	}
	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Profile', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Profile']['user_id'] = $this->Auth->user('id');
			if ($this->Profile->save($this->data, true, array(
						'is_hidden', 'nickname', 'birthday', 'location'))) {
				$this->Session->setFlash(__('The Profile has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Profile could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Profile->read(null, $id);
		}
		$this->set(compact('users'));
	}
	
	function delete($id = null) {
		$id = $this->getActiveUser();
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Profile', true));
		}
		if ($this->Profile->del($id)) {
			$this->Session->setFlash(__('Profile deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
}
?>