<div class="messages form">
<?=$form->create('Message', array('action' => 'send', 'url' => $this->passedArgs))?>
	<fieldset>
		<legend><?php __('New message to')?> <?=$toProfile['Profile']['nickname']?></legend>
<?=$honeypot->spawn(),
	$honeypot->spawn(),
	$form->input('subject', array('label' => __('Subject', true))),
	$honeypot->spawn(true),
	$form->input('body', array('label' => __('Message Body', true))),
	$honeypot->spawn()
?>
	</fieldset>
<?=$form->end(__('Send', true))?>
</div>