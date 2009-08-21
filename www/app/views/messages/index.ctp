<div class="messages index">
<h2><?php __('Messages');?> &mdash; <?php echo $message_center_title; ?></h2>
<?php
	$paginate_options = array();
	if(isset($this->passedArgs['user_id'])) {
		$paginate_options = array('url' => array('user_id:' . $this->passedArgs['user_id'] . '/' . 'message_filter:' . $this->passedArgs['message_filter']));
	}
?>
<br />
<div class="paging">
	<?php echo $paginator->prev('← '.__('previous', true), array(), null, array('class' => 'disabled'));?>
	<?php echo $paginator->numbers(array('separator' => ''));?>
	<?php echo $paginator->next(__('next', true).'  →', array(), null, array('class' => 'disabled'));?>
</div>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('Date', true),               'created',           $paginate_options);?></th>
	<th><?php echo $paginator->sort(__('From', true),               'sender_user_id',    $paginate_options);?></th>
	<th><?php echo $paginator->sort(__('Subject', true),            'subject',           $paginate_options);?></th>
	<th><?php echo $paginator->sort(__('Message', true),            'body',              $paginate_options);?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
if(empty($messages[0])) {
?>
	<tr>
		<td colspan="5">
			<em>
				<?php echo __('No ', true); ?>
				<?php echo $message_center_title; ?>
				<?php echo __(' messages.', true); ?>
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
	<tr<?php echo $class;?>>
		<td style="width: 12em;">
			<?php echo substr($message['Message']['created'], 0, -3)?>
		</td>
		<td style="width: 6em;">
			<?php echo $html->link($message['Message']['sender_user_id'], array('controller'=> 'users', 'action'=>'view', 'user_id:' . $message['Message']['sender_user_id'])); ?>
		</td>
		<td style="width: 20em;">
			<?php echo $message['Message']['subject']?>
		</td>
		<td>
			<?php echo $html->link(substr($message['Message']['body'], 0, $small_text_length),
			                       array('action' => 'view', 'message_id:' . $message['Message']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', 'message_id:' . $message['Message']['id'])); ?>
			<?php if($message['User']['id'] != $message['Message']['sender_user_id']):?>
				<?php echo $html->link(__('Reply', true), array('action'=>'reply', 'message_id:' . $message['Message']['id'])); ?>
			<?php endif;?>
			<?php if($message['Message']['is_trashed'] == 1):?>
				<?php echo $html->link(__('Restore', true), array('action'=>'restore', 'message_id:' . $message['Message']['id'])); ?>
				<?php echo $html->link(__('Remove', true), array('action'=>'delete', 'message_id:' . $message['Message']['id']), null, __('Are you sure you want to delete', true).' #' . $message['Message']['id']); ?>
			<?php else:?>
				<?php echo $html->link(__('Move to Trash', true), array('action'=>'trash', 'message_id:' . $message['Message']['id']), null, __('Are you sure you want to move', true).' #' . $message['Message']['id'] . ' to the trash.'); ?>
			<?php endif;?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('← '.__('previous', true), array(), null, array('class' => 'disabled'));?>
	<?php echo $paginator->numbers(array('separator' => ''));?>
	<?php echo $paginator->next(__('next', true).'  →', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<?php if(isset($this->passedArgs['user_id'])):?>
		<li><?php echo $html->link(__('Recieved', true)  .' '.__('Messages', true), array('controller'=> 'messages', 'action'=>'index', 'user_id:' . $this->passedArgs['user_id'] . '/message_filter:recieved')); ?> </li>
		<li><?php echo $html->link(__('Unread', true)    .' '.__('Messages', true), array('controller'=> 'messages', 'action'=>'index', 'user_id:' . $this->passedArgs['user_id'] . '/message_filter:unread')); ?> </li>
		<li><?php echo $html->link(__('Unreplyed', true) .' '.__('Messages', true), array('controller'=> 'messages', 'action'=>'index', 'user_id:' . $this->passedArgs['user_id'] . '/message_filter:unreplyed')); ?> </li>
		<li><?php echo $html->link(__('Read', true)      .' '.__('Messages', true), array('controller'=> 'messages', 'action'=>'index', 'user_id:' . $this->passedArgs['user_id'] . '/message_filter:read')); ?> </li>
		<li>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $html->link(__('Send', true)      .' '.__('Messages', true), array('controller'=> 'messages', 'action'=>'index', 'user_id:' . $this->passedArgs['user_id'] . '/message_filter:send')); ?> </li>
		<li>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $html->link(__('Trashed', true) .' '.__('Messages', true), array('controller'=> 'messages', 'action'=>'index', 'user_id:' . $this->passedArgs['user_id'] . '/message_filter:trashed')); ?> </li>
		<?php endif;?>
	</ul>
	<ul>
		<li><?php echo $html->link(__('Back', true), array('action'=>'back'));?> </li>
	</ul>
</div>