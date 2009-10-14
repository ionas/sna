<div class="shouts form">
<?=$form->create('Shouts', array('action' => $this->action, 'url' =>
	array_merge(array('controller' => 'profiles'), $this->passedArgs, array('_' => '#shouts'))))?>
	<fieldset>
 		<legend><?php __('New Shout')?></legend>
	<?=$form->hidden('Shout.has_shouted', array('value' => true)),
		$form->input('Shout.body', array('label' => __('Message', true)))?>
	</fieldset>
<?=$form->end('Shout')?>
</div>