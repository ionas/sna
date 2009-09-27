<ul>
<li><?=$html->link(__('Register', true), array('controller' => 'users', 'action' => 'register'))?></li>
<li><?=$html->link(__('Login', true), array('controller' => 'users', 'action' => 'login'))?></li>
<li><?=$html->link(__('Forgot Password', true), array('controller' => 'users', 'action' => 'forgot_password'))?></li>
<li><?=$html->link(__('About', true), array('controller' => 'pages', 'action' => 'display', '/public/about'))?></li>
</ul>

<h2>README</h2>
<?=nl2br(file_get_contents('../../../README'))?>
<h2>License</h2>
<?=nl2br(htmlentities(file_get_contents('../../../gpl-3.0.txt')))?>