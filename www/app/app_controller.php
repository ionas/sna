<?php
class AppController extends Controller {
	
	var $components = array('Auth', 'Session', 'Cookie');
	var $helpers = array('Html','Javascript');
	var $tosProtectedControllers = array('Users', 'Messages', 'Shouts');
	
	function beforeFilter() {
		$this->__setupAuth();
		$this->__checkHasAcceptedTos();
		$this->__setLanguage();
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
	}
	
	function __checkHasAcceptedTos() {
		if ($this->Auth->isAuthorized()) {
			if (in_array($this->name, $this->tosProtectedControllers)
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
	
	function getCurrentUser($setForModelalias = null) {
		if($this->Auth->isAuthorized()) {
			$authedUser = $this->Auth->user();
			if($setForModelalias != null) {
				$this->data[$setForModelalias]['user_id'] = $authedUser['User']['id'];
			}
			App::import('Profile');
			$Profile = new Profile();
			$profileData = $Profile->find('first', array(
					'fields' => array('id'),
					'conditions' => array('user_id' => $authedUser['User']['id'])));
			$this->set('authedUser', $authedUser);
			return $authedUser;
		} else {
			return false;
		}
	}
	
	function beforeRender(){
		$this->set('controller_css_for_layout', 'views' . DS  . '_empty');
		$this->set('view_css_for_layout', 'views' . DS  . '_empty');
		if (file_exists(CSS . 'views' . DS . strtolower($this->name) . '.css')) {
			$this->set('controller_css_for_layout', 'views' . DS . strtolower($this->name));
		}
		if (file_exists(CSS . 'views' . DS . strtolower($this->name) . DS . $this->action . '.css')) {
			$this->set('view_css_for_layout', 'views' . DS . strtolower($this->name) . DS . $this->action);
		}
	}
	
}
?>
<?php
/*
function list_system_locales(){
    ob_start();
    system('locale -a');
    $str = ob_get_contents();
    ob_end_clean();
    return split("\\n", trim($str));
}

$locale = "de_DE.UTF8";
$locales = list_system_locales();

if(in_array($locale, $locales)){
        echo "yes yes yes....";
}else{
        echo "no no no.......";
}
debug($locales);
*/
?>