<div class="users form">
<?=$form->create('User', array('action' => 'new_password'))?>
	<fieldset>
		<legend><?php __('New Password')?></legend>
<?=$honeypot->spawn(),
	$honeypot->spawn(),
	$form->input('password_reset_key'),
	$form->input('username', array('label' => 'Login name')),
	$honeypot->spawn(true),
	$form->input('password', array('label' => 'New Password')),
	$form->input('password_confirmation', array('label' => 'New Password Confirmation')),
	$honeypot->spawn()
?>
	</fieldset>
<?=$form->end(__('Set new password', true))?>
</div>
