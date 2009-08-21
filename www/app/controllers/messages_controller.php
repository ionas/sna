<?php
class MessagesController extends AppController {
	
	var $name = 'Messages';
	var $helpers = array('Html', 'Form');
	
	function index() {
		$this->Message->recursive = 1;
		if(isset($this->passedArgs['message_filter'])) {
			$user_id        = $this->currentUser();
			$message_filter = $this->passedArgs['message_filter']; 
			switch($message_filter) {
				
				case 'recieved':
					$this->set('message_center_title', __('Recieved', true));
					$this->set('messages', $this->paginate(array('User.id' => $user_id,
					                                             'NOT' => array('Message.sender_user_id' => $user_id),
					                                             'Message.is_trashed' => 0)));
					break;
					
				case 'unread':
					$this->set('message_center_title', __('Unread', true));
					$this->set('messages', $this->paginate(array('User.id' => $user_id,
					                                             'NOT' => array('Message.sender_user_id' => $user_id),
					                                             'Message.is_read'    => 0,
					                                             'Message.is_trashed' => 0)));
					break;
					
				case 'unreplyed':
					$this->set('message_center_title', __('Unreplyed', true));
					$this->set('messages', $this->paginate(array('User.id' => $user_id,
					                                             'NOT' => array('Message.sender_user_id' => $user_id),
					                                             'Message.is_replyed' => 0,
					                                             'Message.is_trashed' => 0)));
					break;
					
				case 'read':	
					$this->set('message_center_title', __('Read', true));
					$this->set('messages', $this->paginate(array('User.id' => $user_id,
					                                             'NOT' => array('Message.sender_user_id' => $user_id),
					                                             'Message.is_read'    => 1,
					                                             'Message.is_trashed' => 0)));
					break;
					
				case 'send':
					$this->set('message_center_title', __('Send', true));
					$this->set('messages', $this->paginate(array('User.id' => $user_id,
					                                             'Message.sender_user_id' => $user_id,
					                                             'Message.is_trashed' => 0)));
					break;
					
				case 'trashed':
					$this->set('message_center_title', __('Trashed', true));
					$this->set('messages', $this->paginate(array('User.id' => $user_id,
					                                             'Message.is_trashed' => 1)));
					break;
					
				default:
					$this->redirect(array('controller' => 'messages', 'action' => 'index/' . $user_id . '/unread'));
			}
		} else {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect('/');
		}
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Message.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('message', $this->Message->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Message->create();
			if ($this->Message->save($this->data)) {
				$this->Session->setFlash(__('The Message has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Message could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Message->User->find('list');
		$profiles = $this->Message->Profile->find('list');
		$fromProfiles = $this->Message->FromProfile->find('list');
		$this->set(compact('users', 'profiles', 'fromProfiles'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Message', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Message->save($this->data)) {
				$this->Session->setFlash(__('The Message has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Message could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Message->read(null, $id);
		}
		$users = $this->Message->User->find('list');
		$profiles = $this->Message->Profile->find('list');
		$fromProfiles = $this->Message->FromProfile->find('list');
		$this->set(compact('users','profiles','fromProfiles'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Message', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Message->del($id)) {
			$this->Session->setFlash(__('Message deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>