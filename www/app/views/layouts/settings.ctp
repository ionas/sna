<?php require(LAYOUTS . 'app_header.snip')?>
<?php require(LAYOUTS . 'app_menu.snip')?>
		<h1>Settings</h1>
		<div id="settings_menu">
			<ul>
				<li><?=$html->link(__('Profile', true), array('controller' => 'profiles', 'action' => 'edit'))?></li>
				<li><?=$html->link(__('Account', true), array('controller' => 'users', 'action' => 'edit'))?></li>
				<li><?=$html->link(__('Change Password', true), array('controller' => 'users', 'action' => 'change_password'))?></li>
				<li><?=$html->link(__('Change Email', true), array('controller' => 'users', 'action' => 'change_email'))?></li>
				<li><?=$html->link(__('Terms of Service', true), array('controller' => 'users', 'action' => 'terms_of_service'))?></li>
			</ul>
		</div>
		<div id="content">
			<?php $session->flash()?>
			<br style="visibility: hidden; height: 0; width: 0; border:0; margin: 0; padding: 0; display: inline; clear: both" />
			<?=$content_for_layout?>
		</div>
<?php require(LAYOUTS . 'app_footer.snip')?>