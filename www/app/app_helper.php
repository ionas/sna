<?php
class AppHelper extends Helper {
	
	var $__usedDomIds = array();
	var $__usedDomIdsCounter = 0;
	
	function url($url = null, $full = false) {
		if (!isset($url['lang']) && isset($this->params['lang'])) {
		  $url['lang'] = $this->params['lang'];
		}
		return parent::url($url, $full);
	}
	
	/* see http://code.cakephp.org/tickets/view/356 */
	function domId($options = null, $id = 'id') {
		$domId = parent::domId($options, $id);
		if (isset($domId['id'])) {
			if (in_array($domId['id'], $this->__usedDomIds)) {
				$domId['id'] = $domId['id'] . '_' . $this->__usedDomIdsCounter;
				$this->__usedDomIdsCounter++; /* this should be better done on same form creation
				like where $form->create('FooModel') takes place, if that happens a second time
				$this->__usedDomIdsCounter should be increased by 1 */
			} else {
				$this->__usedDomIds[] = $domId['id'];
			}
		}
		return $domId;
	}
	
}
?>