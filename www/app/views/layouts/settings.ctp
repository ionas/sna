<?php require(LAYOUTS . 'app_header.snip')?>
<?php require(LAYOUTS . 'app_menu.snip')?>
		<h1 id="settings_title">Settings</h1>
		<div id="settings_menu">
			<ul>
				<li><?=$this->Html->link(__('Profile', true), array('controller' => 'profiles', 'action' => 'edit'))?></li>
				<li><?=$this->Html->link(__('Change Password', true), array('controller' => 'users', 'action' => 'change_password'))?></li>
				<li><?=$this->Html->link(__('Change Email', true), array('controller' => 'users', 'action' => 'change_email'))?></li>
				<li><?=$this->Html->link(__('Account', true), array('controller' => 'users', 'action' => 'edit'))?></li>
				<li><?=$this->Html->link(__('Terms of Service', true), array('controller' => 'users', 'action' => 'terms_of_service'))?></li>
			</ul>
		</div>
		<div id="content">
			<?=$this->Session->flash()?>
			<?=BRCLEAR?>
			<?=$content_for_layout?>
		</div>
<?php require(LAYOUTS . 'app_footer.snip')?>