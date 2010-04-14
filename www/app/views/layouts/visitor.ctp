<?php require(LAYOUTS . 'app_header.snip')?>
		<div id="submenu">
			<ul>
				<li><?=$this->Html->link(__('Register', true), array('controller' => 'users', 'action' => 'register'))?></li>
				<li><?=$this->Html->link(__('Login', true), array('controller' => 'users', 'action' => 'login'))?></li>
				<li><?=$this->Html->link(__('Forgot Password?', true), array('controller' => 'users', 'action' => 'forgot_password'))?></li>
				<li><?=$this->Html->link(__('About', true), array('controller' => 'pages', 'action' => 'display', '/about'))?></li>
			</ul>
		</div>
		<div id="content">
			<?=$this->Session->flash()?>
			<?=BRCLEAR?>
			<?=$content_for_layout?>
		</div>
<?php require(LAYOUTS . 'app_footer.snip')?>