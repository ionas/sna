<?php
/**
* 
* This helper should be used conjunction with CakePHP 1.2/1.3's SecurityComponent
* It enables a fast and easy way to move data modifying actions "links" based on HTTP GET
* To tiny "forms" based on HTTP POST. $this->Security->requirePost() must be set as well.
* Furthermore it enables SecurityComponent to take care about advanced CSRF (modified POST Requests)
* 
*/
class SecureHelper extends AppHelper {
	
	var $helpers = array('Form');
	
	/**
	* Params mimic the interface of HtmlHelper::link()
	*/
	function link($label, $url, $options = array(), $confirmMsg = null, $model = null, $id = null) {
		if(!is_array($options)) {
			$options = array();
		}
		if ($id == null) {
			if (is_string($url)) {
				$url = Router::parse($url);
			}
			if(!empty($url['pass'])) {
				$id = end($url['pass']);
			} else if (isset($url[0])) {
				// assumes first nonhash element in the array is the id
				$id = $url[0];
			} else {
				return false;
			}
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

