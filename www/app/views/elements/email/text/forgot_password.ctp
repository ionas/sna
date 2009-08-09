<?=__('Request a new password for ', true) . $domainName . '!'?><?="\n"?>
<?="\n"?>
<?=__('To request a new password, please click on this Link:', true)?><?="\n"?>
<?='<a href="http://' . $serverName . '/users/retrieve_new_password/' . $forgotPasswordKey . '">'
	. 'http://' . $serverName . '/users/retrieve_new_password/' . $forgotPasswordKey . '</a>'?><?="\n"?>
<?=__('If that does not work, copy and paste over this Activation Key', true) . ': '?><?="\n"?>
<?="\n"?>
<?=$forgotPasswordKey?><?="\n"?>
<?="\n"?>
<?=__('... into the Activation Key field at', true) . ': '?><?="\n"?>
<?=' http://' . $serverName . '/users/retrieve_new_password'?>