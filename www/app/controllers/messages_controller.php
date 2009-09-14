<?php
class MessagesController extends AppController {
	
	var $name = 'Messages';
	var $components = array('Honeypotting' => array('formModels' => array('Profile', 'Message')));
	var $helpers = array('Html', 'Form', 'Javascript', 'Honeypot');
	
	function index() {
		$this->redirect(array('action' => 'mailbox', 'unread'));
	}
	
	function mailbox($filter = null) {
		$activeProfileId = $this->Auth->user('active_profile_id');
		switch($filter) {
			case 'inbox':
				$this->set('messagesTitle', __('Inbox', true));
				$conditions = array(
					'NOT' => array('Message.from_profile_id' => $activeProfileId),
					'Message.is_trashed' => 0);
				break;
			case 'unread':
				$this->set('messagesTitle', __('Unread', true));
				$conditions = array(
					'NOT' => array('Message.from_profile_id' => $activeProfileId),
					'Message.is_read'    => 0,
					'Message.is_trashed' => 0);
				break;
			case 'unreplied':
				$this->set('messagesTitle', __('Unreplied', true));
				$conditions = array(
					'NOT' => array('Message.from_profile_id' => $activeProfileId),
					'Message.is_replied' => 0,
					'Message.is_trashed' => 0);
				break;
			case 'read':
				$this->set('messagesTitle', __('Read', true));
				$conditions = array(
					'NOT' => array('Message.from_profile_id' => $activeProfileId),
					'Message.is_read'    => 1,
					'Message.is_trashed' => 0);
				break;
			case 'sent':
				$this->set('messagesTitle', __('Sent', true));
				$conditions = array(
					'Message.from_profile_id' => $activeProfileId,
					'Message.is_trashed' => 0);
				break;
			case 'trash':
				$this->set('messagesTitle', __('Trash', true));
				$conditions = array(
					'Message.is_trashed' => 1);
				break;
			case null:
			default:
				$this->redirect(array('controller' => 'messages', 'action' => 'mailbox', 'unread'));
				break;
		}
		$conditions['Message.profile_id'] = $activeProfileId;
		$this->Message->recursive = 0;
		$this->paginate = array(
			'fields' => array(
				'Message.id',
				'Message.profile_id',
				'Message.from_profile_id',
				'Message.to_profile_id',
				'Message.created',
				'Message.subject',
				'Message.body',
				'Message.is_read',
				'Message.is_replied',
				'Message.is_trashed',
				'ToProfile.nickname',
				'FromProfile.nickname',
			),
			'contain' => array(
				'Profile',
				'ToProfile',
				'FromProfile',
			),
			'conditions' => $conditions,
			'limit' => 3,
		);
		$this->set('filter', $filter);
		$this->set('messages', $this->paginate());
	}
	
	function send($toProfileId = null) {
		if (!$toProfileId or $toProfileId == $this->Auth->user('active_profile_id')
		or !$this->Message->Profile->read('nickname', $toProfileId)) {
			$this->Session->setFlash(__('Invalid profile.', true));
			$this->redirect($this->referer());
		}
		$this->set('toProfile', $this->Message->Profile->data);
		if (!empty($this->data)) {
			$this->Message->create($this->data);
			if ($this->Message->send($this->Auth->user('active_profile_id'), $toProfileId)) {
				$this->Session->setFlash(
					__('Your message has been send to', true) . ' '
						. $this->Message->Profile->data['Profile']['nickname'] . '.');
			} else {
				$this->Session->setFlash(
					__('Your message could not be send, see below.', true));
			}
		}
	}
	
	function reply($id = null) {
		if (!$id or !$this->Message->read(
				array('from_profile_id', 'created', 'subject', 'body', 'created'), $id)) {
			$this->Session->setFlash(__('Invalid message.', true));
			$this->redirect($this->referer());
		}
		if ($this->Auth->user('active_profile_id') ==
			$this->Message->data['Message']['from_profile_id']) {
				$this->Session->setFlash(__('Invalid message.', true));
		}
		$toProfileData = $this->Message->Profile->read(null,
			$this->Message->data['Message']['from_profile_id']);
		$this->set('toProfile', $toProfileData);
		$this->set('message', $this->Message->data);
		if (!empty($this->data)) {
			$this->Message->create($this->data);
			if ($this->Message->send($this->Auth->user('active_profile_id'),
					$toProfileData['Profile']['id'])) {
				$this->Session->setFlash(
					__('Your message has been send to', true) . ' '
						. $toProfileData['Profile']['nickname']);
			} else {
				$this->Session->setFlash(
					__('Your message could not be send, see below.', true));
			}
		} else {
			$this->data['Message']['subject'] = __('Re', true) . ': '
				. $this->Message->data['Message']['subject'];
			$this->data['Message']['body'] = "\n\n \n" . String::insert(
					__('On :date, at :time, :name wrote', true),
					array(
						'date' => substr($this->Message->data['Message']['created'], 0, -9),
						'time' => substr($this->Message->data['Message']['created'], 11, -3),
						'name' => $toProfileData['Profile']['nickname']))
				.  ":\n> " . str_replace("\n", "\n> ", $this->Message->data['Message']['body']);
		}
		$this->set('toProfileNicktname',$toProfileData['Profile']['nickname']);
	}
	
	function trash($id = null) {
		
	}
	
	function restore($id = null) {
		
	}
	
	function remove($id = null) {
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