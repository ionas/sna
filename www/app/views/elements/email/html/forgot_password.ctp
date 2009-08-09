<?=__('Request a new password for ', true) . $domainName . '!'?><br>
<br>
<?=__('To request a new password, please click on this Link:', true)?><br>
<?='<a href="http://' . $serverName . '/users/retrieve_new_password/' . $forgotPasswordKey . '">'
	. 'http://' . $serverName . '/users/retrieve_new_password/' . $forgotPasswordKey . '</a>'?><br>
<?=__('If that does not work, copy and paste over this Activation Key', true) . ': '?><br>
<br>
<?=$forgotPasswordKey?><br>
<br>
<?=__('... into the Activation Key field at', true) . ': '?><br>
<?=' http://' . $serverName . '/users/retrieve_new_password'?>