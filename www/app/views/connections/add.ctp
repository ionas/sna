<div class="connections form">
<?php echo $form->create('Connection');?>
	<fieldset>
 		<legend><?php __('Add Connection');?></legend>
	<?php
		echo $form->input('profile_id');
		echo $form->input('to_profile_id');
		echo $form->input('type');
		echo $form->input('is_request');
		echo $form->input('is_mutual');
		echo $form->input('is_hidden');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Connections', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Profiles', true), array('controller'=> 'profiles', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Profile', true), array('controller'=> 'profiles', 'action'=>'add')); ?> </li>
	</ul>
</div>
