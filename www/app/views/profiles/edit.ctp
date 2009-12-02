<div class="profiles form">
<?=$form->create('Profile', array('type' => 'file'))?>
	<fieldset>
 		<legend><?php __('Profile')?></legend>
	<?=$form->input('id'),
		$form->input('is_hidden', array('label' => 'Invisible?')),
		$form->input('nickname')?>
<?php
if (file_exists(APP . DS . WEBROOT_DIR
	. '/data/img/profiles/' . $this->data['Profile']['id'] . '_medium')) {
	echo $html->image('/data/img/profiles/' . $this->data['Profile']['id'] . '_medium', array(
				'alt' => __('Your Picture', true),
				'border' => '0',
				'class' => 'avatar picture')),
		$form->label('picture_do_delete', __('Delete Picture?', true)),
		$form->checkbox('picture_do_delete');
	}
	echo $form->input('picture', array('label' => 'Your Picture', 'type' => 'file', 'size' => '50',
	'before' => '<input type="hidden" name="MAX_FILE_SIZE" value="' .  50 * 1024 . '" />'));
	// TODO: http://mypictr.com/ reference
?>
	<?=$form->input('birthday', array(
				'dateFormat' => 'DMY',
				'timeFormat' => 'none',
				'minYear' => date('Y') - 130,
				'maxYear' => date('Y') - 5 ,
				'selected' => array(
					'year' => date('Y') - 30,
					'month' => '06',
					'day' => '28'))),
		$form->input('gender_id'),
		$form->input('location')?>
		<!-- TODO: Timezone -->
		<!-- TODO: Country -->
		<!-- TODO: About you / Description -->
		<!-- TODO: Homepage -->
	</fieldset>
<?=$form->end('Save')?>
</div>