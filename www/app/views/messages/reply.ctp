<div class="messages form">
<?=$form->create('Message', array('action' => 'reply', 'url' => $this->passedArgs))?>
	<fieldset>
		<legend><?php __('Answer to the message from')?> <?=$toProfileNicktname?></legend>
<?=$honeypot->spawn(),
	$honeypot->spawn(),
	$form->input('subject', array('label' => __('Subject', true))),
	$honeypot->spawn(true),
	$form->input('body', array('label' => __('Message Body', true))),
	$honeypot->spawn()
?>
	</fieldset>
<?=$form->end(__('Reply', true))?>
</div>