<thead>
<tr>
	<th><?=$paginator->sort(___('Date'), 'modified')?></th>
	<th><?=$paginator->sort(___('With'), 'to_profile_id')?></th>
	<th><?=$paginator->sort(___('Type'), 'type')?></th>
	<th><?__('Flags')?></th>
	<th class="actions"><?php __('Actions')?></th>
</tr>
</thead>