<div class="connections summary">
<h2><?php __('Established connections')?></h2>
<?php $paginator->options(array('url' => $this->passedArgs))?>
<?=$this->element('pagination_navigation', array('location' => 'top'))?> 
<table>
<tr>
	<th><?=$paginator->sort(___('Date'), 'modified')?></th>
	<th><?=$paginator->sort(___('Target'), 'to_profile_id')?></th>
	<th><?=$paginator->sort(___('Type'), 'type')?></th>
	<th><?__('Flags')?></th>
	<th class="actions"><?php __('Actions')?></th>
</tr>
<?php
$i = 0;
foreach ($connections as $connection):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?=$class?>>
		<td>
			<?=$myhtml->dateMedium($connection['Connection']['modified'])?>
		</td>
		<td>
			<?=$html->link($connection['ToProfile']['nickname'], array('controller' => 'profiles', 'action' => 'view', $connection['ToProfile']['id']))?>
		</td>
		<td>
			<?=ucfirst(__d('additions', $connection['Connection']['type'], true))?>
		</td>
		<td style="text-align: left;">
			Request: <?=$connection['Connection']['is_request']?><br />
			Mutual: <?=$connection['Connection']['is_mutual']?><br />
			Hidden: <?=$connection['Connection']['is_hidden']?><br />
		</td>
		<td class="actions">
			<?=$secure->link(__('Remove', true), array('action' => 'delete', $connection['Connection']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $connection['Connection']['id']))?>
		</td>
	</tr>
<?php endforeach?>
</table>
</div>
<?=$this->element('pagination_navigation', array('location' => 'bottom'))?> 
