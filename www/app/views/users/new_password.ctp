<div class="users form">
<?=$form->create('User', array('action' => 'new_password'))?>
	<fieldset>
		<legend><?php __('New Password')?></legend>
	<?php
		echo $honeypot->spawn();
		echo $honeypot->spawn();
		echo $form->input('password_request_key');
		echo $form->input('username', array('label' => 'Login name'));
		echo $honeypot->spawn(true);
		echo $form->input('password', array('label' => 'New Password'));
		echo $form->input('password_confirmation', array('label' => 'New Password Confirmation'));
		echo $honeypot->spawn();
		echo $form->end(__('Set new password', true));
	?>
</div>
