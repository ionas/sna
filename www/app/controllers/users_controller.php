<?php
class UsersController extends AppController {
	
	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	
	function beforeFilter() {
		parent::beforeFilter();
		// $this->Auth->allow(array('register', 'activate'));
	}
	
	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action' => 'index'));
		}
		// given
		if(strlen($id) < 36) {
			$user = $this->User->find('first', array(
					'User.id',
					'conditions' => array('User.nickname' => $id),
				)
			);
			$id = $user['User']['id'];
		}
		$this->set('user', $this->User->read(null, $id));
	}
	
	function register() {
		$this->Auth->authenticate = $this->User;
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data, true, array('has_accepted_tos', 'username', 'password', 'nickname', 'email'))) {
				$this->Session->setFlash(__('Your registration has been successful. However, you will still need to activate your user account.', true));
				$this->redirect(array('action' => 'activate'));
			} else {
				unset($this->data['User']['password']);
				unset($this->data['User']['password_confirmation']);
				$this->Session->setFlash(__('Your registration could not be completed, see below.', true));
			}
		}
	}
	
	function activate($activationKey = null) {
		if (!empty($this->data)) {
			if($this->User->activate($this->data)) {
				$this->Session->setFlash(__('Your User Account has been activated. Thank you.', true));
				$this->redirect(array('action' => 'index'));
			}
		}
		if($activationKey) {
			$this->data['User']['activation_key'] = $activationKey;
		}
	}
	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function add_buddy() {
		
	}

	function ignore_user() {
		
	}

	function change_email() {
		
	}
	
	function change_password() {
		
	}
	
	function hide() {
		
	}

	/*
	function home() {
		$authedUser = $this->Auth->user();
		$landingPage = $this->User->UserOption->get($authedUser['User']['id'], array('landingPage'));
		if(!empty($landingPage)) {
			$this->redirect(Func::toRoute($landingPage));
		} else {
			$this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
		}
	}
	*/
	
	function status() {
		debug($this->Auth->user());
		exit;
	}

	function login() {
		$this->Auth->loginRedirect = array('controller'=>'users', 'action'=>'index');
	}
	
	function logout() {
		$authedUser = $this->Auth->user();
		$this->Session->setFlash(
			__('Goodbye', true) . ' &lt;' . $authedUser['User']['username'] . '&gt; ...'
		);
		$this->redirect($this->Auth->logout());
	}
	
}
?>