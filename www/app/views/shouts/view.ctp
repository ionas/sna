<div class="shouts view">
<h2><?php  __('Shout');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shout['Shout']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($shout['User']['id'], array('controller'=> 'users', 'action'=>'view', $shout['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Text'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $shout['Shout']['text']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Shout', true), array('action'=>'edit', $shout['Shout']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Shout', true), array('action'=>'delete', $shout['Shout']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $shout['Shout']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Shouts', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Shout', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>
