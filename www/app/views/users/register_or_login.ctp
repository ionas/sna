<h2>Welcome</h2>
<p>
Welcome to SNA. Login or Register below. It's free.
</p>
<div id="start_boxes">
	<div id="register_box">
		<?php if(!empty($authedUser)):?>
			<p><br /><br /><?=__('If you want to register, you will have to logout first')?></p>
			<?=$html->link(___('Logout'), array('controller' => 'users', 'action' => 'logout'))?>
		<?php else:?>
			<?=$this->element('../users/register')?>
		<?php endif?>
	</div>
	<div id="login_box">
		<?=$this->element('../users/login')?>
	</div>
	<br class="clear" />
</div>
<?=$this->element('../pages/welcome')?>