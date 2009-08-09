<div class="users form">
<?=$form->create('User', array('action' => 'forgot_password'))?>
	<fieldset>
		<legend><?php __('Forgot Password?')?></legend>
	<?php
		echo $form->error('forgot_password');
		echo $honeypot->spawn();
		echo $honeypot->spawn();
		echo $form->input('username');
		echo $honeypot->spawn();
		echo $honeypot->spawn();
		echo $form->input('email');
		echo $honeypot->spawn();
		echo $honeypot->spawn();
		echo $form->end(__('Send instructions', true));
	?>
</div>
