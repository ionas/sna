<!DOCTYPE html PUBLIC
	"-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="top">
<head>
	<?=$html->charset()?>
	<title>Social Network Application &middot; <?=$title_for_layout?></title>
	<?=$html->meta('icon')?> 
	<?=$html->css('cake.generic')?> 
	<?=$html->css('app.generic')?> 
	<?=$html->css('app.layout')?> 
	<?=$html->css('app.form')?> 
	<?=$html->css('app.jquery')?> 
	<?=@$html->css($controller_css_for_layout)?> 
	<?=@$html->css($view_css_for_layout)?> 
	<?=$javascript->link('jquery-1.3.2')?> 
	<?=$javascript->link('jquery.timers')?> 
	<?=$javascript->link('jquery.smoothScroll')?> 
	<?=$javascript->link('app.jquery')?> 
	<?=$scripts_for_layout?> 
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?=$html->link(__('Social Network Application', true), '/')?></h1>
			<div id="langSelector">
				<p><?=$html->link('In English', array('lang' => 'eng'))?></p>
				<p><?=$html->link('In Deutsch', array('lang' => 'deu'))?></p>
			</div>
		</div>
		<div id="content">
			<?php $session->flash()?>
			<hr style="visibility: hidden; height: 0; width: 0; border:0; margin: 0; padding: 0; display: inline; clear: both" />
			<?=$content_for_layout?>
		</div>
		<div id="footer">
			<a href="#top">&uarr;</a>
			<?=$html->link(
				$html->image('cake.power.gif', array(
						'alt'=> __("Cake Power", true),
						'border' => '0')),
					'http://www.cakephp.org',
					array('target'=>'_blank'), null, false
				)?>
		</div>
	</div>
	<?=$cakeDebug?>
	</body>
</html>
