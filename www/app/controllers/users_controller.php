<?php
class UsersController extends AppController {
	
	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('register', 'activate', 'logout', 'login'));
		// Active users may login
		$this->Auth->userScope = array(
			'User.activation_key' => '',
			'User.is_deleted' => false,
			'User.is_disabled' => false,
		);
		if($this->action == 'register') {
			// Use User::hashPasswords instead Auth::hashPasswords
			$this->Auth->authenticate = $this->User;
		}
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
		if (strlen($id) < 36) {
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
			if ($this->User->activate($this->data)) {
				$this->Session->setFlash(__('Your User Account has been activated. You may now login.', true));
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('The User Account Activation failed. Please correct your Activation Key and try again.', true));
			}
		}
		if ($activationKey) {
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
	
	function terms_of_service() {
		if (!empty($this->params['form']['decline'])) {
			$this->User->setTos($this->Auth->user(), 0);
			$this->Session->setFlash(__('You have declined the Terms of Service.', true));
			$this->Session->write('Auth', $this->User->find('first',
					array('conditions' => array('id' => $this->Auth->user('id')))));
			$this->redirect('/');
		} else if (!empty($this->params['form']['accept'])) {
			$this->User->setTos($this->Auth->user(), 1);
			$this->Session->setFlash(__('You have accepted the Terms of Service.', true));
			$this->Session->write('Auth', $this->User->find('first',
					array('conditions' => array('id' => $this->Auth->user('id')))));
			$this->redirect($this->Session->read('TermsOfService.redirect'));
		}
		$this->set('hasAcceptedTos', $this->Auth->user('has_accepted_tos'));
		$this->set('termsOfService', $this->requestAction('/pages/public/terms_of_service'));
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
	
	function home() {
		$landingPage = $this->User->UserOption->get($this->Auth->user('id'), array('landingPage'));
		if (!empty($landingPage)) {
			$this->redirect(Func::toRoute($landingPage));
		} else {
			$this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
		}
	}
	
	function status() {
		debug($this->Auth->user());
	}
	
	function login() {
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