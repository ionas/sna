<h2>Welcome</h2>
<p>
Welcome to SNA. Login or Register below. It's free.
</p>
<div id="start_boxes">
	<div id="register_box">
		<?=$this->requestAction(array('controller' => 'users', 'action' => 'register'), array('return'));?>
	</div>
	<div id="login_box">
		<?=$this->requestAction(array('controller' => 'users', 'action' => 'login'), array('return'));?>
	</div>
	<br class="clear" />
</div>
<?=$this->requestAction('/pages/about_short', array('return'));?>
<h2>Readme</h2>
<?=nl2br(file_get_contents('../../../README'))?>
<h2>License</h2>
<?=nl2br(htmlentities(file_get_contents('../../../gpl-3.0.txt')))?>