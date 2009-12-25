<?=__('Request a new password for ', true) . $domainName . '!'?><?=BR?>
<?=BR?>
<?=__('To request a new password, please click on this Link:', true)?><?=BR?>
<?='<a href="http://' . $serverName . '/users/new_password/' . $passwordResetKey . '">'
	. 'http://' . $serverName . '/users/new_password/' . $passwordResetKey . '</a>'?><?=BR?>
<?=__('If that does not work, copy and paste over this Password Request Key', true) . ': '?><?=BR?>
<?=BR?>
<?=$passwordResetKey?><?=BR?>
<?=BR?>
<?=__('... into the Password Request Key field at', true) . ': '?><?=BR?>
<?=' http://' . $serverName . '/users/new_password'?>