<?php require(LAYOUTS . 'app_header.snip')?>
<?php require(LAYOUTS . 'app_menu.snip')?>
		<div id="content">
			<?=$this->Session->flash()?>
			<?=BRCLEAR?>
			<?=$content_for_layout?>
		</div>
<?php require(LAYOUTS . 'app_footer.snip')?>