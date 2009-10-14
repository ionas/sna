<div class="shouts form">
<?=$form->create('Profile', array('action' => $this->action, 'url' =>
	array_merge(array('controller' => 'profiles'), $this->passedArgs, array('#' => 'shouts'))))?> 
	<fieldset>
 		<legend><?php __('New Shout')?></legend>
		<?=$form->input('Shout.body', array('label' => __('Message', true)))?> 
	</fieldset>
<?=$form->end('Shout')?>
</div>