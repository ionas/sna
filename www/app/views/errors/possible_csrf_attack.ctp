<h2><?php __('Error 400'); ?></h2>
<p class="error">
	<strong><?=env('SERVER_NAME')?> <?php __('prevented a possible CSRF attack'); ?></strong>
	<a href="<?=$backUrl?>"><?=__('Back')?></a>
</p>