<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Has Accepted Tos'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['has_accepted_tos']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Hidden'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['is_hidden']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Disabled'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['is_disabled']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Deleted'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['is_deleted']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nickname'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['nickname']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Activation Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['activation_key']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit User', true), array('action'=>'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete User', true), array('action'=>'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List User Options', true), array('controller'=> 'user_options', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User Option', true), array('controller'=> 'user_options', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Messages', true), array('controller'=> 'messages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Message', true), array('controller'=> 'messages', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Shouts', true), array('controller'=> 'shouts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Shout', true), array('controller'=> 'shouts', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related User Options');?></h3>
	<?php if (!empty($user['UserOption'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Key'); ?></th>
		<th><?php __('Value'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['UserOption'] as $userOption):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $userOption['id'];?></td>
			<td><?php echo $userOption['modified'];?></td>
			<td><?php echo $userOption['user_id'];?></td>
			<td><?php echo $userOption['key'];?></td>
			<td><?php echo $userOption['value'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'user_options', 'action'=>'view', $userOption['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'user_options', 'action'=>'edit', $userOption['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'user_options', 'action'=>'delete', $userOption['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userOption['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New User Option', true), array('controller'=> 'user_options', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Messages');?></h3>
	<?php if (!empty($user['Message'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Form User Id'); ?></th>
		<th><?php __('Subject'); ?></th>
		<th><?php __('Body'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Message'] as $message):
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
			<td><?php echo $message['form_user_id'];?></td>
			<td><?php echo $message['subject'];?></td>
			<td><?php echo $message['body'];?></td>
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
	<?php if (!empty($user['Shout'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('From User Id'); ?></th>
		<th><?php __('Text'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Shout'] as $shout):
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
			<td><?php echo $shout['from_user_id'];?></td>
			<td><?php echo $shout['text'];?></td>
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
