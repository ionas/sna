<?=__('Your User Account still needs to be activated. Please click on this Activation Link:', true)?><br>
<?='<a href="http://' . $serverName . '/users/activate/' . $activationKey . '">'
	. 'http://' . $serverName . '/users/activate/' . $activationKey . '</a>'?><br>
<?=__('If that does not work, copy and paste over this Activation Key', true) . ': '?><br>
<br>
<?=$activationKey?><br>
<br>
<?=__('... into the Activation Key field at', true) . ': '?><br>
<?=' http://' . $serverName . '/users/activate'?>