<div class="users form">
<?=$form->create('User', array('action' => 'activate'))?>
	<fieldset>
		<legend><?php __('Activate User Account')?></legend>
	<?php
		echo $form->input('activation_key');
		echo $form->end('Finish Activation');
	?>
</div>
