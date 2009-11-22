<div class="connections summary">
<h2><?php __('Your connections to');?> <?=$toProfileData['ToProfile']['nickname']?></h2>
<?php $paginator->options(array('url' => $this->passedArgs))?>
<?=$this->element('pagination_navigation', array('location' => 'top'))?> 
<table>
<tr>
	<th><?=$paginator->sort(__('Set on', true), 'created');?></th>
	<th><?=$paginator->sort('type');?></th>
	<th><?=$paginator->sort('value');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($connections as $connection):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?=$class;?>>
		<td>
			<?=$connection['Connection']['created']?>
		</td>
		<td>
			<?=Inflector::humanize($connection['Connection']['type'])?>
		</td>
		<td>
			<?php
			if ($connection['Connection']['value'] === '1'): echo __('Yes', true);
			elseif ($connection['Connection']['value'] === '0'): echo __('No', true); 
			else: echo $connection['Connection']['value'];
			endif?>
		</td>
		<td>
			<?=$form->create('Connection', array('action' => 'cancel', 'url' => array($connection['Connection']['type'],  $connection['Connection']['to_profile_id'])))?>
			<?=$form->submit(__('Cancel', true), array('name' => 'cancel'))?>
			<?=$form->end()?>
		</td>
	</tr>
<?php endforeach?>
</table>
</div>
<?=$this->element('pagination_navigation', array('location' => 'bottom'))?>