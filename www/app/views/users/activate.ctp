<div class="users form">
<?=$form->create('User', array('action' => 'activate'))?>
	<fieldset>
		<legend><?php __('Activate User Account')?></legend>
	<?php
		echo $honeypot->spawn();
		echo $honeypot->spawn();
		echo $form->input('activation_key');
		echo $honeypot->spawn();
		echo $honeypot->spawn();
		echo $form->end(__('Finish Activation', true));
	?>
</div>
