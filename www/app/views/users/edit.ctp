<div class="users form">
<?=$form->create('User', array('action' => 'edit'))?>
	<fieldset>
		<legend><?php __('User Account');?></legend>
<?=$form->hidden('id'),
	$form->input('username', array('label' => __('Login name', true))),
	$form->input('gender_id', array('label' => __('Gender', true)))?>
	</fieldset>
<?=$form->end('Confirm')?>
</div>