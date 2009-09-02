<div class="messages index">
<h2><?php __('Messages')?> &mdash; <?=$messagesTitle?></h2>
<?$paginator->options(array('url' => $this->passedArgs))?>
<?php
// $paginateOptions = array('url' => array($this->passedArgs['0'])) */ $paginateOptions = array();
// // for urls like http://www.example.com/en/controller/action
// // that are routed as Router::connect('/:lang/:controller/:action/*', array(),array('lang'=>'ta|en'));
// $paginator->options(array('url'=>array_merge(array('lang'=>$lang),$this->passedArgs)));
?>
<br />
<div class="paging">
	<?=$paginator->prev('← '.__('previous', true), array(), null, array('class' => 'disabled'))?>
	<?=$paginator->numbers(array('separator' => ''))?>
	<?=$paginator->next(__('next', true).'  →', array(), null, array('class' => 'disabled'))?>
</div>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?=$paginator->sort(__('Subject', true), 'subject')?></th>
	<?php if ($filter != 'sent'):?>
	<th><?=$paginator->sort(__('From', true),    'from_profile_id')?></th>
	<?php endif?>
	<th><?=$paginator->sort(__('Date', true),    'created')?></th>
	<th><?=$paginator->sort(__('Message', true), 'body')?></th>
	<th class="actions"><?php __('Actions')?></th>
</tr>
<?php
if (empty($messages[0])) {
?>
	<tr>
		<td colspan="5">
			<em>
				<?=__('No ', true)?>
				<?=$messagesTitle?>
				<?=__(' messages.', true)?>
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
		<td style="width: 20em;">
			<?=$message['Message']['subject']?>
		</td>
		<?php if ($filter != 'sent'):?>
		<td style="width: 6em;">
			<?=$html->link($message['Message']['from_profile_id'], array('controller' => 'profiles', 'action' => 'view', $message['Message']['from_profile_id']))?>
		</td>
		<?php endif?>
		<td style="width: 12em;">
			<?=substr($message['Message']['created'], 0, -3)?>
		</td>
		<td class="clickForMore">
			<?=$message['Message']['body'], 0, 5?>
		</td>
		<td class="actions">
			<?=$html->link(__('View', true), array('action'=>'view', $message['Message']['id']))?>
			<?php if ($message['Message']['profile_id'] != $message['Message']['from_profile_id']):?>
				<?=$html->link(__('Reply', true), array('action'=>'reply', $message['Message']['id']))?>
			<?php endif?>
			<?php if ($message['Message']['is_trashed'] == 1):?>
				<?=$html->link(__('Restore', true), array('action'=>'restore', $message['Message']['id']))?>
				<?=$html->link(__('Remove', true), array('action'=>'delete', $message['Message']['id']), null, __('Are you sure you want to delete', true).' #' . $message['Message']['id'])?>
			<?php else:?>
				<?=$html->link(__('Move to Trash', true), array('action'=>'trash', $message['Message']['id']), null, __('Are you sure you want to move', true).' #' . $message['Message']['id'] . ' to the trash.')?>
			<?php endif?>
		</td>
	</tr>
<?php endforeach?>
</table>
</div>
<div class="paging">
	<?=$paginator->prev('← '.__('previous', true), array(), null, array('class' => 'disabled'))?>
	<?=$paginator->numbers(array('separator' => ''))?>
	<?=$paginator->next(__('next', true).'  →', array(), null, array('class' => 'disabled'))?>
</div>
<div class="actions">
	<ul>
		<li><?=$html->link(__('Recieved', true) , array('controller'=> 'messages', 'action' => 'mailbox', 'recieved'))?> </li>
		<li><?=$html->link(__('Unread', true)   , array('controller'=> 'messages', 'action' => 'mailbox', 'unread'))?> </li>
		<li><?=$html->link(__('Unreplyed', true), array('controller'=> 'messages', 'action' => 'mailbox', 'unreplied'))?> </li>
		<li><?=$html->link(__('Read', true)     , array('controller'=> 'messages', 'action' => 'mailbox', 'read'))?> </li>
		<li><?=$html->link(__('Sent', true)     , array('controller'=> 'messages', 'action' => 'mailbox', 'sent'))?> </li>
		<li><?=$html->link(__('Trash', true)    , array('controller'=> 'messages', 'action' => 'mailbox', 'trashed'))?> </li>
	</ul>
	<ul>
		<li><?=$html->link(__('Back', true), array('action'=>'back'))?> </li>
	</ul>
</div>