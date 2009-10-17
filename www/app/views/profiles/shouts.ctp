<div class="shouts index" id="shouts">
<h2><?php __('Shouts')?></h2>
<?php $paginator->options(array('url' => $this->passedArgs))?>
<?=$this->element('pagination_navigation', array('location' => 'top'))?> 
<?=__('Sort by')?> 
<?=$paginator->sort(__('Date', true), 'Shout.created')?> or
<?=$paginator->sort(__('Nickname', true), 'FromProfile.nickname')?>
<ul>
<?php
$i = 0;
foreach ($shouts as $shout):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
	}
	if ($shout['Shout']['is_hidden_by_shouter'] == 0) {
		$class = ' hidden_shout_by_shouter' . $class;
	} else if ($shout['Shout']['is_hidden'] == 0) {
		$class = ' hidden_shout' . $class;
	}
?>
	<li class="shout<?=$class?>">
		<p>
			<a href="/profiles/view/<?=$shout['Shout']['from_profile_id']?>">
				<img src="/data/img/profiles/<?=$shout['Shout']['from_profile_id']?>_small" />
				<?=$shout['FromProfile']['nickname']; ?>
			</a> on
			<?=substr($shout['Shout']['created'], 0, -3); ?>:
		</p>
		<p>
			<?=$shout['Shout']['body']; ?>
		</p>
		<p class="actions">
			<?php if($shout['Shout']['is_hidden'] == 0):?>
				<?=$html->link(__('Hide', true), array('action' => 'toggle_shout', $shout['Shout']['id'], 1), null, sprintf(__('Are you sure you want to hide # %s?', true), $shout['Shout']['id'])); ?>
			<?php else:?>
				<?=$html->link(__('Hide', true), array('action' => 'toggle_shout', $shout['Shout']['id'], 0), null, sprintf(__('Are you sure you want to unhide # %s?', true), $shout['Shout']['id'])); ?>
			<?php endif?>
			<?php if($shout['Shout']['is_deleted'] != 1):?>
				<?=$html->link(__('Delete', true), array('action' => 'delete_shout', $shout['Shout']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $shout['Shout']['id'])); ?>
			<?php endif?>
		</p>
	</li>
<?php endforeach; ?>
</ul>
</div>
<?=$this->element('pagination_navigation', array('location' => 'bottom'))?> 