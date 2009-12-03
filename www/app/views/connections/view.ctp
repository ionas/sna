<div class="connections view">
<h2><?php  __('Connection');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $connection['Connection']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $connection['Connection']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $connection['Connection']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Profile'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($connection['Profile']['nickname'], array('controller'=> 'profiles', 'action'=>'view', $connection['Profile']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('To Profile'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($connection['ToProfile']['nickname'], array('controller'=> 'profiles', 'action'=>'view', $connection['ToProfile']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $connection['Connection']['type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Request'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $connection['Connection']['is_request']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Mutual'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $connection['Connection']['is_mutual']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Hidden'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $connection['Connection']['is_hidden']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Connection', true), array('action'=>'edit', $connection['Connection']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Connection', true), array('action'=>'delete', $connection['Connection']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $connection['Connection']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Connections', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Connection', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Profiles', true), array('controller'=> 'profiles', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Profile', true), array('controller'=> 'profiles', 'action'=>'add')); ?> </li>
	</ul>
</div>
