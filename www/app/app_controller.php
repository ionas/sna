<?php
class AppController extends Controller {
	
	var $components = array('Auth', 'Session', 'Cookie');
	var $helpers = array('Html','Javascript');
	var $enforceTosOn = array('Users', 'Messages', 'Shouts');
	
	function beforeFilter() {
		$this->__setupAuth();
		$this->__checkHasAcceptedTos();
		$this->__setLanguage();
	}
	
	function beforeRender(){
		// Automagically load CSS files for controllers and actions/views
		if (file_exists(CSS . 'views' . DS . strtolower($this->name) . '.css')) {
			$this->set('controller_css_for_layout', 'views' . DS . strtolower($this->name));
		}
		if (file_exists(CSS . 'views' . DS . strtolower($this->name) . DS . $this->action . '.css')) {
			$this->set('view_css_for_layout', 'views' . DS . strtolower($this->name) . DS . $this->action);
		}
	}
	
	function __setLanguage() {
		if ($this->Cookie->read('lang') && !$this->Session->check('Config.language')) {
		    $this->Session->write('Config.language', $this->Cookie->read('lang'));
		} else if (isset($this->params['lang']) && ($this->params['lang']
		         !=  $this->Session->read('Config.language'))) {     
		    $this->Session->write('Config.language', $this->params['lang']);
		    $this->Cookie->write('lang', $this->params['lang'], null, '20 days');
		}
	} 
	
	function __setupAuth() {
		Security::setHash('sha256');
		// ENCH: Functionize, pass Array with 'ControllerA' => array('ActionA')?
		switch ($this->name) {
			case 'Pages':
				$this->Auth->allow(array('display'));
		}
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'home');
		$this->Auth->autoRedirect = true;
		$this->set('activeUser', $this->Auth->user());
	}
	
	function __checkHasAcceptedTos() {
		if ($this->Auth->isAuthorized()) {
			if (in_array($this->name, $this->enforceTosOn)
			&& !($this->name == 'Users' && in_array($this->action, array(
							// Exception List: these actions require no TOS acceptance
							'terms_of_service',
							'forgot_password',
							'new_password',
							'change_password',
							'hide',
							'logout',
							'login',
				)))
			&& $this->Auth->user('has_accepted_tos') != 1) {
				$this->Session->setFlash(
					__('You have to accept the Terms of Service before continuing.', true));
				$this->Session->write('TermsOfService.redirect', $this->here);
				$this->redirect(array('controller' => 'users', 'action' => 'terms_of_service'));
			}
		}
	}
	
}
?>