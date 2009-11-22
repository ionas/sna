<?php
/**
* 
* This helper should be used conjunction with CakePHP 1.2/1.3's SecurityComponent
* It enables a fast and easy way to move data modifying actions based on GET to POST
* Furthermore it enables SecurityComponent to take care about advanced CSRF (modified POST Requests)
* 
*/
class SecureHelper extends AppHelper {
	
	var $helpers = array('Form');
	
	/**
	* Params mimik the interface of HtmlHelper::link()
	*/
	function link($label, $url, $options = null, $confirmMsg = null, $model = null, $id = null) {
		if ($id == null) {
			if (is_array($url)) {
				$id = $url[0];
			}
			// TODO: not implemented, $url being a string rather than an $array
		}
		if ($model == null) {
			$model = Inflector::classify($this->params['controller']);
		}
		if ($confirmMsg != null) {
			$options = array_merge($options,
				array('onclick' => "return confirm('" . $confirmMsg . "');"));
		}
		return $this->Form->create($model, array('url' => $url))
			. $this->Form->hidden('id', array('value' => $id))
			. $this->Form->end(array_merge(array('label' => $label), $options));
	}
	
}
?>

