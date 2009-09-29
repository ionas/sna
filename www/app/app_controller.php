<?php
class AppController extends Controller {
	
	var $components = array('Auth', 'Session', 'Cookie', 'RequestHandler', 'Breadcrume');
	var $helpers = array('Html','Javascript');

	var $enforceTosOn = array('Users', 'Messages', 'Shouts');
	
	function beforeFilter() {
		$this->_setupAuth();
		$this->_checkHasAcceptedTos();
		$this->_setLanguage();
		$this->_setupLayout();
	}
	
	function beforeRender() {
		// Automagically load CSS files for controllers and actions/views
		$this->set('controller_css_for_layout', 'views' . DS . strtolower($this->name) . '.css');
		$this->set('view_css_for_layout', 'views' . DS . strtolower($this->name) . DS
			. $this->action . '.css');
		$this->set('css_for_layout', 'layouts' . DS . strtolower($this->layout . '.css'));
	}
	
	function _setLanguage() {
		if ($this->Cookie->read('lang') && !$this->Session->check('Config.language')) {
		    $this->Session->write('Config.language', $this->Cookie->read('lang'));
		} else if (isset($this->params['lang']) && ($this->params['lang']
		         !=  $this->Session->read('Config.language'))) {     
		    $this->Session->write('Config.language', $this->params['lang']);
		    $this->Cookie->write('lang', $this->params['lang'], null, '20 days');
		}
	} 
	
	function _setupAuth() {
		Security::setHash('sha256');
		// ENCH: Functionize, pass Array with 'ControllerA' => array('ActionA')?
		$this->Auth->allow(array('display'));
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'home');
		$this->Auth->autoRedirect = true;
		$authedUser = array();
		$authedProfileData = array();
		if ($this->Auth->isAuthorized()) {
			$authedUser = $this->Auth->user();
			$this->loadModel('Profile');
			$this->Profile = new Profile();
			$authedProfileData = $this->Profile->find('first', array(
				'fields' => array('Profile.id'),
				'conditions' => array('Profile.user_id' => $this->Auth->user('id'))));
		}
		$this->set('authedUser', array_merge($authedProfileData, $authedUser));
	}
	
	function _checkHasAcceptedTos() {
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
					_('You have to accept the Terms of Service before continuing.', true));
				$this->Session->write('TermsOfService.redirect', $this->here);
				$this->redirect(array('controller' => 'users', 'action' => 'terms_of_service'));
			}
		}
	}
	
	function _setupLayout() {
		if ($this->Auth->isAuthorized()) {
			$this->layout = 'default';
		} else {
			$this->layout = 'visitor';
		}
		if ($this->here == '/' or $this->here == '/pages/home') {
			$this->layout = 'fullscreen';
		}
	}
	
}
?>