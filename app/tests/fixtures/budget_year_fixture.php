<?php
/* BudgetYear Fixture generated on: 2013-04-05 02:04:06 : 1365127446 */
class BudgetYearFixture extends CakeTestFixture {
	var $name = 'BudgetYear';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'from_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'to_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'from_date' => '2013-04-05',
			'to_date' => '2013-04-05',
			'name' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>