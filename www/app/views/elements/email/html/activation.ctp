<?=__('Your User Account still needs to be activated. Please click on this Activation Link:', true)?><?=BR?>
<?='<a href="http://' . $serverName . '/users/activate/' . $activationKey . '">'
	. 'http://' . $serverName . '/users/activate/' . $activationKey . '</a>'?><?=BR?>
<?=__('If that does not work, copy and paste over this Activation Key', true) . ': '?><?=BR?>
<?=BR?>
<?=$activationKey?><?=BR?>
<?=BR?>
<?=__('... into the Activation Key field at', true) . ': '?><?=BR?>
<?=' http://' . $serverName . '/users/activate'?>