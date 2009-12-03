<?php
class ConnectionsController extends AppController {
	
	var $name = 'Connections';
	var $helpers = array('Html', 'Form');
	
	function request($type = null, $toProfileId = null) {
		$error = false;
		// TODO fetch $toProfileId from profiles, check if it actually exists
		if ($type == null) {
			$error = true;
			$this->Session->setFlash(___('Invalid connection type.'));
		} else if ($toProfileId == null) {
			$error = true;
			$this->Session->setFlash(___('Invalid profile id.'));
		} else if ($toProfileId == ($profileId = $this->Profile->getAuthedId($this->Auth->user()))) {
			$error = true;
			$this->Session->setFlash(sprintf(
				___('You request connection %s to yourself.'), __d('default', $type, true)));
		}
		if (!$error) {
			$this->Connection->saveOrRenewRequest(array(
				'profile_id' => $profileId,
				'to_profile_id' => $toProfileId,
				'type' => $type,
			));
		}
		$this->render('empty');
	}
	
	function respond($id) {
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function index() {
		$this->Connection->recursive = 0;
		$this->set('connections', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Connection.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('connection', $this->Connection->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Connection->create();
			if ($this->Connection->save($this->data)) {
				$this->Session->setFlash(__('The Connection has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Connection could not be saved. Please, try again.', true));
			}
		}
		$profiles = $this->Connection->Profile->find('list');
		$toProfiles = $this->Connection->ToProfile->find('list');
		$this->set(compact('profiles', 'toProfiles'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Connection', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Connection->save($this->data)) {
				$this->Session->setFlash(__('The Connection has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Connection could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Connection->read(null, $id);
		}
		$profiles = $this->Connection->Profile->find('list');
		$toProfiles = $this->Connection->ToProfile->find('list');
		$this->set(compact('profiles','toProfiles'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Connection', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Connection->del($id)) {
			$this->Session->setFlash(__('Connection deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>