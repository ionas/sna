<?php
class AppController extends Controller {
	
	function beforeFilter() {
		Security::setHash('sha256');
	}
	
}

class Lib {
	
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