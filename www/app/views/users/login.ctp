<h2>Login</h2>
<div class="users form">
<?php $session->check('Message.auth') ? $session->flash('auth') : ''?>
<?php if($nicename != null):?>
<p><?=__('You are currently logged in as')?> <strong><?=$nicename?></strong>.</p>
<br>
<?php endif?>
<?=$form->create('User', array('action' => 'login'))?>
<?=$form->input('username')?>
<?=$form->input('password')?>
<?=$form->end('Login')?>
</div>