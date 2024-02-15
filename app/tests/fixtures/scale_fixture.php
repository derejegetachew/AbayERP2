<?php
/* Scale Fixture generated on: 2013-02-21 16:02:11 : 1361463971 */
class ScaleFixture extends CakeTestFixture {
	var $name = 'Scale';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'grade_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'step_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'salary' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'grade_id' => 1,
			'step_id' => 1,
			'salary' => 1
		),
	);
}
?>