<div class="users form">
<?=$form->create('User', array('action' => 'edit'))?>
	<fieldset>
		<legend><?php __('User Account');?></legend>
<?=$form->hidden('id'),
	$form->input('username', array('label' => __('Login name', true))),
	$form->input('gender', array('label' => __('Gender', true))),
	$form->input('is_disabled', array('label' => __('Disable?', true))),
	$form->input('is_deleted', array('label' => __('Delete?', true)));
?>
	</fieldset>
<?=$form->end('Confirm')?>
</div>