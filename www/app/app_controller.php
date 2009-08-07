<?php
class AppController extends Controller {
	
	var $components = array('Auth');
	
	var $termsOfServiceRequired = array('Users', 'Messages', 'Shouts');
	
	function beforeFilter() {
		$this->_setupAuth();
		$this->_checkHasAcceptedTos();
		$this->_authAutoRedirectFixes();
	}
	
	function _setupAuth() {
		Security::setHash('sha256');
		// ENCH: Functionize, pass Array with 'ControllerA' => array('ActionA')?
		if ($this->name == 'Pages') {
			$this->Auth->allow(array('display'));
		}
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'home');
		$this->Auth->autoRedirect = true;
	}
	
	function _checkHasAcceptedTos() {
		if ($this->Auth->isAuthorized()) {
			if (in_array($this->name, $this->termsOfServiceRequired)
			&& !($this->name == 'Users' && in_array($this->action, array(
							'forgot_password',
							'logout',
							'terms_of_service',
						)
			))
			&& $this->Auth->user('has_accepted_tos') != 1) {
				$this->Session->setFlash(
					__('You have accepted the Terms of Service before continuing.', true));
				$this->Session->write('TermsOfService.redirect', $this->here);
				$this->redirect(array('controller' => 'users', 'action' => 'terms_of_service'));
			}
		}
	}
	
	/* could this be in UsersController? */
	function _authAutoRedirectFixes() {
		$authRedirect = $this->Session->read('Auth.redirect');
		$this->log('$this->name: ' . $this->name . ' | $this->action: ' 
			. $this->action . ' | Auth->redirect: ' . $authRedirect, 'debug');
		if(stripos($authRedirect, '/users/activate') === 0) {
			$this->Session->write('Auth.redirect', '/users/home');
		}
	}
	
}
/**
* Namespace for general helper functions
* 
*/
class Func {
	
	function toRoute($stringRoute) {
		// format key=>value, key=>value
		$explodedRoute = explode(', ', $stringRoute);
		$route = array();
		foreach ($explodedRoute as $pair) {
			if (strstr($pair, '=>')) {
				$pair = explode('=>', $pair);
				$route[$pair[0]] = $pair[1];
			} else {
				$route[] = $pair;
			}
		}
		return $route;
	}
	
}

?>