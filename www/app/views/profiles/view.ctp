<div class="profiles view">
<h2><?php echo $profile['Profile']['nickname']; ?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
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
		<?php if($authedUser['Profile']['id'] != $profile['Profile']['id']): ?>
		<li><?php echo $html->link(__('Message', true), array('controller' => 'messages', 'action' => 'send', $profile['Profile']['id'])); ?> </li>
		<li><?php echo $html->link(__('Make Friends?', true), array('action '=> 'make_friends', $profile['Profile']['id'])); ?> </li>
		<?php endif;?>
	</ul>
</div>
<div class="related">
	<h3><?php __('Shoutbox');?></h3>
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
