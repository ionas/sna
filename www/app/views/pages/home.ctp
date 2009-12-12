<?=$this->element('../pages/about_short')?>
<h2>Readme</h2>
<?=nl2br(htmlentities(file_get_contents('../../../README')))?>
<h2>Todo</h2>
<?=nl2br(htmlentities(file_get_contents('../../../TODO')))?>
<h2>Bugs</h2>
<?=nl2br(htmlentities(file_get_contents('../../../BUGS')))?>
<h2>Enhancements</h2>
<?=nl2br(htmlentities(file_get_contents('../../../ENHANCEMENTS')))?>
<h2>Cake Bugs &amp; Enhancements</h2>
<?=nl2br(htmlentities(file_get_contents('../../../CAKE_BUGS_AND_ENHANCEMENTS')))?>
<h2>License</h2>
<?=nl2br(htmlentities(file_get_contents('../../../gpl-3.0.txt')))?>
