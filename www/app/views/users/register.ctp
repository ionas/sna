<div class="users form">
<?=$form->create('User', array('action' => 'register'))?>
	<fieldset>
 		<legend><?php __('Register User')?></legend>
	<?php
		echo $form->input('username');
		echo $form->input('password');
	    echo $form->input('password_confirmation');
		echo $form->input('nickname');
		echo $form->input('email');
		echo $form->input('has_accepted_tos');
	?>
	</fieldset>
<?=$form->end('Submit')?>
</div>
<div class="actions">
	<ul>
		<li><?=$html->link(__('List Users', true), array('action'=>'index'))?></li>
		<li><?=$html->link(__('List User Options', true), array('controller'=> 'user_options', 'action'=>'index'))?></li>
		<li><?=$html->link(__('New User Option', true), array('controller'=> 'user_options', 'action'=>'add'))?></li>
		<li><?=$html->link(__('List Messages', true), array('controller'=> 'messages', 'action'=>'index'))?></li>
		<li><?=$html->link(__('New Message', true), array('controller'=> 'messages', 'action'=>'add'))?></li>
		<li><?=$html->link(__('List Shouts', true), array('controller'=> 'shouts', 'action'=>'index'))?></li>
		<li><?=$html->link(__('New Shout', true), array('controller'=> 'shouts', 'action'=>'add'))?></li>
	</ul>
</div>
