<?php
class AppController extends Controller {
	
	var $components = array('Auth', 'Session', 'Cookie');
	
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
		$this->Auth->allow(array('*'));
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
	
	function currentUser($modelalias = null) {
		if($modelalias != null) {
			$this->data[$modelalias]['user_id'] = $this->Auth->user('id');
		}
		return $this->Auth->user('id');
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