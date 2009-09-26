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
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Deleted'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['is_deleted']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Disabled'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['is_disabled']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Has Accepted Tos'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['has_accepted_tos']; ?>
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
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Last Login'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['last_login']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password Reset Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['password_reset_key']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Change Email Adress', true), array('action' => 'change_email')); ?> </li>
		<li><?php echo $html->link(__('Change Password', true), array('action' => 'change_password')); ?> </li>
		<li><?php echo $html->link(__('Delete User', true), array('action'=>'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $html->link(__('List User Options', true), array('controller'=> 'user_options', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User Option', true), array('controller'=> 'user_options', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Profiles');?></h3>
	<?php if (!empty($user['Profile'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Is Deleted'); ?></th>
		<th><?php __('Is Hidden'); ?></th>
		<th><?php __('Nickname'); ?></th>
		<th><?php __('Birthday'); ?></th>
		<th><?php __('Location'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
		<tr<?php echo $class;?>>
			<td><?php echo $user['Profile']['id'];?></td>
			<td><?php echo $user['Profile']['created'];?></td>
			<td><?php echo $user['Profile']['modified'];?></td>
			<td><?php echo $user['Profile']['user_id'];?></td>
			<td><?php echo $user['Profile']['is_deleted'];?></td>
			<td><?php echo $user['Profile']['is_hidden'];?></td>
			<td><?php echo $user['Profile']['nickname'];?></td>
			<td><?php echo $user['Profile']['birthday'];?></td>
			<td><?php echo $user['Profile']['location'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Delete', true), array('controller'=> 'profiles', 'action'=>'delete', $user['Profile']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['Profile']['id'])); ?>
			</td>
		</tr>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('Edit Profile', true), array('controller'=> 'profiles', 'action'=>'edit', $user['Profile']['id']));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related User Options');?></h3>
	<?php if (!empty($user['Option'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Key'); ?></th>
		<th><?php __('Value'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Option'] as $userOption):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $userOption['id'];?></td>
			<td><?php echo $userOption['created'];?></td>
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