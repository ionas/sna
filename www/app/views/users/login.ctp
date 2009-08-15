<h2>Login</h2>
<div class="users form">
<?php $session->check('Message.auth') ? $session->flash('auth') : ''?>
<?php if($nicename != null):?>
<p><?=__('You are currently logged in as')?> <strong><?=$nicename?></strong>.</p>
<br>
<?php endif?>
<?=$form->create('User', array('action' => 'login'))?>
<?=$form->input('username', array('label' => __('Login name', true)))?>
<?=$form->input('password', array('label' => __('Password', true)))?>
<?=$form->end('Let me in')?>
</div>
<div class="actions">
	<ul>
		<li><?=$html->link(__('Forgot password?', true), array('action' => 'forgot_password'))?></li>
		<li><?=$html->link(__('New here? Sign up!', true), array('action' => 'register'))?></li>
	</ul>
</div>