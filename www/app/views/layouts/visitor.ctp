<?php require(LAYOUTS . 'app_header.snip')?>
		<div id="menu">
			<ul>
				<li><?=$html->link(__('Register', true), array('controller' => 'users', 'action' => 'register'))?></li>
				<li><?=$html->link(__('Login', true), array('controller' => 'users', 'action' => 'login'))?></li>
				<li><?=$html->link(__('Forgot Password', true), array('controller' => 'users', 'action' => 'forgot_password'))?></li>
				<li><?=$html->link(__('About', true), array('controller' => 'pages', 'action' => 'display', '/public/about'))?></li>
			</ul>
		</div>
		<div id="content">
			<?php $session->flash()?>
			<br style="visibility: hidden; height: 0; width: 0; border:0; margin: 0; padding: 0; display: inline; clear: both" />
			<?=$content_for_layout?>
		</div>
<?php require(LAYOUTS . 'app_footer.snip')?>