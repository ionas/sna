<div class="shouts form">
<?php echo $form->create('Shout');?>
	<fieldset>
 		<legend><?php __('Edit Shout');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_id');
		echo $form->input('text');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Shout.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Shout.id'))); ?></li>
		<li><?php echo $html->link(__('List Shouts', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>
