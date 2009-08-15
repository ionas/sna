<?php
class UsersController extends AppController {
	
	var $name = 'Users';
	var $components = array('Honeypotting' => array('formModels' => array('User', 'UserOption')));
	var $helpers = array('Html', 'Form', 'Honeypot');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('login', 'register', 'activate', 'forgot_password', 'new_password', 'home'));
		// Active users may login
		$this->Auth->userScope = array(
			'User.activation_key' => '',
			'User.is_deleted' => false,
			'User.is_disabled' => false,
		);
		if ($this->action == 'register'
		OR $this->action == 'change_password'
		OR $this->action == 'new_password') {
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
		// no UUID, try finding user by nickname
		if (strlen($id) != 36) {
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
		$this->Auth->logout();
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data, true, array(
						'has_accepted_tos', 'username', 'password', 'nickname', 'email'))) {
				$this->Session->setFlash(
					__('Your registration has been successful. However, you will still need to activate your user account.', true));
				$this->redirect(array('action' => 'activate'));
			} else {
				unset($this->data['User']['password']);
				unset($this->data['User']['password_confirmation']);
				$this->Session->setFlash(
					__('Your registration could not be completed, see below.', true));
			}
		}
	}
	
	function activate($activationKey = null) {
		$this->Auth->logout();
		if (!empty($this->data)) {
			if ($this->User->activate($this->data)) {
				$this->Session->setFlash(
					__('Your User Account has been activated. You may now login.', true));
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(
					__('The User Account Activation failed. Please correct your Activation Key and try again.', true));
			}
		}
		if ($activationKey) {
			$this->data['User']['activation_key'] = $activationKey;
		}
	}
	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User Accuont ID.', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('Your User Account has been updated.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The User Account could not be updated. Please, try again.', true));
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
			$this->Session->setFlash(
				String::insert(__('User Account :nicename removed.', true),
					array('nicename' => $this->Auth->user('nicename'))));
			$this->redirect($this->Auth->logout());
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
	
	function forgot_password() {
		$this->Auth->logout();
		if(!empty($this->data)) {
			if($this->User->sendPasswordInstructions($this->data) == true) {
				$this->Session->setFlash(__('You should have recieved information on how to restore your password per email.', true));
				$this->redirect(array('action' => 'home'));
			} else {
				$this->Session->setFlash(__('Password retrival information could not be send, try again.', true));
			}
		} else {
			if($this->referer() != $this->here) {
				$this->Session->setFlash(__("Enter your Account's login name or Email address.", true));
			}
		}
	}
	
	function new_password($passwordResetKey = null) {
		if(!empty($this->data)) {
			if ($this->User->saveNewPassword($this->data)) {
				$this->Auth->logout();
				$this->Session->setFlash(__('Your new password has been set.', true));
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('Your new password could not be set.', true));
				unset($this->data['User']['password']);
				unset($this->data['User']['password_confirmation']);
			}
		}
		if ($passwordResetKey) {
			$this->data['User']['password_reset_key'] = $passwordResetKey;
		}
	}
	
	function change_password() {
		if(!empty($this->data)) {
			if ($this->User->changePassword($this->Auth->user(), $this->data)) {
				$this->Auth->logout();
				$this->Session->setFlash(__('Your new password has been set.', true));
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('Your new password could not be set.', true));
				unset($this->data['User']['password']);
				unset($this->data['User']['password_confirmation']);
				unset($this->data['User']['password_current']);
			}
		}
	}
	
	function change_email() {
		// TODO
	}

	function hide() {
		// TODO
	}
	
	function home() {
		$landingPage = $this->User->UserOption->get($this->Auth->user(), array('landingPage'));
		if (!empty($landingPage)) {
			debug(Router::parse($landingPage));
			// die();
			// $this->redirect(Router::parse($landingPage));
			
			$foo = Array
			(
			    'pass' => Array
			        (
			            '4a648ce4-08a4-46e2-91f8-024a8784ca84'
			        ),

			    'named' => Array
			        (
			        ),

			    'controller' => 'users',
			    'action' => 'view',
			    'plugin' => '',
	            '4a648ce4-08a4-46e2-91f8-024a8784ca84'
			);
			debug($foo);
			$this->redirect($foo, $foo['pass'][0]);
			
		} else {
			$this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
		}
	}
	
	function login() {
		$this->set('nicename', $this->Auth->user('nicename'));
		if($this->Auth->isAuthorized() == true) {
			$this->User->updateLastLogin($this->Auth->user());
		}
	}
	
	function logout() {
		if($this->Auth->isAuthorized() == true) {
			$this->Session->setFlash(
				__('Goodbye', true) . ' ' . $this->Auth->user('nicename') . '...');
			$this->User->updateLastLogin($this->Auth->user());
		}
		$this->Auth->logout();
		$this->redirect(array('action' => 'home'));
	}
	
	function make_buddies() {
		
	}
	
	function ignore_user() {
		
	}
	
}
?>