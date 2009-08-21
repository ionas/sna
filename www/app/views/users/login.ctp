<div class="users form">
<?php $session->check('Message.auth') ? $session->flash('auth') : ''?>
<?=$form->create('User', array('action' => 'login'))?>
	<fieldset>
		<legend><?php __('Login');?></legend>
	<?php if($authedUser != null):?>
	<p><?=__('You are currently logged in as')?> <strong><?=$authedUser?></strong>.</p>
	<br>
	<?php endif?>

<?=$form->input('username', array('label' => __('Login name', true))),
	$form->input('password', array('label' => __('Password', true)))
?>
	</fieldset>
<?=$form->end('Let me in')?>
</div>
<div class="actions">
	<ul>
		<li><?=$html->link(__('Forgot password?', true), array('action' => 'forgot_password'))?></li>
		<li><?=$html->link(__('New here? Sign up!', true), array('action' => 'register'))?></li>
	</ul>
</div>