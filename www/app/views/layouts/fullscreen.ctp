<?php require(LAYOUTS . 'app_header.snip')?>
		<div id="content">
			<?php $session->flash()?>
			<br style="visibility: hidden; height: 0; width: 0; border:0; margin: 0; padding: 0; display: inline; clear: both" />
			<?=$content_for_layout?>
		</div>
<?php require(LAYOUTS . 'app_footer.snip')?>