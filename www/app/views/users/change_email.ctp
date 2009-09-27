<div class="users form">
<?=$form->create('User', array('action' => 'change_email'))?>
	<fieldset>
		<legend><?php __('Change Email')?></legend>
<?=$form->input('email', array('label' => __('New Email', true))),
	$form->input('email_confirmation', array(
		'label' => __('New Email Confirmation', true)))
?>
	</fieldset>
	<?=$form->end(__('Set Email', true))?>
</div>
