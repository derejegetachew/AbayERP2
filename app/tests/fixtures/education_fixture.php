<?php
/* Education Fixture generated on: 2013-03-06 17:03:41 : 1362592061 */
class EducationFixture extends CakeTestFixture {
	var $name = 'Education';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'level_of_attainment' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'field_of_study' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'institution' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'from_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'to_date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'is_bank_related' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 10),
		'employee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'level_of_attainment' => 'Lorem ipsum dolor sit amet',
			'field_of_study' => 'Lorem ipsum dolor sit amet',
			'institution' => 'Lorem ipsum dolor sit amet',
			'from_date' => '2013-03-06',
			'to_date' => '2013-03-06',
			'is_bank_related' => 'Lorem ip',
			'employee_id' => 1
		),
	);
}
?>