<?=__('Request a new password for ', true) . $domainName . '!'?><?="\n"?>
<?="\n"?>
<?=__('To request a new password, please click on this Link:', true)?><?="\n"?>
<?='<a href="http://' . $serverName . '/users/new_password/' . $passwordResetKey . '">'
	. 'http://' . $serverName . '/users/new_password/' . $passwordResetKey . '</a>'?><?="\n"?>
<?=__('If that does not work, copy and paste over this Password Request Key', true) . ': '?><?="\n"?>
<?="\n"?>
<?=$passwordResetKey?><?="\n"?>
<?="\n"?>
<?=__('... into the Password Request Key field at', true) . ': '?><?="\n"?>
<?=' http://' . $serverName . '/users/new_password'?>