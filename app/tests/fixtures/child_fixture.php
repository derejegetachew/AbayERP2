<?php
/* Child Fixture generated on: 2013-03-07 11:03:05 : 1362654905 */
class ChildFixture extends CakeTestFixture {
	var $name = 'Child';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'first_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'last_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'sex' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 9),
		'birth_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'first_name' => 'Lorem ipsum dolor sit amet',
			'last_name' => 'Lorem ipsum dolor sit amet',
			'sex' => 'Lorem i',
			'birth_date' => '2013-03-07',
			'employee_id' => 1
		),
	);
}
?>