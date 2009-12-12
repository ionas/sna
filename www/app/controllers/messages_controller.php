<?php
class MessagesController extends AppController {
	
	var $name = 'Messages';
	
	function beforeFilter() {
		parent::beforeFilter();
		// SecurityComponent setup
		$this->Security->requirePost('delete', 'trash', 'restore');
		if(!empty($this->data['Message']['body'])) {
			$this->Security->requirePut('send', 'reply');
		}
	}
	
	function index() {
		$this->redirect(array('action' => 'mailbox', 'unread'));
	}
	
	function mailbox($filter = null) {
		$authedProfileId = $this->Message->Profile->getAuthedId($this->Auth->user());
		switch($filter) {
			case 'inbox':
				$this->set('messagesTitle', __('Inbox', true));
				$conditions = array(
					'Message.to_profile_id' => $authedProfileId,
					'Message.is_trashed' => 0);
				break;
			case 'unread':
				$this->set('messagesTitle', __('Unread', true));
				$conditions = array(
					'Message.to_profile_id' => $authedProfileId,
					'Message.is_read'    => 0,
					'Message.is_trashed' => 0);
				break;
			case 'unreplied':
				$this->set('messagesTitle', __('Unreplied', true));
				$conditions = array(
					'Message.to_profile_id' => $authedProfileId,
					'Message.is_replied' => 0,
					'Message.is_trashed' => 0);
				break;
			case 'read':
				$this->set('messagesTitle', __('Read', true));
				$conditions = array(
					'Message.to_profile_id' => $authedProfileId,
					'Message.is_read'    => 1,
					'Message.is_trashed' => 0);
				break;
			case 'sent':
				$this->set('messagesTitle', __('Sent', true));
				$conditions = array(
					'Message.from_profile_id' => $authedProfileId,
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
		$conditions['Message.profile_id'] = $authedProfileId;
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
			'limit' => 5,
		);
		$this->set('filter', $filter);
		$this->set('messages', $this->paginate());
	}
	
	function send($toProfileId = null) {
		if (!$toProfileId or $toProfileId == $this->Message->Profile->getAuthedId(
				$this->Auth->user())
		or !$this->Message->Profile->read('nickname', $toProfileId)) {
			$this->Session->setFlash(__('Invalid profile.', true));
			$this->redirect($this->here);
		}
		$this->set('toProfile', $this->Message->Profile->data);
		if (!empty($this->data['Message']['body'])) {
			$this->Message->create($this->data);
			if ($this->Message->send($this->Message->Profile->getAuthedId($this->Auth->user()),
					$toProfileId)
			) {
				$this->Session->setFlash(___('Your message has been send to') . ' '
					. $this->Message->Profile->data['Profile']['nickname'] . '.', 'flashes/success');
				$this->redirect(array('action' => 'mailbox', 'sent'));
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
			$this->redirect($this->here);
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
		if (!empty($this->data['Message']['body'])) {
			$this->Message->create($this->data);
			if ($this->Message->reply($this->Message->Profile->getAuthedId($this->Auth->user()),
					$toProfileData['Profile']['id'])) {
				$this->Session->setFlash(
					__('Your message has been send to', true) . ' '
						. $toProfileData['Profile']['nickname']);
				$this->redirect(array('action' => 'mailbox', 'sent'));
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
		$this->_toggle_trash($id, 1);
		$this->redirect($this->referer());
	}
	
	function restore($id = null) {
		$this->_toggle_trash($id, 0);
		$this->redirect(array('action' => 'mailbox', 'trash'));
	}
	
	function _toggle_trash($id, $flag) {
		$existance = $this->Message->getFieldIfExists($id, 'is_trashed');
		if ($existance !== false && $existance == 1) {
			$impossibility = __('Message not in Trash.', true);
			$success = __('Message has been restored.', true);
			$failure = __('Message could not berestored.', true);
		} else if ($existance !== false && $existance == 0) {
			$impossibility = __('Message already in Trash.', true);
			$success = __('Message has been trashed.', true);
			$failure = __('Message could not be trashed.', true);
		}
		if ($existance !== false && $existance == $flag) {
			$this->Session->setFlash($impossibility);
		} else if ($existance !== false) {
			$this->Message->id = $id;
			if($this->Message->saveField('is_trashed', $flag)) {
				$this->Session->setFlash($success, 'flashes/success');
			} else {
				$this->Session->setFlash($failure);
			}
		}
	}
	
}
?>