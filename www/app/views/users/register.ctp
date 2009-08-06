<div class="users form">
<?=$form->create('User', array('action' => 'register'))?>
	<fieldset>
		<legend><?php __('New User Account')?></legend>
<?php
echo $form->input('nickname', array('label' => __('Nickname (public visible)', true)));
echo $form->input('username', array(
		'label' => __('Login name', true) . ' ('
			. __('For better security, choose a Login name, different from your Nickname or EMail address!', true) . ')',
		'onfocus' => "if(this.value == '') { this.value = getElementById('UserNickname').value; }"));
echo $form->input('password', array('label' => __('Password', true)));
echo $form->input('password_confirmation', array('type'=>'password', 'label' => __('Password Confirmation', true)));
echo $form->input('email', array('label' => __('EMail Address', true)));
echo $form->input('email_confirmation', array('label' => __('EMail Address Confirmation', true)));
echo $form->input('send_copy_via_email', array('type' => 'checkbox', 'checked' => true, 'label' =>
		__('Yes, I want to recieve a copy of my User Account details via email.', true)));
echo $form->input('has_accepted_tos', array('label' => __('Hereby, I accept the', true) . ' '
		. $html->link(__('Terms of Service', true),
			array('controller' => 'pages', 'action' => 'display', 'public/terms_of_service'),
			array('target' => '_blank'))
		. '!'));
?>
	</fieldset>
<?=$form->end(__('Sign up', true))?>
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