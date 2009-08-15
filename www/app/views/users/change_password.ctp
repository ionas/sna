<div class="users form">
<?=$form->create('User', array('action' => 'change_password'))?>
	<fieldset>
		<legend><?php __('Change Password')?></legend>
<?=$form->input('password_current', array('label' => __('Current Password', true))),
	$form->input('password', array('label' => __('New Password', true))),
	$form->input('password_confirmation', array(
		'type' => 'password',
		'label' => __('New Password Confirmation', true)))
?>
	</fieldset>
	<?=$form->end(__('Set Password', true))?>
</div>
