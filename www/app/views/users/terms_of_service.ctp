<div class="users form">
<?=$form->create('User', array('action' => 'terms_of_service'))?>
<h2>Terms of Service User Account Setting</h2>
<p>
<?php
if ($hasAcceptedTos != 1) {
	echo String::insert(
		__('Currently :b you do not accept :/b the Terms of Service.', true),
		array('b' => '<strong>', '/b' => '</strong>'));
} else {
	echo String::insert(
		__('Currently :b you do accept :/b the Terms of Service.', true),
		array('b' => '<strong>', '/b' => '</strong>'));
}
?>
</p>
<fieldset id="tosWindow">
<?=$termsOfService?>
<br>
<p>
For later reference, you can find a copy of our <?=$html->link(__('Terms of Service', true), array('controller'=> 'pages', 'action'=>'display', 'public/terms_of_service'))?> at <?=$html->link(env('SERVER_NAME') . '/terms_of_service', array('controller'=> 'pages', 'action'=>'display', 'public/terms_of_service'))?>, all time.
</p>
</fieldset>
<?php
if ($hasAcceptedTos != 1) {
	echo $form->submit(__('Accept Terms of Service', true), array('name' => 'accept'));
} else {
	echo $form->submit(__('Decline Terms of Service', true), array('name' => 'decline'));
}
?>
</div>