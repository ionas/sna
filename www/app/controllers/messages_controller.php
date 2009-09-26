<?php
class MessagesController extends AppController {
	
	var $name = 'Messages';
	var $components = array('Honeypotting' => array('formModels' => array('Profile', 'Message')));
	var $helpers = array('Html', 'Form', 'Javascript', 'Honeypot');
	
	function index() {
		$this->redirect(array('action' => 'mailbox', 'unread'));
	}
	
	function mailbox($filter = null) {
		$activeProfileId = $this->Message->Profile->getAuthedId($this->Auth->user());
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
			'order' => 'created DESC',
			'limit' => 3,
		);
		$this->set('filter', $filter);
		$this->set('messages', $this->paginate());
	}
	
	function send($toProfileId = null) {
		if (!$toProfileId or $toProfileId == $this->Message->Profile->getAuthedId(
				$this->Auth->user())
		or !$this->Message->Profile->read('nickname', $toProfileId)) {
			$this->Session->setFlash(__('Invalid profile.', true));
			$this->Breadcrume->redirectBack();
		}
		$this->set('toProfile', $this->Message->Profile->data);
		if (!empty($this->data)) {
			$this->Message->create($this->data);
			if ($this->Message->send($toProfileId, $toProfileId)) {
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
		// Check message ID
		if (!$id or !$this->Message->read(
				array('from_profile_id', 'created', 'subject', 'body', 'created'), $id)) {
			$this->Session->setFlash(__('Invalid message.', true));
			$this->Breadcrume->redirectBack();
		}
		// Check auth
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
			if ($this->Message->send($this->Message->Profile->getAuthedId($this->Auth->user()),
					$toProfileData['Profile']['id'])) {
				$this->Session->setFlash(
					__('Your message has been send to', true) . ' '
						. $toProfileData['Profile']['nickname']);
				$this->Breadcrume->redirectBack();
			} else {
				$this->Session->setFlash(
					__('Your message could not be send, see below.', true));
			}
			$this->data['Message']['body'] = "\n" . $this->data['Message']['body']; 
			/* HACKFIX:
			* Required because of a bug in either app or cake
			* Reason: Removes first "/n" from the data each time.
			*/
		} else {
			$this->data['Message']['subject'] = __('Re', true) . ': '
				. $this->Message->data['Message']['subject'];
			$this->data['Message']['body'] = "\n\n\n" . String::insert(
					__('On :date, at :time, :name wrote', true),
					array(
						'date' => substr($this->Message->data['Message']['created'], 0, -9),
						'time' => substr($this->Message->data['Message']['created'], 11, -3),
						'name' => $toProfileData['Profile']['nickname']))
				.  ":\n> " . str_replace("\n", "\n> ", $this->Message->data['Message']['body']);
		}
		$this->set('toProfileNicktname', $toProfileData['Profile']['nickname']);
	}
	
	function trash($id = null) {
		if ($this->Message->saveFieldIfExists($id, 'is_trashed', 1)) {
			$this->Session->setFlash(__('Message has been trashed.', true));
		} else {
			$this->Session->setFlash(__('Message could not be trashed.', true));
		}
		$this->Breadcrume->redirectBack();
	}
	
	function restore($id = null) {
		if ($this->Message->saveFieldIfExists($id, 'is_trashed', 0)) {
			$this->Session->setFlash(__('Message has been restored.', true));
		} else {
			$this->Session->setFlash(__('Message could not be restored.', true));
		}
		$this->Breadcrume->redirectBack();
	}
	
}
?>