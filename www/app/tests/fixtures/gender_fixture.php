<?php 
/* SVN FILE: $Id$ */
/* Gender Fixture generated on: 2009-12-01 17:12:28 : 1259683228*/

class GenderFixture extends CakeTestFixture {
	var $name = 'Gender';
	var $table = 'genders';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'key' => 'primary'),
		'is_hidden' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'label' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'unique'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'UNIQUE_GENDER_LABEL' => array('column' => 'label', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'is_hidden'  => 1,
		'label'  => 'Lorem ipsum dolor '
	));
}
?>