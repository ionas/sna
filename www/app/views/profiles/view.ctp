<div class="profiles view">
<h2><?php  __('Profile');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $profile['Profile']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $profile['Profile']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $profile['Profile']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($profile['User']['username'], array('controller'=> 'users', 'action'=>'view', $profile['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Deleted'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $profile['Profile']['is_deleted']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Hidden'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $profile['Profile']['is_hidden']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nickname'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $profile['Profile']['nickname']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Birthday'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $profile['Profile']['birthday']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $profile['Profile']['location']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Profile', true), array('action'=>'edit', $profile['Profile']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Profile', true), array('action'=>'delete', $profile['Profile']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $profile['Profile']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Profiles', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Profile', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Messages', true), array('controller'=> 'messages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Message', true), array('controller'=> 'messages', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Shouts', true), array('controller'=> 'shouts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Shout', true), array('controller'=> 'shouts', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Messages');?></h3>
	<?php if (!empty($profile['Message'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Profile Id'); ?></th>
		<th><?php __('From Profile Id'); ?></th>
		<th><?php __('Subject'); ?></th>
		<th><?php __('Body'); ?></th>
		<th><?php __('Is Read'); ?></th>
		<th><?php __('Is Replied'); ?></th>
		<th><?php __('Is Trashed'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($profile['Message'] as $message):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $message['id'];?></td>
			<td><?php echo $message['created'];?></td>
			<td><?php echo $message['modified'];?></td>
			<td><?php echo $message['user_id'];?></td>
			<td><?php echo $message['profile_id'];?></td>
			<td><?php echo $message['from_profile_id'];?></td>
			<td><?php echo $message['subject'];?></td>
			<td><?php echo $message['body'];?></td>
			<td><?php echo $message['is_read'];?></td>
			<td><?php echo $message['is_replied'];?></td>
			<td><?php echo $message['is_trashed'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'messages', 'action'=>'view', $message['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'messages', 'action'=>'edit', $message['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'messages', 'action'=>'delete', $message['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $message['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Message', true), array('controller'=> 'messages', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Shouts');?></h3>
	<?php if (!empty($profile['Shout'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Profile Id'); ?></th>
		<th><?php __('From Profile Id'); ?></th>
		<th><?php __('Body'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($profile['Shout'] as $shout):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $shout['id'];?></td>
			<td><?php echo $shout['created'];?></td>
			<td><?php echo $shout['modified'];?></td>
			<td><?php echo $shout['user_id'];?></td>
			<td><?php echo $shout['profile_id'];?></td>
			<td><?php echo $shout['from_profile_id'];?></td>
			<td><?php echo $shout['body'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'shouts', 'action'=>'view', $shout['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'shouts', 'action'=>'edit', $shout['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'shouts', 'action'=>'delete', $shout['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $shout['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Shout', true), array('controller'=> 'shouts', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
