<?php
/* EmployeeDetail Fixture generated on: 2013-03-06 17:03:37 : 1362592117 */
class EmployeeDetailFixture extends CakeTestFixture {
	var $name = 'EmployeeDetail';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'grade_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'step_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'position_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'start_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'employee_id' => 1,
			'grade_id' => 1,
			'step_id' => 1,
			'position_id' => 1,
			'start_date' => '2013-03-06'
		),
	);
}
?>