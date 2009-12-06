<?php
echo 'paginate:shouts(' . str_replace('/', '|', '/page:1/sort:Shout.created/direction:asc') . ')'
. '/paginate:activities(' . rawurlencode('/page:1/sort:Activities.created/direction:asc') . ')';
class AppController extends Controller {
	
	var $components = array( 'Cookie', 'Session', 'Security', 'Auth', 'RequestHandler');
	var $helpers = array('Html', 'Form', 'Secure', 'Javascript', 'Myhtml');
	
	function beforeFilter() {
		$this->_setupAuth();
		$this->_setLanguage();
		$this->_setupLayout();
		if ($this->name != 'Pages') {
			$this->Security->blackHoleCallback = '__securityError';
			$this->Security->requireAuth($this->action);
		}
		$this->_checkHasAcceptedTos();
	}
	
	function __securityError() {
		$this->cakeError('securityError');
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
		if ($this->name == 'Pages') {
			$this->Auth->allow(array('display'));
		}
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'home');
		$this->Auth->authError = ___('You need to login, to access this location.');
		$this->Auth->loginError = ___("Username or password wrong.");
		$this->Auth->autoRedirect = true;
	}
	
	function _getAuthedUserData() {
		$authedUser = array();
		$authedProfileData = array();
		if ($this->Auth->isAuthorized()) {
			$authedUser = $this->Auth->user();
			$this->loadModel('Profile');
			$this->Profile = new Profile();
			$authedProfileData = $this->Profile->find('first', array(
				'fields' => array('Profile.id', 'Profile.nickname'),
				'conditions' => array('Profile.user_id' => $this->Auth->user('id'))));
		}
		return array_merge($authedProfileData, $authedUser);
	}
	
	function _checkHasAcceptedTos($additionalAllows = array()) {
		if (empty($this->_allowNoTos)) {
			$this->_allowNoTos = array(
				'Pages',
				'Users' => array(
					'logout',
					'login',
					'terms_of_service',
					'forgot_password',
					'new_password',
					'edit',
					'change_password',
					'change_email',
					'home',
				),
				'Profiles' => array(
					'self',
					'edit',
				),
				'Messages' => array(
					'mailbox',
					'trash',
					'restore',
					'remove',
				),
			);
		}
		$this->_allowNoTos = Set::merge($this->_allowNoTos, $additionalAllows);
		if ($this->Auth->isAuthorized()) {
			$allowNoTos = Set::normalize($this->_allowNoTos);
			$doCheckForTos = true;
			if (in_array($this->name, array_keys($allowNoTos))) {
				// Controller wide NoTOS allow
				if (empty($allowNoTos[$this->name])) {
					$doCheckForTos = false;
				// Action (of a controller) wide NoTOS allowed
				} else if (in_array($this->action, $allowNoTos[$this->name])) {
					$doCheckForTos = false;
				}
			}
			// Actual TOS accept check
			if ($this->Auth->user('has_accepted_tos') == 0 and $doCheckForTos == true) {
				$this->Session->setFlash(
					___('You have to accept the Terms of Service before you can continue.'));
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
	
	function _alwaysPushThisDataToView() {
		// $this->data always accessible in view via 'data
		if (!isset ($this->viewVars['data'])) {
			$this->set('data', $this->data);
		}
	}
	
	function _autoLoadCssAndJavascript() {
		// Automagically load CSS files for controllers and actions/views
		$this->set('controller_css_for_layout', 'views' . DS . strtolower($this->name) . '.css');
		$this->set('view_css_for_layout', 'views' . DS . strtolower($this->name) . DS
			. $this->action . '.css');
		$this->set('css_for_layout', 'layouts' . DS . strtolower($this->layout . '.css'));
	}
	
	function beforeRender() {
		$this->set('authedUser', $this->_getAuthedUserData());
		$this->_autoLoadCssAndJavascript();
		$this->_alwaysPushThisDataToView();
	}
	
}
?>