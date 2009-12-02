<div class="connections index">
<h2><?php __('Connections');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('profile_id');?></th>
	<th><?php echo $paginator->sort('to_profile_id');?></th>
	<th><?php echo $paginator->sort('type');?></th>
	<th><?php echo $paginator->sort('mutual');?></th>
	<th><?php echo $paginator->sort('hidden');?></th>
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
	<tr<?php echo $class;?>>
		<td>
			<?php echo $connection['Connection']['id']; ?>
		</td>
		<td>
			<?php echo $connection['Connection']['created']; ?>
		</td>
		<td>
			<?php echo $html->link($connection['Profile']['nickname'], array('controller'=> 'profiles', 'action'=>'view', $connection['Profile']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($connection['ToProfile']['nickname'], array('controller'=> 'profiles', 'action'=>'view', $connection['ToProfile']['id'])); ?>
		</td>
		<td>
			<?php echo $connection['Connection']['type']; ?>
		</td>
		<td>
			<?php echo $connection['Connection']['mutual']; ?>
		</td>
		<td>
			<?php echo $connection['Connection']['hidden']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $connection['Connection']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $connection['Connection']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $connection['Connection']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $connection['Connection']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Connection', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Profiles', true), array('controller'=> 'profiles', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Profile', true), array('controller'=> 'profiles', 'action'=>'add')); ?> </li>
	</ul>
</div>
