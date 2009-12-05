<?php
App::import('Controller');
$Controller = new Controller;
$Controller->redirect(array('controller' => 'users', 'action' => 'register_or_login'));
?>