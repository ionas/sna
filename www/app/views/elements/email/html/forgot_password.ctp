<?=__('Request a new password for ', true) . $domainName . '!'?><br>
<br>
<?=__('To request a new password, please click on this Link:', true)?><br>
<?='<a href="http://' . $serverName . '/users/new_password/' . $forgotPasswordKey . '">'
	. 'http://' . $serverName . '/users/new_password/' . $forgotPasswordKey . '</a>'?><br>
<?=__('If that does not work, copy and paste over this Password Request Key', true) . ': '?><br>
<br>
<?=$forgotPasswordKey?><br>
<br>
<?=__('... into the Password Request Key field at', true) . ': '?><br>
<?=' http://' . $serverName . '/users/new_password'?>