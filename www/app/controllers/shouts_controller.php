<?php
class ShoutsController extends AppController {

	var $name = 'Shouts';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Shout->recursive = 0;
		$this->set('shouts', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Shout.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('shout', $this->Shout->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Shout->create();
			if ($this->Shout->save($this->data)) {
				$this->Session->setFlash(__('The Shout has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Shout could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Shout->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Shout', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Shout->save($this->data)) {
				$this->Session->setFlash(__('The Shout has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Shout could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Shout->read(null, $id);
		}
		$users = $this->Shout->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Shout', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Shout->del($id)) {
			$this->Session->setFlash(__('Shout deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>