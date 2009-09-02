<?php
class MessagesController extends AppController {
	
	var $name = 'Messages';
	var $components = array('Honeypotting' => array('formModels' => array('Profile', 'Message')));
	var $helpers = array('Html', 'Form', 'Javascript', 'Honeypot');
	
	function index() {
		$this->redirect(array('action' => 'mailbox', 'unread'));
	}
	
	function mailbox($filter = null) {
		$profileData = $this->getCurrentUser();
		$profileId = $profileData['User']['current_profile_id'];
		$this->Message->recursive = 2;
		switch($filter) {
			case 'recieved':
				$this->set('messagesTitle', __('Recieved', true));
				$conditions = array(
					'Profile.id' => $profileId,
					'NOT' => array('Message.from_profile_id' => $profileId),
					'Message.is_trashed' => 0);
				break;
			case 'unread':
				$this->set('messagesTitle', __('Unread', true));
				$conditions = array(
					'Profile.id' => $profileId,
					'NOT' => array('Message.from_profile_id' => $profileId),
					'Message.is_read'    => 0,
					'Message.is_trashed' => 0);
				break;
			case 'unreplied':
				$this->set('messagesTitle', __('Unreplied', true));
				$conditions = array(
					'Profile.id' => $profileId,
					'NOT' => array('Message.from_profile_id' => $profileId),
					'Message.is_replied' => 0,
					'Message.is_trashed' => 0);
				break;
			case 'read':
				$this->set('messagesTitle', __('Read', true));
				$conditions = array(
					'Profile.id' => $profileId,
					'NOT' => array('Message.from_profile_id' => $profileId),
					'Message.is_read'    => 1,
					'Message.is_trashed' => 0);
				break;
			case 'sent':
				$this->set('messagesTitle', __('Sent', true));
				$conditions = array(
					'Profile.id' => $profileId,
					'Message.from_profile_id' => $profileId,
					'Message.is_trashed' => 0);
				break;
			case 'trashed':
				$this->set('messagesTitle', __('Trashed', true));
				$conditions = array(
					'Profile.id' => $profileId,
					'Message.is_trashed' => 1);
				break;
			case null:
			default:
				$this->redirect(array('controller' => 'messages', 'action' => 'mailbox', 'unread'));
				break;
		}
		$this->paginate = array(
			'fields' => array(
				'Message.id',
				'Message.profile_id',
				'Message.from_profile_id',
				'Message.created',
				'Message.subject',
				'Message.body',
				'Message.is_read',
				'Message.is_replied',
				'Message.is_trashed',
			),
			'conditions' => $conditions,
			'limit' => 1,
		);
		$this->set('filter', $filter);
		$this->set('messages', $this->paginate());
		
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