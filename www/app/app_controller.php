<?php
class AppController extends Controller {
	
	var $components = array('Auth');
	
	function beforeFilter() {
		Security::setHash('sha256');
		$this->Auth->allow(array('display'));
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'home');
		$this->Auth->autoRedirect = true;
	}
	
}

class Func {
	
	function toRoute($stringRoute) {
		// format key=>value, key=>value
		$explodedRoute = explode(', ', $stringRoute);
		$route = array();
		foreach($explodedRoute as $pair) {
			if(strstr($pair, '=>')) {
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