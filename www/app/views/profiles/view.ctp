<div class="profiles view">
<h2><?=$profile['Profile']['nickname']; ?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"'?>
		<dt<?php if ($i % 2 == 0) echo $class?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class?>>
			<?=$profile['Profile']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class?>>
			<?=$profile['Profile']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class?>><?php __('Birthday'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class?>>
			<?=$profile['Profile']['birthday']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class?>><?php __('Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class?>>
			<?=$profile['Profile']['location']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<?php if (!empty($authedUser) and $authedUser['Profile']['id'] != $profile['Profile']['id']): ?>
		<li><?=$html->link(__('Ask 4 Messaging', true), array('controller' => 'connections', 'action' => 'request', 'messaging_authentification', $profile['Profile']['id'])); ?> </li>
		<li><?=$html->link(__('Ask 4 Shouting', true), array('controller' => 'connections', 'action' => 'request', 'messaging_shouting', $profile['Profile']['id'])); ?> </li>
		<li><?=$html->link(__('Follow', true), array('controller' => 'connections', 'action' => 'follow', $profile['Profile']['id'])); ?> </li>
		<li><?=$html->link(__('Buddies?', true), array('controller' => 'connections', 'action' => 'friends', $profile['Profile']['id'])); ?> </li>
		<li><?=$html->link(__('Ignore', true), array('controller' => 'connections', 'action' => 'ignore', $profile['Profile']['id'])); ?> </li>
		<?php endif?>
	</ul>
</div>
<div class="related">
	<?php if (!empty($authedUser)): ?>
		<?php if (!empty($shouts)):?>
			<?php require('shouts.ctp')?>
		<?php endif?>
		<?php if(!empty($authedUser)):?>
			<?php require('shout_to.ctp')?>
		<?php endif?>
	<?php endif?>
</div>
