<div class="messages form">
<?=$form->create('Message', array('type' => 'put', 'action' => 'send', 'url' => $this->passedArgs))?>
	<fieldset>
		<legend><?php __('New message to')?> <?=$toProfile['Profile']['nickname']?></legend>
<?=$form->input('subject', array('label' => __('Subject', true))),
	$form->input('body', array('label' => __('Message Body', true)))
?>
	</fieldset>
<?=$form->end(__('Send', true))?>
</div>