<?php require(LAYOUTS . 'app_header.snip')?>
		<div id="content">
			<?php $session->flash()?>
			<?=BRCLEAR?>
			<?=$content_for_layout?>
		</div>
<?php require(LAYOUTS . 'app_footer.snip')?>