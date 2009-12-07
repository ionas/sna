<?=$this->element('../pages/about_short')?>
<h2>Readme</h2>
<?=nl2br(htmlentities(file_get_contents('../../../README')))?>
<h2>License</h2>
<?=nl2br(htmlentities(file_get_contents('../../../gpl-3.0.txt')))?>
