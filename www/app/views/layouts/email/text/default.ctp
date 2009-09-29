<?=$content_for_layout?><?="\n"?>
<?="\n"?>
--<?="\n"?>
<?php
$domainName = env('SERVER_NAME');
if (strpos($domainName, 'www.') === 0) {
	$domainName = substr($domainName, 4);
}
echo $domainName;
?><?="\n"?>
<?="\n"?>
<?=__('This message has been generated. Do not reply to this message.', true)?><?="\n"?>
<?=__('If you require support, visit', true)?> <?=strip_tags($html->link(__('http://' . env('SERVER_NAME') . '/pages/support', true),
		array('controller' => 'pages', 'action' => 'display', 'http://' . env('SERVER_NAME') . '/support')))?>