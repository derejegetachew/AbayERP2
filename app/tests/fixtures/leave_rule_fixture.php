<?php
/* LeaveRule Fixture generated on: 2013-04-03 00:04:20 : 1364947280 */
class LeaveRuleFixture extends CakeTestFixture {
	var $name = 'LeaveRule';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'leave_type_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'total' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'taken' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'balance' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'leave_type_id' => 1,
			'employee_id' => 1,
			'total' => 1,
			'taken' => 1,
			'balance' => 1
		),
	);
}
?>