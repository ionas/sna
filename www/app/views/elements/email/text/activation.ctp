<?=__('Your User Account needs to be activated. Please click on this Activation Link:', true)?><?="\n"?>
<?='<a href="http://' . $serverName . '/users/activate/' . $activationKey . '">'
	. 'http://' . $serverName . '/users/activate/' . $activationKey . '</a>'?><?="\n"?>
<?=__('If that does not work, copy and paste over this Activation Key', true) . ': '?><?="\n"?>
<?="\n"?>
<?=$activationKey?><?="\n"?>
<?="\n"?>
<?=__('... into the Activation Key field at', true) . ': '?><?="\n"?>
<?=' http://' . $serverName . '/users/activate'?>