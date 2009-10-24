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
	if ($shout['Shout']['is_deleted_by_shouter'] == 1) {
		$class = ' is_deleted_by_shouter' . $class;
	} else if ($shout['Shout']['is_hidden'] == 1) {
		$class = ' is_hidden' . $class;
	}
?>
	<li class="shout<?=$class?>">
		<p>
		<?php if(file_exists(WWW_ROOT . '/data/img/profiles/' . $shout['Shout']['from_profile_id'] . '_small')):?>
		<?=$html->image('/data/img/profiles/' . $shout['Shout']['from_profile_id'] . '_small', array(
			'alt' => __('Picture of', true) . ' ' . $shout['FromProfile']['nickname'],
			'url' => array('controller' => 'profiles', 'action' => 'view', $shout['Shout']['from_profile_id']),
		))?>
		<?php endif?>
		<?=$html->link($shout['FromProfile']['nickname'], array('action' => 'view', $shout['Shout']['from_profile_id']))?>
		on <?=substr($shout['Shout']['created'], 0, -3); ?>:
		</p>
		<p>
			<?=$shout['Shout']['body']; ?>
		</p>
		<p class="actions">
			<?php if($authedUser['Profile']['id'] == $shout['Profile']['id'] and $shout['Shout']['is_hidden'] == 0):?>
				<?=$html->link(__('Hide', true), array('action' => 'toggle_shout', $shout['Shout']['id'], 1), null, sprintf(__('Are you sure you want to hide # %s?', true), $shout['Shout']['id']))?>
			<?php elseif($authedUser['Profile']['id'] == $shout['Profile']['id'] and $shout['Shout']['is_hidden'] == 1):?>
				<?=$html->link(__('Unhide', true), array('action' => 'toggle_shout', $shout['Shout']['id'], 0), null, sprintf(__('Are you sure you want to unhide # %s?', true), $shout['Shout']['id']))?>
			<?php endif?>
			<?php if(($authedUser['Profile']['id'] == $shout['Profile']['id'] and $shout['Shout']['is_deleted'] == 0)
					or ($authedUser['Profile']['id'] == $shout['Shout']['from_profile_id'] and $shout['Shout']['is_deleted_by_shouter'] == 0)):?>
				<?=$html->link(__('Delete', true), array('action' => 'delete_shout', $shout['Shout']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $shout['Shout']['id']))?>
			<?php endif?>
		</p>
	</li>
<?php endforeach; ?>
</ul>
</div>
<?=$this->element('pagination_navigation', array('location' => 'bottom'))?> 