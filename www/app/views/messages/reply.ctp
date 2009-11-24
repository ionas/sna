<div class="messages form">
<?=$form->create('Message', array('type' => 'put', 'action' => 'reply', 'url' => $this->passedArgs))?>
	<fieldset>
		<legend><?php __('Answer to the message from')?> <?=$toProfileNicktname?></legend>
<?=$form->input('subject', array('label' => __('Subject', true))),
	$form->input('body', array('label' => __('Message Body', true)))?>
	</fieldset>
<?=$form->end(__('Reply', true))?>
</div>