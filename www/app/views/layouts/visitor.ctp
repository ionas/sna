<?php require(LAYOUTS . 'app_header.snip')?>
		<div id="menu">
			<ul>
				<li><?=$html->link(__('Register', true), array('controller' => 'users', 'action' => 'register'))?></li>
				<li><?=$html->link(__('Login', true), array('controller' => 'users', 'action' => 'login'))?></li>
				<li><?=$html->link(__('Forgot Password?', true), array('controller' => 'users', 'action' => 'forgot_password'))?></li>
				<li><?=$html->link(__('About', true), array('controller' => 'pages', 'action' => 'display', '/about'))?></li>
			</ul>
		</div>
		<div id="content">
			<?php $session->flash()?>
			<?=BRCLEAR?>
			<?=$content_for_layout?>
		</div>
<?php require(LAYOUTS . 'app_footer.snip')?>