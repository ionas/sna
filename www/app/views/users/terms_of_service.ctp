<div class="users form">
<?=$form->create('User', array('action' => 'terms_of_service'))?>
<h2>Terms of Service User Account Setting</h2>
<p>
<?php
if($hasAcceptedTos != 1) {
	echo __('Currently you do not have accepted the Terms of Service.', true);
} else {
	echo __('Currently you have accepted the Terms of Service.', true);
}
?>
</p>
<?=$termsOfService?>
<p>
For later reference, you can find a copy of our <?=$html->link(__('Terms of Service', true), array('controller'=> 'pages', 'action'=>'display', 'public/terms_of_service'))?> at <?=$html->link(env('SERVER_NAME') . '/public/terms_of_service', array('controller'=> 'pages', 'action'=>'display', 'public/terms_of_service'))?>, all time.
</p>
<?php
if($hasAcceptedTos != 1) {
	echo $form->submit(__('Accept', true), array('name' => 'accept'));
} else {
	echo $form->submit(__('Decline', true), array('name' => 'decline'));
}
?>
</div>