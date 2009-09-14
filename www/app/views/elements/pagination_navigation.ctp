<div class="paging<?=(isset($location)) ? ' ' . $location : ''?>">
	<?=$paginator->prev('← ' . __('previous', true), array(), null, array('class' => 'disabled'))?> 
	<?=$paginator->numbers(array('separator' => ''))?> 
	<?=$paginator->next(__('next', true) . '  →', array(), null, array('class' => 'disabled'))?> 
</div>