<div class="connections index">
<h2><?=$viewTitle?></h2>
<?php $paginator->options(array('url' => $this->passedArgs))?>
<?=$this->element('pagination_navigation', array('location' => 'top'))?> 
<table>
<?php if ($this->action == 'index'):?>
	<?=$this->element('../connections/_index_thead')?>
<?php elseif ($this->action == 'outgoing_requests'):?>
	<?=$this->element('../connections/_outgoing_requests_thead')?>
<?php elseif ($this->action == 'incoming_requests'):?>
	<?=$this->element('../connections/_incoming_requests_thead')?>
<?php endif?>
<?php
$i = 0;
foreach ($connections as $connection):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?=$class?>>
		<td>
			<?=$myhtml->dateMedium($connection['Connection']['modified'])?>
		</td>
		<td>
			<?php if ($connection['Profile']['id'] != $authedUser['Profile']['id']):?>
				<?=$html->link($connection['Profile']['nickname'], array('controller' => 'profiles', 'action' => 'view', $connection['Profile']['id']))?>
			<?php else:?>
				<?=$html->link($connection['ToProfile']['nickname'], array('controller' => 'profiles', 'action' => 'view', $connection['ToProfile']['id']))?>
			<?php endif?>
		</td>
		<td>
			<?=ucfirst(str_replace('_', ' ', __d('additions', $connection['Connection']['type'], true)))?>
		</td>
		<td style="text-align: left;">
			<table>
				<tr>
					<th>R</th>
					<th>Hidden Requester</th>
					<th>Hidden Requestee</th>
					<th>Ignored Requestee</th>
					<th>Deleted Requestee</th>
				</tr>
				<tr>
					<td><?=$connection['Connection']['is_request']?></td>
					<td><?=$connection['Connection']['is_hidden_by_requester']?></td>
					<td><?=$connection['Connection']['is_hidden_by_requestee']?></td>
					<td><?=$connection['Connection']['is_ignored_by_requestee']?></td>
					<td><?=$connection['Connection']['is_deleted_by_requestee']?></td>
				</tr>
			</table>
		</td>
		<td class="actions">
			<?php if ($this->action == 'index'):?>
				<?=$this->element('../connections/_index_actions', array('connection' => $connection))?>
			<?php elseif ($this->action == 'outgoing_requests'):?>
				<?=$this->element('../connections/_outgoing_requests_actions', array('connection' => $connection))?>
			<?php elseif ($this->action == 'incoming_requests'):?>
				<?=$this->element('../connections/_incoming_requests_actions', array('connection' => $connection))?>
			<?php endif?>
		</td>
	</tr>
<?php endforeach?>
</table>
</div>
<?=$this->element('pagination_navigation', array('location' => 'bottom'))?> 
