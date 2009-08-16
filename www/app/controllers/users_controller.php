<?php
class UsersController extends AppController {
	
	var $name = 'Users';
	var $components = array('Honeypotting' => array('formModels' => array('User', 'UserOption')));
	var $helpers = array('Html', 'Form', 'Honeypot');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->__authAutoRedirectFixes();
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
		if($this->action == 'login') {
			$this->Auth->autoRedirect = false;
		}
	}
	
	function view($id = null) {
			if (!$id) {
				$this->Session->setFlash(__('Invalid User.', true));
				$this->redirect(array('action' => 'index'));
			}
			// No UUID => try finding user by nickname
			if (strlen($id) != 36) {
				$user = $this->User->find('first', array(
						'User.id',
						'conditions' => array('User.nickname' => $id),
					)
				);
				$id = $user['User']['id'];
			}
			if($id == $this->Auth->user('id')) {
				$this->set('user', $this->User->read(null, $id));
			} else {
				$this->Session->setFlash(
					__('You may only access your own User Account.', true));
				// TODO Routing bugs again
				// $this->redirect(array('home'));
			}
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
			$termsOfServiceRedirect = $this->Session->read('TermsOfService.redirect');
			$this->Session->del('TermsOfService.redirect');
			if($termsOfServiceRedirect != null) {
				$this->redirect($termsOfServiceRedirect);
			} else {
				$this->redirect(array('action' => 'home'));
			}
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
			$this->redirect($landingPage);
			
		} else {
			$this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
		}
	}
	
	function login() {
		$this->set('nicename', $this->Auth->user('nicename'));
		if($this->Auth->isAuthorized() === true) {
			$this->User->updateLastLogin($this->Auth->user());
			if(!empty($this->data)) {
				if($this->Session->read('Auth.redirect') == null) {
					$this->redirect(array('action' => 'home'));
				} else {
					$this->redirect($this->Session->read('Auth.redirect'));
				}
			}
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
	
	function __authAutoRedirectFixes() {
		$sessionAuthRedirect = $this->Session->read('Auth.redirect');
		if(stripos($sessionAuthRedirect, '/users/activate') === 0
		OR stripos($sessionAuthRedirect, '/users/new_password') === 0) {
			$this->Session->write('Auth.redirect', '/users/home');
		}
		unset($sessionAuthRedirect);
	}
	
}
?>