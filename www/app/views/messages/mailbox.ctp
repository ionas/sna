<div class="messages mailbox">
	<h2><?php __('Messages')?> &mdash; <?=$messagesTitle?></h2>
	<div class="menu">
		<ul>
			<li><?=$html->link(__('Inbox', true) , array('controller'=> 'messages', 'action' => 'mailbox', 'inbox'))?> 
				<ul>
					<li><?=$html->link(__('Unread', true)   , array('controller'=> 'messages', 'action' => 'mailbox', 'unread'))?></li>
					<li><?=$html->link(__('Unreplied', true), array('controller'=> 'messages', 'action' => 'mailbox', 'unreplied'))?></li>
					<li><?=$html->link(__('Read', true)     , array('controller'=> 'messages', 'action' => 'mailbox', 'read'))?></li>
				</ul>
			</li>
			<li><?=$html->link(__('Sent', true)  , array('controller'=> 'messages', 'action' => 'mailbox', 'sent'))?></li>
			<li><?=$html->link(__('Trash', true) , array('controller'=> 'messages', 'action' => 'mailbox', 'trash'))?></li>
		</ul>
	</div>
	<div class="data">
		<?php $paginator->options(array('url' => $this->passedArgs))?>
		<?=$this->element('pagination_navigation', array('location' => 'top'))?> 
		<table cellpadding="0" cellspacing="0">
			<tr>
				<?php if ($filter == 'sent'):?>
				<th class="toFrom"><?=$paginator->sort(__('To', true),   'to_profile_id')?> 
					<?=$paginator->sort(__('Date', true), 'created')?></th>
				<?php else:?>
				<th class="toFrom"><?=$paginator->sort(__('From', true), 'from_profile_id')?> 
					<?=$paginator->sort(__('Date', true), 'created')?></th>
				<?php endif?>
				<?php if ($filter == 'trash'):?>
				<th class="toFrom"><?=$paginator->sort(__('To', true),   'to_profile_id')?></th>
				<?php endif?>
				<th class="subject"><?=$paginator->sort(__('Subject', true), 'subject')?></th>
				<th class="actions"><?php __('Actions')?></th>
			</tr>
<?php if (count($messages) == 0) { ?>
			<tr>
				<td colspan="5">
					<em>
						<?=String::insert(
							__('No :messagesTitle messages.', true),
								array('messagesTitle' => $messagesTitle))?> 
					</em>
				</td>
			</tr>
<?php
}
$i = 0;
foreach ($messages as $message):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?> 
			<tr<?=$class?>>
				<?php if ($filter == 'sent'):?>
				<td><?=$html->link($message['ToProfile']['nickname'], array('controller' => 'profiles', 'action' => 'view', $message['Message']['to_profile_id']))?> 
					<br /><?=__('On');?> <?=substr($message['Message']['created'], 0, -3)?></td>
				<?php else:?>
				<td><?=$html->link($message['FromProfile']['nickname'], array('controller' => 'profiles', 'action' => 'view', $message['Message']['from_profile_id']))?> 
					<br /><?=__('On');?> <?=substr($message['Message']['created'], 0, -3)?></td>
				<?php endif?>
				<?php if ($filter == 'trash'):?>
				<td><?=$html->link($message['ToProfile']['nickname'], array('controller' => 'profiles', 'action' => 'view', $message['Message']['to_profile_id']))?></td>
				<?php endif?>
				<td class="messageSubject">
					<?=$message['Message']['subject']?>
				</td>
				<td class="actions" rowspan="2">
					<?php if ($message['Message']['profile_id'] != $message['Message']['from_profile_id']):?>
						<?=$html->link(__('Reply', true), array('action' => 'reply', $message['Message']['id']), array('class' => 'iconLinkButton messageReply'))?> 
					<?php endif?>
					<?php if ($message['Message']['is_trashed'] == 1):?>
						<?=$html->link(__('Restore', true), array('action' => 'restore', $message['Message']['id']), array('class' => 'iconLinkButton messageRestore'))?> 
						<?=$html->link(__('Remove', true), array('action' => 'remove', $message['Message']['id']), array('class' => 'iconLinkButton messageRemove'), __('Are you sure you want to remove', true).' "' . $message['Message']['subject'] . '" permanently?')?> 
					<?php else:?>
						<?=$html->link(__('Move to Trash', true), array('action' => 'trash', $message['Message']['id']), array('class' => 'iconLinkButton messageTrash'), __('Are you sure you want to move', true).' "' . $message['Message']['subject'] . '" to the trash.')?> 
					<?php endif?>
				</td>
			</tr>
			<tr<?=$class?>>
				<td colspan="<?php echo ($filter == "trash") ? '4' : '3'?>" class="messageBody">
					<?=nl2br($message['Message']['body'])?>
				</td>
			</tr>
<?php endforeach?>
		</table>
		<?=$this->element('pagination_navigation', array('location' => 'bottom'))?> 
	</div>
</div>