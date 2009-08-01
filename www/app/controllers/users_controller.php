<?php
class UsersController extends AppController {
	
	var $name = 'Users';
	var $components = array('Auth');
	var $helpers = array('Html', 'Form');
	
	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		// given
		if(strlen($id) < 36) {
			$user = $this->User->find('first', array(
					'User.id',
					'conditions' => array('User.nickname' => $id),
				)
			);
			$id = $user['User']['id'];
		}
		$this->set('user', $this->User->read(null, $id));
	}
	
	function register() {
		if (!empty($this->data)) {
			$this->User->create();
			$this->data['User']['is_hidden'] = 0;
			$this->data['User']['is_disabled'] = 0;
			$this->data['User']['is_deleted'] = 0;
			if ($this->User->save($this->data)) {
				$this->User->saveField('activation_key',
					Security::hash(mb_strtolower(), 'sha256'), true);
				$this->Session->setFlash(__('Your registration has been successful. However, you will still need to activate your user account.', true));
				$this->redirect(array('action' => 'user_activation'));
			} else {
				unset($this->data['User']['password']);
				unset($this->data['User']['password_confirmation']);
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
	}
	
	function user_activation() {
		// activate with given activation_key
	}
	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	/**
	 *  The AuthComponent provides the needed functionality
	 *  for login, so you can leave this function blank.
	 */
	function login() {
	}
	
	function logout() {
		$authedUser = $this->Auth->user();
		$this->Session->setFlash(
			__('Goodbye', true) . ' &lt;' . $authedUser['User']['username'] . '&gt; ...'
		);
		$this->redirect($this->Auth->logout());
	}
	
	function status() {
		debug($this->Auth->user());
		exit;
	}
	
	function home() {
		$authedUser = $this->Auth->user();
		$landingPage = $this->User->UserOption->get($authedUser['User']['id'], array('landingPage'));
		if(!empty($landingPage)) {
			$this->redirect(Func::toRoute($landingPage));
		} else {
			$this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
		}
	}
	
}
?>