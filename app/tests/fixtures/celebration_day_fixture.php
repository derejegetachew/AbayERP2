<?php
/* CelebrationDay Fixture generated on: 2013-04-05 02:04:26 : 1365127466 */
class CelebrationDayFixture extends CakeTestFixture {
	var $name = 'CelebrationDay';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'day' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'budget_year_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'day' => '2013-04-05',
			'name' => 'Lorem ipsum dolor sit amet',
			'budget_year_id' => 1
		),
	);
}
?>