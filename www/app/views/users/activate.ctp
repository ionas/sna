<div class="users form">
<?=$form->create('User', array('action' => 'activate'))?>
	<fieldset>
		<legend><?php __('Activate User Account')?></legend>
<?=$honeypot->spawn(),
	$honeypot->spawn(),
	$form->input('activation_key'),
	$honeypot->spawn(),
	$honeypot->spawn(),
?>
	</fieldset>
<?=$form->end(__('Finish Activation', true))?>
</div>
