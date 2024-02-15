<?php
/* Holiday Fixture generated on: 2013-03-28 07:03:55 : 1364457115 */
class HolidayFixture extends CakeTestFixture {
	var $name = 'Holiday';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'type' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'from_date' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'to_date' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'filled_date' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'status' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'id' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'type' => 1,
			'from_date' => 1,
			'to_date' => 1,
			'filled_date' => 1,
			'status' => 1
		),
	);
}
?>