<div class="profiles form">
<?=$form->create('Profile', array('type' => 'file'))?>
	<fieldset>
 		<legend><?php __('Profile')?></legend>
	<?=$form->input('id'),
		$form->input('is_hidden', array('label' => 'Hide my profile')),
		$form->input('nickname')?>
	<?php if(true):?>
	<!-- TODO: Display Picture -->
	<!-- TODO: Delete Picture Checkbox -->
	<!-- TODO: http://mypictr.com/ reference -->
	<?php endif;?>
 	<?=$form->input('picture', array('label' => 'Your Picture', 'type' => 'file', 'size' => '50',
		'before' => '<input type="hidden" name="MAX_FILE_SIZE" value="' .  50 * 1024 . '" />')),
		$form->input('birthday', array(
				'dateFormat' => 'DMY',
				'timeFormat' => 'none',
				'minYear' => date('Y') - 130,
				'maxYear' => date('Y') - 5 ,
				'selected' => array(
					'year' => date('Y') - 30,
					'month' => '06',
					'day' => '28'))),
		$form->input('location')?>
		<!-- TODO: Timezone -->
		<!-- TODO: Country -->
		<!-- TODO: About you / Description -->
		<!-- TODO: Homepage -->
	</fieldset>
<?=$form->end('Save')?>
</div>