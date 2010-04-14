<div class="users form">
<?=$this->Session->flash('auth')?>
<?=$this->Form->create('User', array('action' => 'login'))?>
	<fieldset>
		<legend><?php __('Login');?></legend>
	<?php if (!empty($authedUser)):?>
	<p><?=__('You are currently logged in as')?> <strong><?=$authedUser['User']['username']?></strong>.</p>
	<?=BR?>
	<?php endif?>

<?=$this->Form->input('username', array('label' => __('Login name', true))),
	$this->Form->input('password', array('label' => __('Password', true)))
?>
	</fieldset>
<?=$this->Form->end('Let me in')?>
</div>
<div class="actions">
	<ul>
		<li><?=$this->Html->link(__('Forgot password?', true), array('controller' => 'users', 'action' => 'forgot_password'))?></li>
	</ul>
</div>