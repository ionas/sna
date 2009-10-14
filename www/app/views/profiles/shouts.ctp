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
		$class = ' class="altrow"';
	}
?>
	<li<?=$class?>>
		<p>
			<img src="/data/img/profiles/<?=$shout['Shout']['from_profile_id']?>_small" />
			<?=$shout['FromProfile']['nickname']; ?> on
			<?=substr($shout['Shout']['created'], 0, -3); ?>:
		</p>
		<p>
			<?=$shout['Shout']['body']; ?>
		</p>
			<?=$shout['Shout']['is_deleted']; ?>
			<?=$shout['Shout']['is_hidden']; ?>
			<?=$shout['Shout']['is_deleted_by_shouter']; ?>
		<p class="actions">
			<?=$html->link(__('Hide', true), array('action' => 'toggle_shout', $shout['Shout']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $shout['Shout']['id'])); ?>
			<?=$html->link(__('Delete', true), array('action' => 'delete_shout', $shout['Shout']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $shout['Shout']['id'])); ?>
		</p>
	</li>
<?php endforeach; ?>
</ul>
</div>
<?=$this->element('pagination_navigation', array('location' => 'bottom'))?> 