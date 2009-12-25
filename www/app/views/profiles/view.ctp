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
	<?php if (!empty($authedUser) and $authedUser['Profile']['id'] != $profile['Profile']['id']): ?>
		<ul>
			<li><?php if ($messagingAuthentification):?>
				<?=$html->link(
					___('Send Message'), array(
						'controller' => 'messages', 'action' => 'send', $profile['Profile']['id']))
				?><?php else:?>
					<p><em>
					<?php __('You require authentification if you want to send a message to this profile.')?>
					</em></p>
				<?php endif?>
			</li>
		</ul>
		<?=BR?>
		<?php if (!empty($possibleConnections)):?>
			<?php require('possible_connections.ctp');?>
		<?php endif?>
	<?php endif?>
</div>
<div class="related">
	<?php if (!empty($authedUser)): ?>
		<?php if (!empty($shouts)):?>
			<?php require('shouts.ctp');?>
		<?php endif?>
		<?php if (($authedUser['Profile']['id'] == $profile['Profile']['id']
				or $shoutingAuthentification)):?>
			<?php require('shout_to.ctp');?>
		<?php endif?>
		<?php if (($authedUser['Profile']['id'] != $profile['Profile']['id']
				and !$shoutingAuthentification)):?>
			<p class="notification"><em>
				<?php __('You require authentification if you want to shout to this profile.')?>
			</em></p>
		<?php endif?>
	<?php endif?>
</div>
