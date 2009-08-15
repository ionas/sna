<div class="users form">
<?=$form->create('User', array('action' => 'forgot_password'))?>
	<fieldset>
		<legend><?php __('Get new Password')?></legend>
	<?php
		echo $form->error('could_not_send', String::insert(
				__('Our service at :domain is currently not able to send an Email. We are working on the problem. Try again later.', true),
				array('domain' => env('SERVER_NAME'))));
		echo $form->error('forgot_password');
		echo $honeypot->spawn();
		echo $honeypot->spawn();
		echo $form->input('username', array('label' => __('Login name', true)));
		echo $form->input('username');
		echo $honeypot->spawn(true);
		echo $honeypot->spawn();
		echo $form->input('email');
		echo $honeypot->spawn();
		echo $honeypot->spawn();
		echo $form->end(__('Send instructions', true));
	?>
</div>