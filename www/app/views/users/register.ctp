<div class="users form">
<?=$form->create('User', array('action' => 'register'))?>
	<fieldset>
		<legend><?php __('New User Account')?></legend>
<?=$honeypot->spawn(),
	$form->input('nickname', array('label' => __('Nickname (public visible)', true))),
	$honeypot->spawn(),
	$form->input('username', array(
		'label' => __('Login name', true) . ' ('
			. __('For better security, choose a Login name, different from your Nickname or EMail address!', true) . ')',
		'onfocus' => "if(this.value == '') { this.value = getElementById('UserNickname').value, }")),
	$honeypot->spawn(),
	$form->input('password', array('label' => __('Password', true))),
	$honeypot->spawn(),
	$form->input('password_confirmation', array('type'=>'password', 'label' => __('Password Confirmation', true))),
	$honeypot->spawn(true),
	$form->input('email', array('label' => __('EMail Address', true))),
	$honeypot->spawn(),
	$form->input('email_confirmation', array('label' => __('EMail Address Confirmation', true))),
	$honeypot->spawn(),
	$form->input('send_copy_via_email', array('type' => 'checkbox', 'checked' => true, 'label' =>
		__('Yes, I want to receive a copy of my User Account details via email.', true))),
	$honeypot->spawn(),
	$form->input('has_accepted_tos', array('label' => __('Hereby, I accept the', true) . ' '
		. $html->link(__('Terms of Service', true),
			array('controller' => 'pages', 'action' => 'display', 'public/terms_of_service'),
			array('target' => '_blank'))
		. '!')),
		$honeypot->spawn()
?>
	</fieldset>
<?=$form->end(__('Sign up', true))?>
</div>
<div class="actions">
	<ul>
		<li><?=$html->link(__('Login with an existing User Account', true), array('action' => 'login'))?></li>
		<li><?=$html->link(__('Forgot password?', true), array('action' => 'forgot_password'))?></li>
	</ul>
</div>