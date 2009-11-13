<div class="connections form">
<?=$form->create('Connection', array('action' => $this->action, 'url' => $this->passedArgs))?>
	<fieldset>
 		<legend><?php __('Request for')?> <?=$this->passedArgs[0]?></legend>
		<p><?=$toProfileData['ToProfile']['nickname']?> <?php __('requested')?> <em><?=$this->passedArgs[0]?></em>
			<?php __('on')?> <?=$connectionData['Connection']['created']?>.</p>
	</fieldset>
	<?=$form->submit(__('OK', true), array('name' => 'ok'))?>
	<?=$form->submit(__('Cancel', true), array('name' => 'cancel'))?>
</div>