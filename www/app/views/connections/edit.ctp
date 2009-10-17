<div class="connections form">
<?php echo $form->create('Connection');?>
	<fieldset>
 		<legend><?php __('Edit Connection');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('profile_a_id');
		echo $form->input('profile_b_id');
		echo $form->input('profile_a_is_ignore');
		echo $form->input('profile_b_is_ignore');
		echo $form->input('profile_a_is_friend');
		echo $form->input('profile_b_is_friend');
		echo $form->input('profile_a_is_friend_requested');
		echo $form->input('profile_b_is_friend_requested');
		echo $form->input('profile_a_is_authed_for_messages');
		echo $form->input('profile_b_is_authed_for_messages');
		echo $form->input('profile_a_is_authed_for_messages_requested');
		echo $form->input('profile_b_is_authed_for_messages_requested');
		echo $form->input('profile_a_is_authed_for_shouts');
		echo $form->input('profile_b_is_authed_for_shouts');
		echo $form->input('profile_a_is_authed_for_shouts_requested');
		echo $form->input('profile_b_is_authed_for_shouts_requested');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Connection.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Connection.id'))); ?></li>
		<li><?php echo $html->link(__('List Connections', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Profiles', true), array('controller'=> 'profiles', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Profile A', true), array('controller'=> 'profiles', 'action'=>'add')); ?> </li>
	</ul>
</div>
