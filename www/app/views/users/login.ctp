<h2>Login</h2>
<div class="users form">
<?=$session->check('Message.auth') ? $session->flash('auth') : ''?>
<?php if($niceName !== false):?>
<p><?=__('You are currently logged in as')?> <strong><?=$niceName?></strong>.</p>
<br>
<?php endif?>
<?=$form->create('User', array('action' => 'login'))?>
<?=$form->input('username')?>
<?=$form->input('password')?>
<?=$form->end('Login')?>
</div>
