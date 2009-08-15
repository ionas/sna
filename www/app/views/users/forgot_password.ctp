<div class="users form">
<?=$form->create('User', array('action' => 'forgot_password'))?>
	<fieldset>
		<legend><?php __('Get new Password')?></legend>
<?=$form->error('could_not_send', String::insert(
			__('Our service at :domain is currently not able to send an Email. We are working on the problem. Try again later.', true),
			array('domain' => env('SERVER_NAME')))),
	$form->error('forgot_password'),
	$honeypot->spawn(),
	$honeypot->spawn(),
	$form->input('username', array('label' => __('Login name', true))),
	$form->input('username'),
	$honeypot->spawn(true),
	$honeypot->spawn(),
	$form->input('email'),
	$honeypot->spawn(),
	$honeypot->spawn()
?>
	</fieldset>
<?=$form->end(__('Send instructions', true))?>
</div>