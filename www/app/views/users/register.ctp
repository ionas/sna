<div class="users form">
<?=$form->create('User', array('type' => 'put', 'action' => 'register'))?>
	<fieldset>
		<legend><?php __('New User Account')?></legend>
<?=$form->input('username', array('label' => __('Login name', true))),
	$form->input('password', array('label' => __('Password', true))),
	$form->input('password_confirmation', array('type'=>'password', 'label' =>
		__('Password Confirmation', true))),
	$form->input('email', array('label' => __('EMail Address', true))),
	$form->input('email_confirmation', array('label' => __('EMail Address Confirmation', true))),
	$form->input('send_copy_via_email', array('type' => 'checkbox', 'checked' => true, 'label' =>
		__('Yes, I want to receive a copy of my User Account details via email.', true))),
	$form->input('has_accepted_tos', array('type' => 'checkbox',
		'label' => __('Hereby, I accept the', true) . ' '
			. $html->link(__('Terms of Service', true),
		array('controller' => 'pages', 'action' => 'display', 'terms_of_service'),
		array('target' => '_blank'))
		. '!'))
?>
	</fieldset>
<?=$form->end(__('Sign up', true))?>
</div>