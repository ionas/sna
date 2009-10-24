<?php
class UsersController extends AppController {
	
	var $name = 'Users';
	var $components = array('Honeypotting' => array('formModels' => array('User', 'Option')));
	var $helpers = array('Html', 'Form', 'Javascript', 'Honeypot');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->__authAutoRedirectFixes();
		// Active users may login
		$this->Auth->userScope = array(
			'User.activation_key' => '',
			'User.is_deleted' => false,
			'User.is_disabled' => false,
		);
		// Public actions
		$this->Auth->allow(array('login', 'register', 'activate', 'forgot_password', 'new_password', 'home'));
		if ($this->action == 'register'
		OR $this->action == 'change_password'
		OR $this->action == 'new_password') {
			// Use User::hashPasswords instead Auth::hashPasswords
			$this->Auth->authenticate = $this->User;
		}
		// Disable autoRedirect for login page
		if ($this->action == 'login') {
			$this->Auth->autoRedirect = false;
		}
	}
	
	function register() {
		$this->layout = 'visitor';
		$this->Auth->logout();
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data, true, array(
						'has_accepted_tos', 'username', 'password', 'email'))) {
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
		$this->layout = 'visitor';
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
	
	function edit() {
		$this->layout = 'settings';
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
			$this->data = $this->User->read(null, $this->Auth->user('id'));
		}
	}
	
	function terms_of_service() {
		$this->layout = 'settings';
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
			if ($termsOfServiceRedirect != null) {
				$this->redirect($termsOfServiceRedirect);
			} else {
				$this->redirect(array('action' => 'home'));
			}
		}
		$this->set('hasAcceptedTos', $this->Auth->user('has_accepted_tos'));
		$this->set('termsOfService', $this->requestAction('/pages/terms_of_service'));
	}
	
	function forgot_password() {
		$this->layout = 'visitor';
		$this->Auth->logout();
		if (!empty($this->data)) {
			if ($this->User->sendPasswordInstructions($this->data) == true) {
				$this->Session->setFlash(__('You should have recieved information on how to restore your password per email.', true));
				$this->redirect(array('action' => 'home'));
			} else {
				$this->Session->setFlash(__('Password retrival information could not be send, try again.', true));
			}
		} else {
			if ($this->referer() != $this->here) {
				$this->Session->setFlash(__("Enter your Account's login name or Email address.", true));
			}
		}
	}
	
	function new_password($passwordResetKey = null) {
		$this->layout = 'settings';
		if (!empty($this->data)) {
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
		$this->layout = 'settings';
		if (!empty($this->data)) {
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
		$this->layout = 'settings';
		if (!empty($this->data)) {
			// TODO
			$this->Session->setFlash('ERROR: NOT IMPLEMENTED YET.');
		}
	}
	
	function hide($switch = 'yes') {
		$this->User->id = $this->Auth->user('id');
		if ($this->User->id != null && $switch == 'yes') {
			if ($this->User->saveField('is_hidden', 1)) {
				$this->Session->setFlash(__('You are now invisible.', true));
			}
		} else if ($this->User->id != null && $switch == 'no') {
			if ($this->User->saveField('is_hidden', 0)) {
				$this->Session->setFlash(__('You are now visible.', true));
			}
		}
		$this->Breadcrume->redirectBack();
	}
	
	function home() {
		if ($this->Auth->isAuthorized() === true) {
			$profileData = $this->User->Profile->find('first', array(
				'fields' => 'Profile.id',
				'conditions' => array('Profile.user_id' => $this->Auth->user('id'))));
			$this->redirect(array('controller' => 'profiles', 'action' => 'view',
				$profileData['Profile']['id']));
		} else {
			$this->redirect('/');
		}
	}
	
	function login() {
		if ($this->Auth->isAuthorized() === true) {
			$this->User->updateLastLogin($this->Auth->user());
			if (!empty($this->data)) {
				if ($this->Session->read('Auth.redirect') == null) {
					$this->redirect(array('action' => 'home'));
				} else {
					$this->redirect($this->Session->read('Auth.redirect'));
				}
			}
		} else {
			$this->layout = 'visitor';
		}
	}
	
	function logout() {
		if ($this->Auth->isAuthorized() == true) {
			$this->Session->setFlash(
				__('Goodbye', true) . ' ' . $this->Auth->user('username') . '...');
			$this->User->updateLastLogin($this->Auth->user());
		}
		$this->Auth->logout();
		$this->redirect(array('action' => 'home'));
	}
	
	function __authAutoRedirectFixes() {
		$sessionAuthRedirect = $this->Session->read('Auth.redirect');
		if (stripos($sessionAuthRedirect, '/users/activate') === 0
		OR stripos($sessionAuthRedirect, '/users/new_password') === 0) {
			$this->Session->write('Auth.redirect', '/users/home');
		}
		unset($sessionAuthRedirect);
	}
	
}
?>