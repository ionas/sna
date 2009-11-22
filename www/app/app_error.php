<?php
class AppError extends ErrorHandler {
	function securityError() {
		$this->controller->set(array(
			'backUrl' => $this->controller->referer()
		));
		$this->_outputMessage('possible_csrf_attack');
	}
}
?>