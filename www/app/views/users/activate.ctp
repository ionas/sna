<div class="users form">
<?=$form->create('User', array('action' => 'activate'))?>
	<fieldset>
		<legend><?php __('Activate User Account')?></legend>
<?=$form->input('activation_key')?>
	</fieldset>
<?=$form->end(__('Finish Activation', true))?>
</div>
