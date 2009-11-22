<div class="connections form">
<?=$form->create('Connection', array('action' => $this->action, 'url' => $this->passedArgs))?>
	<fieldset>
 		<legend><?=Inflector::humanize($this->action)?> <?=Inflector::humanize($this->passedArgs[0])?></legend>
		<p><?=$toProfileData['ToProfile']['nickname']?> <?php __('requested')?> <strong><?=Inflector::humanize($this->passedArgs[0])?></strong>
			<?php __('on')?> <?=$connectionData['Connection']['created']?>.</p>
	</fieldset>
<?=$form->submit(__('Yes', true), array('name' => 'yes'))?>
<?=$form->submit(__('No', true), array('name' => 'no'))?>
<?=$form->submit(__('Decide later', true), array('name' => 'later'))?>
<?=$form->end()?>
</div>